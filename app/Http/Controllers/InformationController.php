<?php

namespace App\Http\Controllers;

use App\Helpers\Helpers;
use App\Models\Information;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class InformationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $active = "informations";
        $sub_active = "informations";
        $status = [0 => 'Semua', 1 => 'Aktif', 'Tidak Aktif'];

        $search_text = $request->search_text;
        $search_status = $request->search_status !== null ? $request->search_status : 0;

        $informations = Information::select('id', 'title', 'description', 'status', 'created_at')
            ->where(function ($q) use($search_text) {
                $q->whereRaw('title like ?', ['%'. $search_text .'%']);
            })
            ->when($search_status != 0, function($q) use($search_status) {
                $q->where('status', $search_status);
            })
            ->orderBy('created_at', 'desc')
            ->paginate(20)
            ->withQueryString();

        return view('pages.informations.index', compact(
            'active', 'sub_active', 'status', 
            'search_text', 'search_status', 'informations'
        ));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $active = "informations";
        $sub_active = "informations";

        return view('pages.informations.create', compact('active', 'sub_active'));
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
            'title' => ['required', 'unique:informations'], 
            'description' => ['required'], 
        ]);

        try {
            $message = new Information();
            $message->title = $request->title;
            $message->description = $request->description;
            $message->creator = auth()->user()->username;
            $message->editor = auth()->user()->username;
            $message->save();

            $request->session()->flash('success', 'Information has been added successfully');
            return redirect()->route('information.index');
        } catch (\Throwable $th) {
            $request->session()->flash('error', 'Something wrong happend.');
            return redirect()->route('information.create');
        }
        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Information $information
     * @return \Illuminate\Http\Response
     */
    public function show(Information $information)
    {
        $active = "informations";
        $sub_active = "informations";
        $status = [1 => 'Aktif', 'Tidak Aktif'];

        return view('pages.informations.show', compact(
            'active', 'sub_active', 'status', 'information'
        ));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Information  $information
     * @return \Illuminate\Http\Response
     */
    public function edit(Information $information)
    {
        $active = "informations";
        $sub_active = "informations";
        $status = [1 => 'Aktif', 'Tidak Aktif'];

        return view('pages.informations.edit', compact(
            'active', 'sub_active', 'status', 'information'
        ));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Information  $information
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Information $information)
    {
        $this->validate($request, [
            'title' => ['required', 'unique:informations,title,'. $information->id], 
            'description' => ['required'],  
            'status' => ['required'], 
        ]);

        try {
            $message = Information::findOrFail($information->id);
            $message->title = $request->title;
            $message->description = $request->description;
            $message->status = $request->status;
            $message->editor = auth()->user()->username;
            $message->save();

            $request->session()->flash('success', 'Information has been update successfully');
            return redirect()->route('information.show', [$information->id]);
        } catch (\Throwable $th) {
            $request->session()->flash('error', 'Something wrong happend.');
            return redirect()->route('information.show', [$information->id]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Information  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(Information $user)
    {
        //
    }

}
