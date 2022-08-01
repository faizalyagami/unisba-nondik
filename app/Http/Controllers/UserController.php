<?php

namespace App\Http\Controllers;

use App\Helpers\Helpers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $active = "users";
        $sub_active = "users";
        $levels = [0 => 'Semua', 1 => 'Admin', 'Reveiewer', 'User'];
        $status = [0 => 'Semua', 1 => 'Aktif', 'Tidak Aktif'];

        $search_text = $request->search_text;
        $search_level = $request->search_level !== null ? $request->search_level : 0;
        $search_status = $request->search_status !== null ? $request->search_status : 0;

        $users = User::select('id', 'name', 'username', 'email', 'level', 'status')
            ->where(function ($q) use($search_text) {
                $q->whereRaw('name ilike ?', ['%'. $search_text .'%'])
                ->orWhereRaw('username ilike ?', ['%'. $search_text .'%']);
            })
            ->when($search_level != 0, function($q) use($search_level) {
                $q->where('level', $search_level);
            })
            ->when($search_status != 0, function($q) use($search_status) {
                $q->where('status', $search_status);
            })
            ->orderBy('name')
            ->paginate(20)
            ->withQueryString();

        return view('pages.users.index', compact(
            'active', 'sub_active', 'status', 'levels', 
            'search_text', 'search_status', 'search_level', 'users'
        ));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $active = "users";
        $sub_active = "users";

        return view('pages.users.create', compact('active', 'sub_active'));
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
            'name' => ['required'],  
            'username' => ['required', 'unique:users'], 
            'email' => ['required', 'email'],  
            'password' => ['required', 'confirmed', 'min:6'], 
        ]);

        try {
            $message = new User();
            $message->name = $request->name;
            $message->username = $request->username;
            $message->email = $request->email;
            $message->password = Hash::make($request->password);
            $message->level = 1;
            $message->student_id = 0;
            $message->creator = auth()->user()->username;
            $message->editor = auth()->user()->username;
            $message->save();

            $request->session()->flash('success', 'User has been added successfully');
            return redirect()->route('user.index');
        } catch (\Throwable $th) {
            $request->session()->flash('error', 'Something wrong happend.');
            return redirect()->route('user.create');
        }
        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        $active = "users";
        $sub_active = "users";
        $status = [1 => 'Aktif', 'Tidak Aktif'];
        $levels = [1 => 'Admin', 'Reveiewer', 'User'];

        return view('pages.users.show', compact(
            'active', 'sub_active', 'status', 'levels', 'user'
        ));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        $active = "users";
        $sub_active = "users";
        $status = [1 => 'Aktif', 'Tidak Aktif'];
        $levels = [1 => 'Admin', 'Reveiewer', 'User'];

        return view('pages.users.edit', compact(
            'active', 'sub_active', 'status', 'levels', 'user'
        ));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $this->validate($request, [
            'name' => ['required'], 
            'username' => ['required', 'unique:users,username,'. $user->id], 
            'email' => ['required', 'email'],  
            'status' => ['required'], 
            'password' => ['confirmed'], 
        ]);

        try {
            $message = User::findOrFail($user->id);
            $message->name = $request->name;
            $message->username = $request->username;
            $message->email = $request->email;
            if($request->password !== null && $request->password != '') {
                $message->password = Hash::make($request->password);
            }
            $message->level = 1;
            $message->student_id = 0;
            $message->editor = auth()->user()->username;
            $message->save();

            $request->session()->flash('success', 'User has been update successfully');
            return redirect()->route('user.show', [$user->id]);
        } catch (\Throwable $th) {
            $request->session()->flash('error', 'Something wrong happend.');
            return redirect()->route('user.show', [$user->id]);
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
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function resetPassword(Request $request)
    {
        try{
            $user = User::findOrFail($request->id);
            $pass = Helpers::randomString();
            $user->password = Hash::make($pass);
            $user->editor = auth()->user()->username;
            $user->save();

            return response()->json(array('status' => 'success', 'msg' => 'User password has been reset. [ new password: '. $pass .']'));
        } catch (\Exception $e) {
            return response()->json(array('status' => 'failed', 'msg' => 'Something wrong happend'));
        }
    }

}
