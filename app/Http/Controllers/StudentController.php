<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Reff;
use App\Models\User;
use App\Models\Student;
use App\Imports\DataImport;
use Illuminate\Http\Request;
use App\Exports\ExportStudents;
use Illuminate\Support\Facades\DB;
use App\Exports\ExportFormatStudent;
use App\Models\StudentActivity;
use App\Models\SubActivity;
use Illuminate\Support\Facades\Hash;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\Redirect;
use PhpOffice\PhpSpreadsheet\Shared\Date;
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
        $active = "students";
        $sub_active = "students";
        $genders = Reff::select('value', 'show')->where('status', 1)->where('name', 'genders')->orderBy('value')->pluck('show', 'value');
        $genders = [0 => 'Semua'] + $genders->toArray();
        $classofs = Student::select('class_of')->groupBy('class_of')->pluck('class_of');
        $classofs = [0 => 'Semua'] + $classofs->toArray();
        $status = [0 => 'Semua', 1 => 'Aktif', 'Tidak Aktif'];
        $pansus = [0 => 'Semua', 'No', 'Yes'];


        $search_text = $request->search_text;
        $search_gender = $request->search_gender ? $request->search_gender : 0;
        $search_classof = $request->search_classof ? $request->search_classof : 'Semua';
        $search_pansus = $request->search_pansus !== null ? $request->search_pansus : 0;
        $search_status = $request->search_status !== null ? $request->search_status : 1;

        $needed = Reff::select('value', 'show')->where('status', 1)->where('name', 'minimalsks')->orderBy('value')->first();
        $user = auth()->user();

        $students = Student::select('id', 'npm', 'name', 'email', 'phone', 'gender', 'class_of', 'period', 'certificate_approve', 'status')
            ->selectRaw('(
                select sum(sks) 
                from student_activities 
                join sub_activities on sub_activities.id = student_activities.sub_activity_id 
                where student_activities.student_id = students.id and  student_activities.status = 3) as sumsks')
            ->where(function ($q) use ($search_text) {
                $q->whereRaw('name like ?', ['%' . $search_text . '%'])
                    ->orWhereRaw('npm like ?', ['%' . $search_text . '%']);
            })
            ->when($search_gender != 0, function ($q) use ($search_gender) {
                $q->where('gender', $search_gender);
            })
            ->when($search_classof != 'Semua', function ($q) use ($search_classof) {
                $q->where('class_of', $search_classof);
            })
            ->when($search_pansus != 0, function ($q) use ($search_pansus) {
                $q->where('pansus', $search_pansus);
            })
            ->when($search_status != 0, function ($q) use ($search_status) {
                $q->where('status', $search_status);
            })
            ->withCount('studentActivities')
            ->orderBy('name')
            ->paginate(20)
            ->withQueryString();

        return view('pages.students.index', compact(
            'active',
            'sub_active',
            'genders',
            'classofs',
            'students',
            'status',
            'pansus',
            'user',
            'search_text',
            'search_gender',
            'search_classof',
            'search_status',
            'search_pansus',
            'needed'
        ));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $active = "students";
        $sub_active = "students";
        $genders = Reff::select('value', 'show')->where('status', 1)->where('name', 'genders')->orderBy('value')->get();
        $religions = Reff::select('value', 'show')->where('status', 1)->where('name', 'religions')->orderBy('value')->get();
        $years = collect(range(0, 10))->map(function ($item) {
            return (string) date('Y') - $item;
        });

        return view('pages.students.create', compact('active', 'sub_active', 'genders', 'religions', 'years'));
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
            'email' => ['required', 'unique:students'],
            'address' => ['required'],
            'gender' => ['required'],
            'religion' => ['required'],
            'date_of_birth' => ['required'],
            'class_of' => ['required'],
            'period' => ['required'],
        ]);

        try {
            DB::transaction(function () use ($request) {
                $file = $request->file('photo');
                if ($file) {
                    $value = $file;
                    $file_name = date('YmdHis') . '.' . $value->getClientOriginalExtension();
                    $folder_path = public_path('uploads/profiles');
                }

                $message = new Student();
                $message->npm = $request->npm;
                $message->name = $request->name;
                $message->phone = $request->phone;
                $message->email = $request->email;
                $message->address = $request->address;
                $message->gender = $request->gender;
                $message->religion = $request->religion;
                if ($request->date_of_birth) {
                    $message->date_of_birth = $request->date_of_birth;
                }
                if ($file) {
                    $message->photo = $file_name;
                }
                $message->class_of = $request->class_of;
                $message->period = $request->period;
                $message->creator = auth()->user()->username;
                $message->editor = auth()->user()->username;
                $message->save();

                if ($file) {
                    $fileSystem = new Filesystem();
                    if (!$fileSystem->exists($folder_path)) {
                        $fileSystem->makeDirectory($folder_path, 0777, true, true);
                    }
                    $value->move($folder_path, $file_name);
                }

                $user = new User();
                $user->name = $request->name;
                $user->username = $request->npm;
                $user->email = $request->email;
                $user->password = Hash::make("passwordnyabelumdisetting");
                $user->creator = auth()->user()->username;
                $user->editor = auth()->user()->username;
                $message->user()->save($user);
            });

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
        $active = "students";
        $sub_active = "students";
        $genders = Reff::select('value', 'show')->where('status', 1)->where('name', 'genders')->orderBy('value')->pluck('show', 'value')->toArray();
        $religions = Reff::select('value', 'show')->where('status', 1)->where('name', 'religions')->orderBy('value')->pluck('show', 'value')->toArray();
        $status = [1 => 'Aktif', 'Tidak Aktif'];
        $pansus = [1 => 'No', 'Yes'];
        $years = collect(range(0, 10))->map(function ($item) {
            return (string) date('Y') - $item;
        });

        return view('pages.students.show', compact(
            'active',
            'sub_active',
            'genders',
            'religions',
            'status',
            'pansus',
            'student',
            'years'
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
        $active = "students";
        $sub_active = "students";
        $genders = Reff::select('value', 'show')->where('status', 1)->where('name', 'genders')->orderBy('value')->get();
        $religions = Reff::select('value', 'show')->where('status', 1)->where('name', 'religions')->orderBy('value')->get();
        $status = [1 => 'Aktif', 'Tidak Aktif'];
        $pansus = [1 => 'No', 'Yes'];
        $years = collect(range(0, 10))->map(function ($item) {
            return (string) date('Y') - $item;
        });

        return view('pages.students.edit', compact(
            'active',
            'sub_active',
            'genders',
            'religions',
            'status',
            'pansus',
            'student',
            'years'
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
            'npm' => ['required', 'unique:students,npm,' . $student->id],
            'name' => ['required'],
            'phone' => ['required'],
            'email' => ['required', 'unique:students,email,' . $student->id],
            'address' => ['required'],
            'gender' => ['required'],
            'religion' => ['required'],
            'date_of_birth' => ['required'],
            'class_of' => ['required'],
            'period' => ['required'],
        ]);

        try {
            DB::transaction(function () use ($request, $student) {
                $file = $request->file('photo');
                if ($file) {
                    $value = $file;
                    $file_name = date('YmdHis') . '.' . $value->getClientOriginalExtension();
                    $folder_path = public_path('uploads/profiles');
                }

                $message = Student::findOrFail($student->id);
                $message->npm = $request->npm;
                $message->name = $request->name;
                $message->phone = $request->phone;
                $message->email = $request->email;
                $message->address = $request->address;
                $message->gender = $request->gender;
                $message->religion = $request->religion;
                if ($request->date_of_birth) {
                    $message->date_of_birth = $request->date_of_birth;
                }
                if ($file) {
                    $message->photo = $file_name;
                }
                $message->status = $request->status;
                $message->pansus = $request->pansus;
                $message->class_of = $request->class_of;
                $message->period = $request->period;
                $message->editor = auth()->user()->username;
                $message->save();

                if ($file) {
                    $fileSystem = new Filesystem();
                    if (!$fileSystem->exists($folder_path)) {
                        $fileSystem->makeDirectory($folder_path, 0777, true, true);
                    }
                    $value->move($folder_path, $file_name);
                }

                $user = User::where('student_id', $student->id)->first();
                $user->name = $request->name;
                $user->username = $request->npm;
                $user->email = $request->email;
                $user->level = $request->pansus;
                $user->editor = auth()->user()->username;
                $user->save();
            });

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
        $active = "students";
        $sub_active = "students";
        $genders = Reff::select('value', 'show')->where('status', 1)->where('name', 'genders')->orderBy('value')->get();
        $religions = Reff::select('value', 'show')->where('status', 1)->where('name', 'religions')->orderBy('value')->get();

        return view('pages.students.import', compact('active', 'sub_active', 'genders', 'religions'));
    }

    public function exportFormatStudent()
    {
        return FacadesExcel::download(new ExportFormatStudent, 'import_format_student.xlsx');
    }

    public function read(Request $request)
    {
        $result = ['message' => 'error', 'data' => 'Ups, terjadi kesalahan, refresh lalu coba lagi.'];

        $f_name = $request->cfu_file;
        $index = $request->index;
        $req_type = $request->req_type;

        if (!$req_type) {
            $file_name = 'import-students-' . date('YmdHis') . '.xlsx';
            $folder_path = storage_path('app/public/files/temp');
            $fileSystem = new Filesystem();
            if (!$fileSystem->exists($folder_path)) {
                $fileSystem->makeDirectory($folder_path, 0777, true, true);
            }

            $file_path = $folder_path . '/' . $file_name;
            $fileSystem->move($f_name->getPathname(), $file_path);

            try {
                $contents = '';
                $excel_rows = new DataImport();
                FacadesExcel::import($excel_rows, 'public/files/temp/' . $file_name);
                $rows = $excel_rows->getExcelRows();
                $filtered_rows = [];
                $row_count = 0;

                if (count($rows) > 0) {
                    foreach ($rows as $row) {
                        $emptyflag = false;
                        for ($cnt = 0; $cnt < 10; $cnt++) {
                            if ($row[$cnt] !== null && $row[$cnt] !== '') {
                                $emptyflag = true;
                            }
                        }

                        if ($emptyflag) {
                            $filtered_rows[] = $row->toArray();
                            $row_count++;
                        }
                    }
                }

                $total_data = $row_count - 1;
                $request->session()->forget('importStudents');
                $request->session()->forget('arr_type');
                $request->session()->put('importStudents', $filtered_rows);
                $fileSystem->delete($file_path);
                return response()->json(array('status' => 'success', 'counts' => $row_count));
            } catch (\Exception $e) {
                $fileSystem->delete($file_path);
                return response()->json(array('status' => 'failed', 'err_msg' => 'Error reading file!'));
            }
        } else {
            $rows = $request->session()->get('importStudents');
            $header = $rows[0];

            if ($header[0] == 'NPM' && $header[1] == 'Nama' && $header[2] == 'Angkatan' && $header[3] == 'Jenis Kelamin' && $header[4] == 'Agama' && $header[5] == 'Telepon' && $header[6] == 'Email' && $header[7] == 'Tanggal Lahir' && $header[8] == 'Alamat' && $header[9] == 'Periode Pengisian') {
                $table_contents = $index == 0 ? '<thead>' : ($index == 1 ? '<tbody>' : '');

                if ($rows) {
                    $contents = $rows[$index];

                    $flagEmpty = true;
                    $flagNumber = true;
                    $flaginvalid = true;

                    for ($a = 0; $a < 10; ++$a) {
                        if ($contents[$a] === '' || $contents[$a] === null) {
                            $flagEmpty = false;
                        }

                        if ($index > 0) {
                            if (in_array($a, [3, 4])) {
                                if (!is_numeric($contents[$a])) {
                                    $flagNumber = false;
                                } else {
                                    if (!in_array($contents[3], [1, 2])) {
                                        $flaginvalid = false;
                                    }

                                    if (!in_array($contents[4], [1, 2, 3, 4, 5, 6])) {
                                        $flaginvalid = false;
                                    }
                                }
                            }
                        }
                    }

                    $dupliflag = true;
                    $coll = array_filter(array_column($rows, 0));
                    $collemail = array_filter(array_column($rows, 6));
                    $dupli = $dupliemail = 0;

                    if ($contents[0] !== null && $contents[0] !== '') {
                        $dupli = array_count_values($coll)[$contents[0]];
                    }

                    if ($contents[6] !== null && $contents[6] !== '') {
                        $dupliemail = array_count_values($collemail)[$contents[6]];
                    }

                    if ($dupli > 1 || $dupliemail > 1) {
                        $dupliflag = false;
                    }

                    if ($dupliflag === true) {
                        $student = Student::where('npm', $contents[0])->first();
                        if ($student === null) {
                            if ($flagEmpty == true) {
                                if ($flagNumber == true) {
                                    if ($flaginvalid == true) {
                                        $table_contents .= '<tr id="tr-import-' . $index . '">';
                                    } else {
                                        $table_contents .= '<tr id="tr-import-' . $index . '" class="location_number_wrong" style="background:#2f7ba1" title="There is data that is wrong value !!">';
                                    }
                                } else {
                                    $table_contents .= '<tr id="tr-import-' . $index . '" class="location_number" style="background:#ff9f30" title="There is data that is not a number !!">';
                                }
                            } else {
                                $table_contents .= '<tr id="tr-import-' . $index . '" class="location_data_empty" style="background:#6db774" title="There is data that is still empty !!">';
                            }
                        } else {
                            $table_contents .= '<tr id="tr-import-' . $index . '" class="student_exist" style="background:#ffca68" title="Mahasiswa sudah ada !!">';
                        }
                    } else {
                        $table_contents .= '<tr id="tr-import-' . $index . '" class="student_duplicate" style="background:#a35252" title="Duplicated Student or duplicate email !!">';
                    }

                    $genders = ["1" => "Laki - Laki", "Perempuan"];
                    $religions = ["1" => "Islam", "Hindu", "Budha", "Kristen", "Protestan", "Kepercayaan"];

                    for ($cnt = 0; $cnt < 10; $cnt++) {
                        $tid = '';
                        if ($cnt == 0) {
                            $tid = ' id="td-import-' . $index . '" ';
                        }

                        $toappear = $contents[$cnt];
                        if (in_array($cnt, [7, 9]) && $index != 0) {
                            $dt = Carbon::instance(Date::excelToDateTimeObject($contents[$cnt]));
                            $toappear = date("d F Y", strtotime($dt));
                        }

                        if ($index != 0 && $cnt == 3) {
                            if ($contents[$cnt] != "" && is_numeric($contents[$cnt]) && $contents[$cnt] < 3) {
                                $toappear = $genders[$contents[$cnt]];
                            }
                        } elseif ($index != 0 && $cnt == 4) {
                            if ($contents[$cnt] != "" && is_numeric($contents[$cnt]) && $contents[$cnt] < 7) {
                                $toappear = $religions[$contents[$cnt]];
                            }
                        }

                        $table_contents .= '<td ' . $tid . '>&nbsp;&nbsp;&nbsp;' . $toappear . '</td>';
                    }

                    $table_contents .= '</tr>';
                    $table_contents .= $index == 0 ? '</thead>' : ($index + 1 == count($rows) ? '</tbody>' : '');
                    return response()->json(array('status' => 'success', 'content' => $table_contents, 'row' => count($rows)));
                } else {
                    return response()->json(array('status' => 'failed', 'err_msg' => ' Session has expired!'));
                }
            } else {
                return response()->json(array('status' => 'failed', 'err_msg' => 'Imported file formats are not allowed!'));
            }
        }

        if ($request->ajax()) {
            return response()->json($result);
        }
        return Redirect::to('/');
    }

    public function process(Request $request)
    {
        $result = ['message' => 'error', 'data' => 'Ups, terjadi kesalahan, refresh lalu coba lagi.'];

        $index = $request->index;
        $rows = $request->session()->get('importStudents');

        if ($rows) {
            $contents = $rows[$index];

            $flagEmpty = true;
            $flagNumber = true;
            $flaginvalid = true;

            for ($a = 0; $a < 10; ++$a) {
                if ($contents[$a] === '' || $contents[$a] === null) {
                    $flagEmpty = false;
                }

                if ($index > 0) {
                    if (in_array($a, [3, 4])) {
                        if (!is_numeric($contents[$a])) {
                            $flagNumber = false;
                        } else {
                            if (!in_array($contents[3], [1, 2])) {
                                $flaginvalid = false;
                            }

                            if (!in_array($contents[4], [1, 2, 3, 4, 5, 6])) {
                                $flaginvalid = false;
                            }
                        }
                    }
                }
            }

            if ($index > 0) {

                $dupliflag = true;
                $coll = array_filter(array_column($rows, 0));
                $collemail = array_filter(array_column($rows, 6));
                $dupli = $dupliemail = 0;

                if ($contents[0] !== null && $contents[0] !== '') {
                    $dupli = array_count_values($coll)[$contents[0]];
                }

                if ($contents[6] !== null && $contents[6] !== '') {
                    $dupliemail = array_count_values($collemail)[$contents[6]];
                }

                if ($dupli > 1 || $dupliemail > 1) {
                    $dupliflag = false;
                }

                if ($dupliflag === true) {
                    $student = Student::where('npm', $contents[0])->first();
                    if ($student === null) {
                        if ($flagEmpty == true) {
                            if ($flagNumber == true) {
                                if ($flaginvalid == true) {
                                    DB::transaction(function () use ($contents) {
                                        $message = new Student();
                                        $message->npm = $contents[0];
                                        $message->name = $contents[1];
                                        $message->class_of = $contents[2];
                                        $message->order = $message->lastOrder($contents[2]) + 1;
                                        $message->gender = $contents[3];
                                        $message->religion = $contents[4];
                                        $message->phone = $contents[5];
                                        $message->email = $contents[6];
                                        if ($contents[7] !== null && $contents[7] != '') {
                                            $dt = Carbon::instance(Date::excelToDateTimeObject($contents[7]));
                                            $message->date_of_birth = $dt;
                                        }
                                        if ($contents[8] !== null && $contents[8] != '') {
                                            $message->address = $contents[8];
                                        }
                                        if ($contents[9] !== null && $contents[9] != '') {
                                            $dt = Carbon::instance(Date::excelToDateTimeObject($contents[9]));
                                            $message->period = $dt;
                                        }
                                        $message->creator = auth()->user()->username;
                                        $message->editor = auth()->user()->username;
                                        $message->save();

                                        $user = new User();
                                        $user->name = $contents[1];
                                        $user->username = $contents[0];
                                        $user->email = $contents[6];
                                        $user->password = Hash::make("passwordnyabelumdisetting");
                                        $user->creator = auth()->user()->username;
                                        $user->editor = auth()->user()->username;
                                        $message->user()->save($user);
                                    });

                                    $result = ['message' => 'success', 'data' => 'Student ' . $contents[0] . ' has been added!!', 'index' => $index];
                                } else {
                                    $result = ['message' => 'error', 'data' => 'There is data that is wrong value !!', 'index' => $index];
                                }
                            } else {
                                $result = ['message' => 'error', 'data' => 'There is data that is not a number !!', 'index' => $index];
                            }
                        } else {
                            $result = ['message' => 'error', 'data' => 'There is data that is still empty !!', 'index' => $index];
                        }
                    } else {
                        $result = ['message' => 'error', 'data' => 'Mahasiswa sudah ada!!', 'index' => $index];
                    }
                } else {
                    $result = ['message' => 'error', 'data' => 'Duplicate Student or email!!', 'index' => $index];
                }
            }
        }

        if ($request->ajax()) {
            return response()->json($result);
        }
        return Redirect::to('/');
    }

    public function exportStudents(Request $request)
    {
        return FacadesExcel::download(new ExportStudents($request), 'students-by-' . auth()->user()->username . '.xlsx');
    }

    public function approveCertificate(Request $request)
    {

        $student = Student::where("id", $request->id)->first();
        if ($student !== null) {
            $student->certificate_approve = 1;
            $student->certificate_approve_date = now();
            $student->save();

            return response()->json(['status' => 'ok']);
        }

        return response()->json(['status' => 'fail']);
    }

    public function rejectCertificate(Request $request)
    {
        $student = Student::where("id", $request->id)->first();
        if ($student !== null) {
            $student->certificate_approve = 0; // atau status reject
            $student->certificate_approve_date = null; // kosongkan tanggal
            $student->save();

            return response()->json(['status' => 'ok']);
        }

        return response()->json(['status' => 'fail']);
    }

    /**
     * Test kartu SKS (untuk debugging)
     */
    public function testKartuSKS($npm)
    {
        $student = Student::where('npm', $npm)->first();
        if (!$student) {
            return "Student not found";
        }

        $data = $this->getKartuSKSData($student);

        echo "<h1>Debug Data Kartu SKS</h1>";
        echo "<h2>Student: {$student->name} - {$student->npm}</h2>";
        echo "<h3>Total SKS: {$data['totalSks']}</h3>";
        echo "<h3>Minimal SKS: {$data['minimalSks']}</h3>";
        echo "<h3>Jumlah Kegiatan Wajib Terpenuhi: {$data['jumlahKegiatanWajibTerpenuhi']}/{$data['totalKegiatanWajib']}</h3>";
        echo "<pre>";
        print_r($data['kegiatanKelompok']);
        echo "</pre>";

        die();
    }

    /**
     * Ekstrak jumlah minimal kegiatan wajib dari nama activity
     * Contoh: "Penerimaan Mahasiswa Baru (2 KEGIATAN WAJIB)" → 2
     */
    private function extractMinRequiredFromName($activityName)
    {
        $pattern = '/\((\d+)\s+KEGIATAN WAJIB\)/';
        if (preg_match($pattern, $activityName, $matches)) {
            return (int) $matches[1];
        }
        return 0;
    }

    /**
     * Mengumpulkan data untuk kartu SKS
     */
    private function getKartuSKSData(Student $student)
    {
        try {
            // Gunakan cache untuk mempercepat
            $cacheKey = 'kartu_sks_' . $student->id;

            return \Cache::remember($cacheKey, 300, function () use ($student) {
                // 1. Total SKS yang sudah disetujui
                $totalSks = \DB::table('student_activities')
                    ->join('sub_activities', 'sub_activities.id', '=', 'student_activities.sub_activity_id')
                    ->where('student_activities.student_id', $student->id)
                    ->where('student_activities.status', 3)
                    ->sum('sub_activities.sks') ?? 0;

                // 2. Minimal SKS dari reff
                $minimalSks = \DB::table('reffs')
                    ->where('name', 'minimalsks')
                    ->where('status', 1)
                    ->value('value') ?? 100;

                // 3. Ambil SEMUA kegiatan (aktif)
                $semuaKegiatan = \DB::table('sub_activities')
                    ->select(
                        'sub_activities.id',
                        'sub_activities.name',
                        'sub_activities.sks',
                        'sub_activities.required',
                        'activities.id as activity_id',
                        'activities.name as activity_name'
                    )
                    ->join('activities', 'activities.id', '=', 'sub_activities.activity_id')
                    ->where('sub_activities.status', 1)
                    ->orderBy('activities.name')
                    ->orderBy('sub_activities.name')
                    ->get();

                // 4. Ambil kegiatan yang sudah dilakukan (disetujui)
                $kegiatanDilakukan = \DB::table('student_activities')
                    ->select(
                        'student_activities.*',
                        'sub_activities.id as sub_activity_id',
                        'sub_activities.name as sub_activity_name',
                        'sub_activities.sks',
                        'sub_activities.required',
                        'activities.id as activity_id',
                        'activities.name as activity_name'
                    )
                    ->join('sub_activities', 'sub_activities.id', '=', 'student_activities.sub_activity_id')
                    ->join('activities', 'activities.id', '=', 'sub_activities.activity_id')
                    ->where('student_activities.student_id', $student->id)
                    ->where('student_activities.status', 3)
                    ->get();

                // 5. Ekstrak ID kegiatan yang sudah dilakukan
                $kegiatanDilakukanIds = [];
                foreach ($kegiatanDilakukan as $kegiatan) {
                    $kegiatanDilakukanIds[] = $kegiatan->sub_activity_id;
                }

                // 6. Kelompokkan kegiatan berdasarkan Activity
                $activities = [];
                foreach ($semuaKegiatan as $kegiatan) {
                    $activityId = $kegiatan->activity_id;
                    $activityName = $kegiatan->activity_name;

                    if (!isset($activities[$activityId])) {
                        $minWajib = $this->extractMinRequiredFromName($activityName);

                        $activities[$activityId] = [
                            'id' => $activityId,
                            'nama' => $activityName,
                            'min_wajib' => $minWajib,
                            'kegiatan' => [],
                            'kegiatan_wajib_count' => 0,
                            'kegiatan_wajib_terpenuhi' => 0
                        ];
                    }

                    $terpenuhi = in_array($kegiatan->id, $kegiatanDilakukanIds);

                    $activities[$activityId]['kegiatan'][] = [
                        'id' => $kegiatan->id,
                        'nama' => $kegiatan->name,
                        'sks' => $kegiatan->sks,
                        'required' => $kegiatan->required,
                        'status' => $terpenuhi ? 'TERPENUHI' : 'BELUM TERPENUHI'
                    ];

                    if ($kegiatan->required) {
                        $activities[$activityId]['kegiatan_wajib_count']++;
                        if ($terpenuhi) {
                            $activities[$activityId]['kegiatan_wajib_terpenuhi']++;
                        }
                    }
                }

                // 7. Hitung kelulusan kegiatan wajib per activity
                $totalKegiatanWajibTerpenuhi = 0;
                $totalKegiatanWajib = 0;

                foreach ($activities as $activityId => $activity) {
                    $minWajib = $activity['min_wajib'];
                    $wajibTerpenuhi = $activity['kegiatan_wajib_terpenuhi'];
                    $wajibTotal = $activity['kegiatan_wajib_count'];

                    if ($minWajib > 0) {
                        $terpenuhi = $wajibTerpenuhi >= $minWajib;
                        if ($terpenuhi) {
                            $totalKegiatanWajibTerpenuhi++;
                        }
                        $totalKegiatanWajib++;
                    } else {
                        $terpenuhi = ($wajibTerpenuhi == $wajibTotal);
                        if ($terpenuhi) {
                            $totalKegiatanWajibTerpenuhi++;
                        }
                        if ($wajibTotal > 0) {
                            $totalKegiatanWajib++;
                        }
                    }
                }

                $kegiatanWajibSemuaTerpenuhi = ($totalKegiatanWajibTerpenuhi == $totalKegiatanWajib && $totalKegiatanWajib > 0);

                // 8. Format ulang untuk view
                $kegiatanKelompok = [];
                foreach ($activities as $activity) {
                    $kegiatanKelompok[] = [
                        'nama' => $activity['nama'],
                        'min_wajib' => $activity['min_wajib'],
                        'kegiatan' => $activity['kegiatan'],
                        'wajib_terpenuhi'    => $activity['kegiatan_wajib_terpenuhi'],
                        'wajib_total'        => $activity['kegiatan_wajib_count'],
                        'total_kegiatan'     => count($activity['kegiatan']),
                        'terpenuhi_kegiatan' => collect($activity['kegiatan'])->where('status', 'TERPENUHI')->count()
                        ];
                }

                return [
                    'totalSks' => $totalSks,
                    'minimalSks' => $minimalSks,
                    'jumlahKegiatanWajibTerpenuhi' => $totalKegiatanWajibTerpenuhi,
                    'totalKegiatanWajib' => $totalKegiatanWajib,
                    'kegiatanWajibSemuaTerpenuhi' => $kegiatanWajibSemuaTerpenuhi,
                    'kegiatanKelompok' => $kegiatanKelompok,
                    'kegiatanDilakukanIds' => $kegiatanDilakukanIds
                ];
            });
        } catch (\Exception $e) {
            \Log::error('Error in getKartuSKSData: ' . $e->getMessage());

            return [
                'totalSks' => 0,
                'minimalSks' => 100,
                'jumlahKegiatanWajibTerpenuhi' => 0,
                'totalKegiatanWajib' => 0,
                'kegiatanWajibSemuaTerpenuhi' => false,
                'kegiatanKelompok' => [],
                'kegiatanDilakukanIds' => []
            ];
        }
    }

    /**
     * Menampilkan kartu SKS (HTML View)
     */
    public function kartuSKS(Student $student)
    {
        $active = "students";
        $sub_active = "kartu-sks";

        $data = $this->getKartuSKSData($student);

        return view('pages.students.kartu-sks', array_merge($data, [
            'active' => $active,
            'sub_active' => $sub_active,
            'student' => $student
        ]));
    }

    /**
     * Generate PDF Kartu SKS (via browser print)
     */
    public function kartuSKSPDF(Student $student)
    {
        $data = $this->getKartuSKSData($student);

        return view('pages.students.kartu-sks-print', array_merge($data, [
            'student' => $student,
            'print_mode' => true
        ]));
    }
}
