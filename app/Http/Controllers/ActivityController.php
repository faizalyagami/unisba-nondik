<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use Illuminate\Http\Request;

class ActivityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $active = "activities";
        $sub_active = "activities";
        $status = [0 => 'Semua', 1 => 'Aktif', 'Tidak Aktif'];

        $search_text = $request->search_text;
        $search_status = $request->search_status !== null ? $request->search_status : 1;

        $activities = Activity::select('id', 'name', 'status')
            ->whereRaw('name like ?', ['%'. $search_text .'%'])
            ->when($search_status != 0, function($q) use($search_status) {
                $q->where('status', $search_status);
            })
            ->orderBy('name')
            ->paginate(20)
            ->withQueryString();

        return view('pages.activities.index', compact(
            'active', 'sub_active', 'status', 
            'search_text', 'search_status', 'activities'
        ));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $active = "activities";
        $sub_active = "activities";

        return view('pages.activities.create', compact('active', 'sub_active'));
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
            'name' => ['required', 'unique:activities'],  
        ]);

        try {
            $message = new Activity();
            $message->name = $request->name;
            $message->creator = auth()->user()->username;
            $message->editor = auth()->user()->username;
            $message->save();

            $request->session()->flash('success', 'Activity has been added successfully');
            return redirect()->route('activity.index');
        } catch (\Throwable $th) {
            $request->session()->flash('error', 'Something wrong happend.');
            return redirect()->route('activity.create');
        }
        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Activity  $activity
     * @return \Illuminate\Http\Response
     */
    public function show(Activity $activity)
    {
        $active = "activities";
        $sub_active = "activities";
        $status = [1 => 'Aktif', 'Tidak Aktif'];

        return view('pages.activities.show', compact(
            'active', 'sub_active', 'status', 'activity'
        ));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Activity  $activity
     * @return \Illuminate\Http\Response
     */
    public function edit(Activity $activity)
    {
        $active = "activities";
        $sub_active = "activities";
        $status = [1 => 'Aktif', 'Tidak Aktif'];

        return view('pages.activities.edit', compact(
            'active', 'sub_active', 'status', 'activity'
        ));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Activity  $activity
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Activity $activity)
    {
        $this->validate($request, [
            'name' => ['required', 'unique:activities,name,'. $activity->id], 
            'status' => ['required'], 
        ]);

        try {
            $message = Activity::findOrFail($activity->id);
            $message->name = $request->name;
            $message->status = $request->status;
            $message->editor = auth()->user()->username;
            $message->save();

            $request->session()->flash('success', 'Activity has been update successfully');
            return redirect()->route('activity.show', [$activity->id]);
        } catch (\Throwable $th) {
            $request->session()->flash('error', 'Something wrong happend.');
            return redirect()->route('activity.show', [$activity->id]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Activity  $activity
     * @return \Illuminate\Http\Response
     */
    public function destroy(Activity $activity)
    {
        //
    }

}
