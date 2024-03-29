<?php

namespace App\Http\Controllers;

use App\Helpers\Helpers;
use App\Models\Information;
use App\Models\Reff;
use App\Models\Student;
use App\Models\StudentActivity;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use PDF;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $active = "home";
        $sub_active = "home";

        $user = auth()->user();
        $status = [0 => 'Semua', 'Open', 'Review', 'Approve', 'Reject'];
        $achievement = null;
        $result = "Belum Cukup";

        $needed = Reff::select('value', 'show')->where('status', 1)->where('name', 'minimalsks')->orderBy('value')->first();
        $ranges = Reff::select('value', 'show')->where('status', 1)->where('name', 'rangesks')->orderBy('id')->get()->toArray();

        if(in_array($user->level, [2, 3])) {
            $achievement = StudentActivity::selectRaw('sum(sks) as sks')
                ->join('sub_activities', 'sub_activities.id', 'student_activities.sub_activity_id')
                ->where('student_id', $user->student_id)
                ->where('student_activities.status', '3')
                ->first();

            $a = $achievement->sks;
            for($key = 0; $key < (count($ranges) - 1); ++$key) {
                if($a <= $ranges[$key + 1]['value'] && $a > $ranges[$key]['value']) {
                    $result = $ranges[$key]['show'];
                } else if($a > $ranges[$key + 1]['value']) {
                    $result = $ranges[$key + 1]['show'];
                }
            }
        }
        
        $studentActivities = StudentActivity::with([
                'subActivity', 'student'
            ])
            ->when(in_array($user->level, [2, 3]), function($q) use($user) {
                $q->where('student_id', $user->student_id);
            })
            ->orderBy('created_at', 'desc')
            ->limit(50)
            ->get();

        $information = Information::where('status', 1)
            ->orderBy('created_at', 'desc')
            ->first();

        $required = Reff::select('value', 'show')->where('status', 1)->where('name', 'RequiredActivity')->orderBy('value')->first();
        $requiredHas = 0;
        if(in_array($user->level, [2, 3])) {
            $req = StudentActivity::whereHas('subActivity', function($q) {
                    $q->whereRequired(true);
                })
                ->count();

            $requiredHas = $req;
        }

        return view('welcome', compact(
            'active', 'sub_active', 'status', 'studentActivities', 'result',
            'needed', 'achievement', 'information', 'required', 'requiredHas'
        ));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function profile()
    {
        $active = "";
        $sub_active = "";

        $user = auth()->user();
        $genders = Reff::select('value', 'show')->where('status', 1)->where('name', 'genders')->orderBy('value')->pluck('show', 'value')->toArray();
        $religions = Reff::select('value', 'show')->where('status', 1)->where('name', 'religions')->orderBy('value')->pluck('show', 'value')->toArray();

        $student = User::with([
                'student' => function($q) use($user) {
                    $q->where('id', $user->student_id);
                }
            ])
            ->where('id', $user->id)
            ->first();

        return view('pages.profiles.index', compact(
            'active', 'sub_active', 'genders', 'religions', 
            'student'
        ));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function editProfile()
    {
        $active = "";
        $sub_active = "";

        $user = auth()->user();

        if(in_array($user->level, [1, 4])) {
            return redirect()->route('user.edit', $user);
        }

        $genders = Reff::select('value', 'show')->where('status', 1)->where('name', 'genders')->orderBy('value')->get();
        $religions = Reff::select('value', 'show')->where('status', 1)->where('name', 'religions')->orderBy('value')->get();

        $student = Student::where('id', $user->student_id)
            ->first();

        return view('pages.profiles.edit', compact(
            'active', 'sub_active', 'genders', 'religions', 
            'student'
        ));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function updateProfile(Request $request)
    {
        $user = auth()->user();

        $this->validate($request, [
            'name' => ['required'], 
            'phone' => ['required'], 
            'email' => ['required', 'unique:students,email,'. $user->student_id], 
            'address' => ['required'], 
            'gender' => ['required'], 
            'religion' => ['required'], 
            'date_of_birth' => ['required'], 
        ]);

        try {
            DB::transaction(function() use($request, $user) {
                $file = $request->file('photo');
                if($file) {
                    $value = $file;
                    $file_name = date('YmdHis') .'.'. $value->getClientOriginalExtension();
                    $folder_path = public_path('uploads/profiles');
                }

                $message = Student::findOrFail($user->student_id);
                $message->name = $request->name;
                $message->phone = $request->phone;
                $message->email = $request->email;
                $message->address = $request->address;
                $message->gender = $request->gender;
                $message->religion = $request->religion;
                if($request->date_of_birth) {
                    $message->date_of_birth = $request->date_of_birth;
                }
                if($file) {
                    $message->photo = $file_name;
                }
                $message->editor = auth()->user()->username;
                $message->save();

                if($file) {
                    $fileSystem = new Filesystem();
                    if (!$fileSystem->exists($folder_path)) {
                        $fileSystem->makeDirectory($folder_path, 0777, true, true);
                    }
                    $value->move($folder_path, $file_name);
                }
            });

            $request->session()->flash('success', 'Student has been update successfully');
            return redirect()->route('profile.index');
        } catch (\Throwable $th) {
            $request->session()->flash('error', 'Something wrong happend.');
            return redirect()->route('profile.index');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function editPasswordProfile()
    {
        $active = "";
        $sub_active = "";

        $user = auth()->user();

        return view('pages.profiles.edit-password', compact(
            'active', 'sub_active'
        ));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function updatePasswordProfile(Request $request)
    {
        $user = auth()->user();

        $this->validate($request, [
            'password' => ['required', 'confirmed'], 
        ]);

        try {
            $message = User::findOrFail($user->id);
            $message->password = Hash::make($request->password);
            $message->editor = auth()->user()->username;
            $message->save();

            $request->session()->flash('success', 'Password has been update successfully');
            return redirect()->route('profile.index');
        } catch (\Throwable $th) {
            $request->session()->flash('error', 'Something wrong happend.');
            return redirect()->route('profile.index');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function printCertificate(Request $request)
    {
        $active = "";
        $sub_active = "";

        $user = auth()->user();
        $genders = Reff::select('value', 'show')->where('status', 1)->where('name', 'genders')->orderBy('value')->pluck('show', 'value')->toArray();
        $religions = Reff::select('value', 'show')->where('status', 1)->where('name', 'religions')->orderBy('value')->pluck('show', 'value')->toArray();
        $year = Reff::select('value', 'show')->where('status', 1)->where('name', 'tahunajaran')->orderBy('value')->first();
        $ranges = Reff::select('value', 'show')->where('status', 1)->where('name', 'rangesks')->orderBy('id')->get()->toArray();
        $current_year = Carbon::now()->format("Y");
        $result = 'Belum Cukup';

        $achievement = StudentActivity::selectRaw('sum(sks) as sks')
            ->with(['student'])
            ->join('sub_activities', 'sub_activities.id', 'student_activities.sub_activity_id')
            ->where('student_id', $user->student_id)
            ->where('student_activities.status', '3')
            ->first();

        $a = $achievement->sks;
        for($key = 0; $key < (count($ranges) - 1); ++$key) {
            if($a <= $ranges[$key + 1]['value'] && $a > $ranges[$key]['value']) {
                $result = $ranges[$key]['show'];
            } else if($a > $ranges[$key + 1]['value']) {
                $result = $ranges[$key + 1]['show'];
            }
        }

        if ($result === 'Belum Cukup') {
            return redirect()->route('home');
        }

        $months = [1 => "Januari", "Febuari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];
        $rome_months = [1 => "I", "II", "III", "IV", "V", "VI", "VII", "VIII", "IX", "X", "XI", "XII"];
        $month_rome = $rome_months[Carbon::now()->format("n")];
        
        $student = Student::where('id', $user->student_id)
        ->first();
        
        $date = date("d", strtotime($student->certificate_approve_date)) ." ". $months[date("n", strtotime($student->certificate_approve_date))] ." ". date("Y", strtotime($student->certificate_approve_date));
        
        if($request->has('download')) {
            $pdf = PDF::loadView('pages.profiles.print-certificate', compact(
                'active', 'sub_active', 'genders', 'religions', 'year', 
                'achievement', 'student', 'date', 'result', 'current_year', 'month_rome'
            ))->setPaper('a4', 'landscape');
        
            return $pdf->download('sertificate.pdf');
        }
        
        return view('pages.profiles.print-certificate', compact(
            'active', 'sub_active', 'genders', 'religions', 'year', 
            'achievement', 'student', 'date', 'result', 'current_year', 'month_rome'
        ));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function template()
    {
        $active = "";
        $sub_active = "";

        $user = auth()->user();

        return view('template', compact(
            'active', 'sub_active'
        ));
    }

    public function generatePDF()
    {
        $active = "";
        $sub_active = "";

        $user = auth()->user();
        $genders = Reff::select('value', 'show')->where('status', 1)->where('name', 'genders')->orderBy('value')->pluck('show', 'value')->toArray();
        $religions = Reff::select('value', 'show')->where('status', 1)->where('name', 'religions')->orderBy('value')->pluck('show', 'value')->toArray();
        $year = Reff::select('value', 'show')->where('status', 1)->where('name', 'tahunajaran')->orderBy('value')->first();
        $ranges = Reff::select('value', 'show')->where('status', 1)->where('name', 'rangesks')->orderBy('id')->get()->toArray();
        $current_year = Carbon::now()->format("Y");
        $result = 'Belum Cukup';

        $achievement = StudentActivity::selectRaw('sum(sks) as sks')
            ->with(['student'])
            ->join('sub_activities', 'sub_activities.id', 'student_activities.sub_activity_id')
            ->where('student_id', $user->student_id)
            ->where('student_activities.status', '3')
            ->first();

        $a = $achievement->sks;
        for($key = 0; $key < (count($ranges) - 1); ++$key) {
            if($a <= $ranges[$key + 1]['value'] && $a > $ranges[$key]['value']) {
                $result = $ranges[$key]['show'];
            } else if($a > $ranges[$key + 1]['value']) {
                $result = $ranges[$key + 1]['show'];
            }
        }

        if ($result === 'Belum Cukup') {
            return redirect()->route('home');
        }

        $months = [1 => "Januari", "Febuari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];
        $rome_months = [1 => "I", "II", "III", "IV", "V", "VI", "VII", "VIII", "IX", "X", "XI", "XII"];
        $month_rome = $rome_months[Carbon::now()->format("n")];
        
        $student = Student::where('id', $user->student_id)
        ->first();
        
        $date = date("d", strtotime($student->certificate_approve_date)) ." ". $months[date("n", strtotime($student->certificate_approve_date))] ." ". date("Y", strtotime($student->certificate_approve_date));
          
        $pdf = Pdf::loadView('pages.profiles.print-certificate-pdf', compact(
            'active', 'sub_active', 'genders', 'religions', 'year', 
            'achievement', 'student', 'date', 'result', 'current_year', 'month_rome'
        ))->setPaper('a4', 'landscape');
    
        return $pdf->download('sertificate.pdf');
    }

}
