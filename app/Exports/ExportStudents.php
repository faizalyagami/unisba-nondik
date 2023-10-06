<?php

namespace App\Exports;

use App\Models\Reff;
use App\Models\Student;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\RegistersEventListeners;

class ExportStudents implements FromView
{
    use Exportable, RegistersEventListeners;
    
    private $request;

    /**
    * @return \Illuminate\Support\Collection
    */
    use Exportable, RegistersEventListeners;
    function __construct($request)
    {
        $this->request = $request;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function view(): View
    {
        $request = $this->request;

        $genders = Reff::select('value', 'show')->where('status', 1)->where('name', 'genders')->orderBy('value')->pluck('show', 'value');
        $needed = Reff::select('value', 'show')->where('status', 1)->where('name', 'minimalsks')->orderBy('value')->first();

        $search_text = $request->search_text;
        $search_gender = $request->search_gender ? $request->search_gender : 0;
        $search_classof = $request->search_classof ? $request->search_classof : 'Semua';
        $search_pansus = $request->search_pansus !== null ? $request->search_pansus : 0;
        $search_status = $request->search_status !== null ? $request->search_status : 1;

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
            ->when($search_gender != 0, function($q) use($search_gender) {
                $q->where('gender', $search_gender);
            })
            ->when($search_classof != 'Semua', function($q) use($search_classof) {
                $q->where('class_of', $search_classof);
            })
            ->when($search_pansus != 0, function($q) use($search_pansus) {
                $q->where('pansus', $search_pansus);
            })
            ->when($search_status != 0, function($q) use($search_status) {
                $q->where('status', $search_status);
            })
            ->withCount('studentActivities')
            ->orderBy('name')
            ->get();

        return view('pages.students.import-student', compact('students', 'genders', 'needed'));
    }
}
