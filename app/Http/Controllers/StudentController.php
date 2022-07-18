<?php

namespace App\Http\Controllers;

use App\Exports\ExportFormatStudent;
use App\Models\Reff;
use App\Models\Student;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Http\Request;

use Maatwebsite\Excel\Facades\Excel as FacadesExcel;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $genders = Reff::select('value', 'show')->where('status', 1)->where('name', 'genders')->orderBy('value')->pluck('show', 'value');
        $genders = [0 => 'Semua'] + $genders->toArray();
        $religions = Reff::select('value', 'show')->where('status', 1)->where('name', 'religions')->orderBy('value')->pluck('show', 'value');
        $religions = [0 => 'Semua'] + $religions->toArray();
        $status = [0 => 'Semua', 1 => 'Aktif', 'Tidak Aktif'];

        $search_text = $request->search_text;
        $search_gender = $request->search_gender ? $request->search_gender : 0;
        $search_religion = $request->search_religion ? $request->search_religion : 0;
        $search_status = $request->search_status ? $request->search_status : 0;

        $students = Student::select('id', 'npm', 'name', 'phone', 'gender', 'status')
            ->where(function ($q) use($search_text) {
                $q->whereRaw('name ilike ?', ['%'. $search_text .'%'])
                ->orWhereRaw('npm ilike ?', ['%'. $search_text .'%']);
            })
            ->when($search_gender != 0, function($q) use($search_gender) {
                $q->where('gender', $search_gender);
            })
            ->when($search_religion != 0, function($q) use($search_religion) {
                $q->where('religion', $search_religion);
            })
            ->when($search_status != 0, function($q) use($search_status) {
                $q->where('status', $search_status);
            })
            ->orderBy('name')
            ->paginate(2)
            ->withQueryString();

        return view('pages.students.index', compact(
            'genders', 'religions', 'students', 'status', 
            'search_text', 'search_gender', 'search_religion', 'search_status'
        ));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $genders = Reff::select('value', 'show')->where('status', 1)->where('name', 'genders')->orderBy('value')->get();
        $religions = Reff::select('value', 'show')->where('status', 1)->where('name', 'religions')->orderBy('value')->get();

        return view('pages.students.create', compact('genders', 'religions'));
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
            'npm' => ['required', 'unique:students'], 
            'name' => ['required'], 
            'phone' => ['required'], 
            'address' => ['required'], 
            'gender' => ['required'], 
            'religion' => ['required'], 
            'date_of_birth' => ['required'], 
        ]);

        try {
            if($request->photo) {
                $value = $request->photo;
                $file_name = date('YmdHis') .'.'. $value->getClientOriginalExtension();
                $folder_path = public_path('uploads');
            }

            $message = new Student();
            $message->npm = $request->npm;
            $message->name = $request->name;
            $message->phone = $request->phone;
            $message->address = $request->address;
            $message->gender = $request->gender;
            $message->religion = $request->religion;
            if($request->date_of_birth) {
                $message->date_of_birth = $request->date_of_birth;
            }
            if($request->photo) {
                $message->photo = $file_name;
            }
            $message->creator = 'admin';
            $message->editor = 'sessionadmin';
            $message->save();

            if($request->photo) {
                $fileSystem = new Filesystem();
                if (!$fileSystem->exists($folder_path)) {
                    $fileSystem->makeDirectory($folder_path, 0777, true, true);
                }
                $value->move($folder_path, $file_name);
            }

            $request->session()->flash('success', 'Student has been added successfully');
            return redirect()->route('student.index');
        } catch (\Throwable $th) {
            $request->session()->flash('error', 'Something wrong happend.');
            return redirect()->route('student.create');
        }
        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function show(Student $student)
    {
        $genders = Reff::select('value', 'show')->where('status', 1)->where('name', 'genders')->orderBy('value')->pluck('show', 'value')->toArray();
        $religions = Reff::select('value', 'show')->where('status', 1)->where('name', 'religions')->orderBy('value')->pluck('show', 'value')->toArray();
        $status = [1 => 'Aktif', 'Tidak Aktif'];

        return view('pages.students.show', compact(
            'genders', 'religions', 'status', 'student'
        ));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function edit(Student $student)
    {
        $genders = Reff::select('value', 'show')->where('status', 1)->where('name', 'genders')->orderBy('value')->get();
        $religions = Reff::select('value', 'show')->where('status', 1)->where('name', 'religions')->orderBy('value')->get();
        $status = [1 => 'Aktif', 'Tidak Aktif'];

        return view('pages.students.edit', compact(
            'genders', 'religions', 'status', 'student'
        ));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Student $student)
    {
        $this->validate($request, [
            'npm' => ['required', 'unique:students,npm,'. $student->id], 
            'name' => ['required'], 
            'phone' => ['required'], 
            'address' => ['required'], 
            'gender' => ['required'], 
            'religion' => ['required'], 
            'date_of_birth' => ['required'], 
        ]);

        try {
            if($request->photo) {
                $value = $request->photo;
                $file_name = date('YmdHis') .'.'. $value->getClientOriginalExtension();
                $folder_path = public_path('uploads');
            }

            $message = Student::findOrFail($student->id);
            $message->npm = $request->npm;
            $message->name = $request->name;
            $message->phone = $request->phone;
            $message->address = $request->address;
            $message->gender = $request->gender;
            $message->religion = $request->religion;
            if($request->date_of_birth) {
                $message->date_of_birth = $request->date_of_birth;
            }
            if($request->photo) {
                $message->photo = $file_name;
            }
            $message->status = $request->status;
            $message->editor = 'sessionadmin';
            $message->save();

            if($request->photo) {
                $fileSystem = new Filesystem();
                if (!$fileSystem->exists($folder_path)) {
                    $fileSystem->makeDirectory($folder_path, 0777, true, true);
                }
                $value->move($folder_path, $file_name);
            }

            $request->session()->flash('success', 'Student has been update successfully');
            return redirect()->route('student.show', [$student->id]);
        } catch (\Throwable $th) {
            $request->session()->flash('error', 'Something wrong happend.');
            return redirect()->route('student.show', [$student->id]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function destroy(Student $student)
    {
        //
    }

    public function import()
    {
        $genders = Reff::select('value', 'show')->where('status', 1)->where('name', 'genders')->orderBy('value')->get();
        $religions = Reff::select('value', 'show')->where('status', 1)->where('name', 'religions')->orderBy('value')->get();

        return view('pages.students.import', compact('genders', 'religions'));
    }

    public function exportFormatStudent()
    {
        return FacadesExcel::download(new ExportFormatStudent, 'import_format_student.xlsx');
    }
}
