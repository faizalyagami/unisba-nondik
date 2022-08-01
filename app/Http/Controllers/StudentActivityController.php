<?php

namespace App\Http\Controllers;

use App\Models\Activity;
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
        $active = "student-activities";
        $sub_active = "student-activities";
        $status = [0 => 'Semua', 'Open', 'Review', 'Approve', 'Reject'];

        $user = auth()->user();

        $search_text = $request->search_text;
        $search_status = $request->search_status !== null ? $request->search_status : 0;

        $studentActivities = StudentActivity::with([
                'subActivity', 'student'
            ])
            ->when($user->level == 3, function($q) use($user) {
                $q->where('student_id', $user->student_id);
            })
            ->when($search_status != 0, function($q) use($search_status) {
                $q->where('status', $search_status);
            })
            ->paginate(20)
            ->withQueryString();

        return view('pages.students.activities.index', compact(
            'active', 'sub_active', 'status', 
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
        if($user->level == 2) {
            abort(403);
        }

        $activities = Activity::with([
                'subActivities' => function($q) {
                    $q->where('status', 1);
                }
            ])
            ->where('status', 1)
            ->orderBy('name')
            ->get();

        return view('pages.students.activities.create', compact(
            'active', 'sub_active', 
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
        ]);

        $user = auth()->user();
        if($user->level == 2) {
            abort(403);
        }

        try {
            DB::transaction(function() use($request, $user) {
                $message = new StudentActivity();
                $message->student_id = $user->student_id;
                $message->sub_activity_id = $request->subActivity;
                if($request->notes) {
                    $message->notes = $request->notes;
                }

                if($request->attachment) {
                    $value = $request->attachment;
                    $file_name = date('YmdHis') .'.'. $value->getClientOriginalExtension();
                    $folder_path = public_path('uploads/attachments');

                    $message->attachment = $file_name;
                }

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

                if($request->attachment) {
                    $fileSystem = new Filesystem();
                    if (!$fileSystem->exists($folder_path)) {
                        $fileSystem->makeDirectory($folder_path, 0777, true, true);
                    }
                    $value->move($folder_path, $file_name);
                }
            });

            $request->session()->flash('success', 'Data has been added successfully');
            return redirect()->route('student.activity.index');
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
        $levels = [1 => 'Admin', 'Reveiewer', 'User'];
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
        if($user->level == 2) {
            abort(403);
        }
        
        $activities = Activity::with([
            'subActivities' => function($q) {
                $q->where('status', 1);
            }
        ])
        ->where('status', 1)
        ->orderBy('name')
        ->get();

        return view('pages.students.activities.edit', compact(
            'active', 'sub_active', 'activities', 'studentActivity'
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
        ]);

        $user = auth()->user();
        if($user->level == 2) {
            abort(403);
        }

        try {
            DB::transaction(function() use($request, $studentActivity) {
                $message = StudentActivity::findOrFail($studentActivity->id);
                $message->sub_activity_id = $request->subActivity;
                $message->notes = $request->notes;

                if($request->attachment) {
                    $value = $request->attachment;
                    $file_name = date('YmdHis') .'.'. $value->getClientOriginalExtension();
                    $folder_path = public_path('uploads/attachments');

                    $message->attachment = $file_name;
                }
                
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

                if($request->attachment) {
                    $fileSystem = new Filesystem();
                    if (!$fileSystem->exists($folder_path)) {
                        $fileSystem->makeDirectory($folder_path, 0777, true, true);
                    }
                    $value->move($folder_path, $file_name);

                    $path = public_path() .'/uploads/attachments/'. $studentActivity->attachment;
                    if (file_exists($path)) {
                        unlink($path);
                    }
                }
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
