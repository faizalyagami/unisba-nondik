<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\Reff;
use App\Models\Student;
use App\Models\StudentActivity;
use App\Models\StudentActivityLog;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class StudentActivityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $user = auth()->user();
        if($user->level == 3) {
            abort(403);
        }

        $active = "student-activities";
        $sub_active = "student-activities";
        $classofs = Student::select('class_of')->groupBy('class_of')->pluck('class_of');
        $classofs = [0 => 'Semua'] + $classofs->toArray();
        $peoples = Student::orderBy('name')->pluck('name', 'id');
        $peoples = [0 => 'Semua'] + $peoples->toArray();


        $search_text = $request->search_text;
        $search_classof = $request->search_classof ? $request->search_classof : 'Semua';
        $search_people = $request->search_people ? $request->search_people : 'Semua';

        $needed = Reff::select('value', 'show')->where('status', 1)->where('name', 'minimalsks')->orderBy('value')->first();

        $students = Student::select('id', 'npm', 'name', 'phone', 'gender', 'class_of', 'period', 'certificate_approve', 'status')
            ->selectRaw('(
                select sum(sks) 
                from student_activities 
                join sub_activities on sub_activities.id = student_activities.sub_activity_id 
                where student_activities.student_id = students.id and  student_activities.status = 3) as sumsks')
            ->where(function ($q) use($search_text) {
                $q->whereRaw('name like ?', ['%'. $search_text .'%'])
                ->orWhereRaw('npm like ?', ['%'. $search_text .'%']);
            })
            ->when($search_classof != 'Semua', function($q) use($search_classof) {
                $q->where('class_of', $search_classof);
            })
            ->when($search_people != 'Semua', function($q) use($search_people) {
                $q->where('id', $search_people);
            })
            ->where('status', 1)
            ->withCount(['studentActivities as open' => function($q) {
                    $q->where('status', 1);
                },
                'studentActivities as review' => function($q) {
                    $q->where('status', 2);
                }, 
                'studentActivities as approve' => function($q) {
                    $q->where('status', 3);
                }, 
                'studentActivities as reject' => function($q) {
                    $q->where('status', 4);
                }
            ])
            ->orderBy('name')
            ->paginate(20)
            ->withQueryString();

        return view('pages.students.activities.index', compact(
            'active', 'sub_active', 'classofs', 'students', 'user', 
            'search_text', 'search_classof', 'needed', 'peoples', 'search_people'
        ));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function details(Request $request)
    {
        $active = "student-activities";
        $sub_active = "student-activities";
        $status = [0 => 'Semua', 'Open', 'Review', 'Approve', 'Reject'];
        $required = Reff::select('value', 'show')->where('status', 1)->where('name', 'RequiredActivity')->orderBy('value')->first();

        $user = auth()->user();

        $search_text = $request->search_text;
        $search_status = $request->search_status !== null ? $request->search_status : 0;

        $studentActivities = StudentActivity::with([
                'subActivity', 'student'
            ])
            ->whereHas('student', function ($q) use($search_text) {
                $q->whereRaw('name like ?', ['%'. $search_text .'%'])
                ->orWhereRaw('npm like ?', ['%'. $search_text .'%']);
            })
            ->when($user->level == 3, function($q) use($user) {
                $q->where('student_id', $user->student_id);
            })
            ->when($search_status != 0, function($q) use($search_status) {
                $q->where('status', $search_status);
            })
            ->paginate(20)
            ->withQueryString();

        $requiredHas = 0;
        if(in_array($user->level, [2, 3])) {
            $req = StudentActivity::whereHas('subActivity', function($q) {
                    $q->whereRequired(true);
                })
                ->count();

            $requiredHas = $req;
        }


        return view('pages.students.activities.details', compact(
            'active', 'sub_active', 'status', 'required', 'requiredHas', 
            'search_text', 'search_status', 'studentActivities'
        ));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $active = "student-activities";
        $sub_active = "student-activities";

        $user = auth()->user();

        $activities = Activity::with([
                'subActivities' => function($q) {
                    $q->where('status', 1);
                }
            ])
            ->where('status', 1)
            ->orderBy('name')
            ->get();

        return view('pages.students.activities.create', compact(
            'active', 'sub_active', 'user', 
            'activities'
        ));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'subActivity' => ['required'], 
            'notes' => ['required'], 
            'organizer' => ['required'], 
            'place' => ['required'], 
            'held_date' => ['required'], 
            'participation' => ['required'], 
            'attachment' => ['required'], 
            'organizer' => ['required'],
            'place' => ['required'],
            'held_date' => ['required'],
            'participation' => ['required']
        ]);

        $user = auth()->user();

        try {
            DB::transaction(function() use($request, $user) {
                $message = new StudentActivity();
                $message->student_id = $user->student_id;
                $message->sub_activity_id = $request->subActivity;
                if($request->notes) {
                    $message->notes = $request->notes;
                }

                $message->organizer = $request->organizer;
                $message->place = $request->place;
                $message->held_date = $request->held_date;
                $message->participation = $request->participation;
                $message->attachment = $request->attachment;
                $message->organizer = $request->organizer;
                $message->place = $request->place;
                $message->held_date = $request->held_date;
                $message->participation = $request->participation;
                $message->creator = auth()->user()->username;
                $message->editor = auth()->user()->username;
                $message->save();

                $log = new StudentActivityLog();
                $log->status = 1;
                $log->sub_activity_id = $request->subActivity;
                if($request->notes) {
                    $log->notes = $request->notes;
                }
                $log->creator = auth()->user()->username;
                $log->editor = auth()->user()->username;
                $message->studentActivityLogs()->save($log);
            });

            $request->session()->flash('success', 'Data has been added successfully');
            if($user->level == 3) {
                return redirect()->route('student.activity.details');
            } else {
                return redirect()->route('student.activity.index');
            }
        } catch (\Throwable $th) {
            $request->session()->flash('error', 'Something wrong happend.');
            return redirect()->route('student.activity.create');
        }
        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\StudentActivity  $studentActivity
     * @return \Illuminate\Http\Response
     */
    public function show(StudentActivity $studentActivity)
    {
        $active = "student-activities";
        $sub_active = "student-activities";
        $status = [1 => 'Open', 'Review', 'Approve', 'Reject'];
        $levels = [1 => 'Admin', 'Reviewer', 'User', 'Wadek'];
        $user = auth()->user();

        return view('pages.students.activities.show', compact(
            'active', 'sub_active', 'status', 'levels', 'user', 'studentActivity'
        ));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\StudentActivity  $studentActivity
     * @return \Illuminate\Http\Response
     */
    public function edit(StudentActivity $studentActivity)
    {
        $active = "student-activities";
        $sub_active = "student-activities";

        $user = auth()->user();
        
        $activities = Activity::with([
            'subActivities' => function($q) {
                $q->where('status', 1);
            }
        ])
        ->where('status', 1)
        ->orderBy('name')
        ->get();

        return view('pages.students.activities.edit', compact(
            'active', 'sub_active', 'activities', 'studentActivity', 'user'
        ));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\StudentActivity  $studentActivity
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, StudentActivity $studentActivity)
    {
        $this->validate($request, [
            'subActivity' => ['required'], 
            'notes' => ['required'], 
            'organizer' => ['required'], 
            'place' => ['required'], 
            'held_date' => ['required'], 
            'participation' => ['required'], 
            'attachment' => ['required'], 
            'organizer' => ['required'],
            'place' => ['required'],
            'held_date' => ['required'],
            'participation' => ['required']
        ]);

        try {
            DB::transaction(function() use($request, $studentActivity) {
                $message = StudentActivity::findOrFail($studentActivity->id);
                $message->sub_activity_id = $request->subActivity;
                $message->notes = $request->notes;
                $message->organizer = $request->organizer;
                $message->place = $request->place;
                $message->held_date = $request->held_date;
                $message->participation = $request->participation;
                $message->attachment = $request->attachment;
                $message->organizer = $request->organizer;
                $message->place = $request->place;
                $message->held_date = $request->held_date;
                $message->participation = $request->participation;
                $message->editor = auth()->user()->username;
                $message->save();

                $log = new StudentActivityLog();
                $log->student_activity_id = $studentActivity->id;
                $log->status = 1;
                $log->sub_activity_id = $request->subActivity;
                $log->notes = $request->notes;
                $log->creator = auth()->user()->username;
                $log->editor = auth()->user()->username;
                $log->save();
            });

            $request->session()->flash('success', 'Data has been updated.');
            return redirect()->route('student.activity.show', [$studentActivity->id]);
        } catch (\Throwable $th) {
            $request->session()->flash('error', 'Something wrong happend.');
            return redirect()->route('student.activity.edit', [$studentActivity->id]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\StudentActivity  $studentActivity
     * @return \Illuminate\Http\Response
     */
    public function approve(Request $request, StudentActivity $studentActivity)
    {
        $this->validate($request, [
            'notes' => ['required'], 
        ]);

        $user = auth()->user();
        if($user->level == 3) {
            abort(403);
        }

        try {
            DB::transaction(function() use($request, $studentActivity) {
                $status = 3;
                if($request->action == 'Reject') {
                    $status = 4;
                }
                $message = StudentActivity::findOrFail($studentActivity->id);
                $message->status = $status;
                $message->editor = auth()->user()->username;
                $message->save();

                $log = new StudentActivityLog();
                $log->student_activity_id = $studentActivity->id;
                $log->status = $status;
                $log->sub_activity_id = $studentActivity->sub_activity_id;
                $log->notes = $request->notes;
                $log->creator = auth()->user()->username;
                $log->editor = auth()->user()->username;
                $log->save();
            });

            $request->session()->flash('success', 'Data has been '. $request->action .'ed.');
            return redirect()->route('student.activity.index');
        } catch (\Throwable $th) {
            $request->session()->flash('error', 'Something wrong happend.');
            return redirect()->route('student.activity.show', [$studentActivity->id]);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\StudentActivity  $studentActivity
     * @return \Illuminate\Http\Response
     */
    public function review(Request $request, StudentActivity $studentActivity)
    {
        $user = auth()->user();
        if($user->level == 3) {
            abort(403);
        }

        try {
            DB::transaction(function() use($request, $studentActivity) {
                $message = StudentActivity::findOrFail($studentActivity->id);
                $message->status = 2;
                $message->editor = auth()->user()->username;
                $message->save();

                $log = new StudentActivityLog();
                $log->student_activity_id = $studentActivity->id;
                $log->status = 2;
                $log->sub_activity_id = $studentActivity->sub_activity_id;
                $log->notes = $request->notes;
                $log->creator = auth()->user()->username;
                $log->editor = auth()->user()->username;
                $log->save();
            });

            $request->session()->flash('success', 'Data '. $request->action .'ed by '. auth()->user()->username .'.');
            return redirect()->route('student.activity.show', [$studentActivity->id]);
        } catch (\Throwable $th) {
            $request->session()->flash('error', 'Something wrong happend.');
            return redirect()->route('student.activity.show', [$studentActivity->id]);
        }
    }

}
