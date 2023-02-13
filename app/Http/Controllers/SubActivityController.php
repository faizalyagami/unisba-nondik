<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\Reff;
use App\Models\SubActivity;
use Carbon\Carbon;
use Illuminate\Http\Request;

class SubActivityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request, Activity $activity)
    {
        $active = "activities";
        $sub_active = "activities";
        $needs = [0 => 'Tidak Wajib', 'Wajib'];

        return view('pages.sub-activities.create', compact('active', 'sub_active', 'activity', 'needs'));
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
            'name' => ['required', 'unique:sub_activities'],  
            'sks' => ['required'], 
            'notes' => ['required']
        ]);

        try {
            $message = new SubActivity();
            $message->activity_id = $request->activity_id;
            $message->name = $request->name;
            $message->sks = $request->sks;
            $message->notes = $request->notes;
            $message->required = $request->required;
            $message->creator = auth()->user()->username;
            $message->editor = auth()->user()->username;
            $message->save();

            $request->session()->flash('success', 'Sub Activity has been added successfully');
            return redirect()->route('activity.show', [$request->activity_id]);
        } catch (\Throwable $th) {
            $request->session()->flash('error', 'Something wrong happend.');
            return redirect()->route('activity.sub.create', [$request->activity_id]);
        }
        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\SubActivity  $subActivity
     * @return \Illuminate\Http\Response
     */
    public function show(Activity $activity, SubActivity $subActivity)
    {
        $active = "activities";
        $sub_active = "activities";
        $status = [1 => 'Aktif', 'Tidak Aktif'];
        $needs = [0 => 'Tidak Wajib', 'Wajib'];

        return view('pages.sub-activities.show', compact(
            'active', 'sub_active', 'status', 'activity', 'subActivity', 'needs'
        ));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\SubActivity  $subActivity
     * @return \Illuminate\Http\Response
     */
    public function edit(Activity $activity, SubActivity $subActivity)
    {
        $active = "activities";
        $sub_active = "activities";
        $status = [1 => 'Aktif', 'Tidak Aktif'];
        $needs = [0 => 'Tidak Wajib', 'Wajib'];

        return view('pages.sub-activities.edit', compact(
            'active', 'sub_active', 'status', 'activity', 'subActivity', 'needs'
        ));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\SubActivity  $subActivity
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Activity $activity,SubActivity $subActivity)
    {
        $this->validate($request, [
            'name' => ['required', 'unique:sub_activities,name,'. $subActivity->id], 
            'sks' => ['required'], 
            'notes' => ['required'], 
            'status' => ['required']
        ]);

        try {
            $message = SubActivity::findOrFail($subActivity->id);
            $message->name = $request->name;
            $message->sks = $request->sks;
            $message->notes = $request->notes;
            $message->required = $request->required;
            $message->status = $request->status;
            $message->editor = auth()->user()->username;
            $message->save();

            $request->session()->flash('success', 'Sub Activity has been update successfully');
            return redirect()->route('activity.sub.show', [$activity->id, $subActivity->id]);
        } catch (\Throwable $th) {
            $request->session()->flash('error', 'Something wrong happend.');
            return redirect()->route('activity.sub.show', [$activity->id, $subActivity->id]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\SubActivity  $subActivity
     * @return \Illuminate\Http\Response
     */
    public function destroy(SubActivity $subActivity)
    {
        //
    }

}
