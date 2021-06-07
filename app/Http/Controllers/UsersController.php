<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Http\Requests\UpdateUserProfile;

class UsersController extends Controller
{
    public function index() {
        return view('users.index')->withUsers(User::all());
    }

    public function edit() {
        return view('users.edit')->withUser(auth()->user());
    }

    public function update(UpdateUserProfile $request) {
        $user = auth()->user();

        $user->update([
            'name' => $request->name,
            'about' => $request->about
        ]);

        session()->flash('success', 'User info successfully updated');
        return redirect()->back();
    }

    public function makeAdmin(User $user) {
        $user->role = 'admin';
        $user->save();

        return redirect()->route('users.index');
    }
}
