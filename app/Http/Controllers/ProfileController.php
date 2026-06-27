<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function edit()
    {       

        // get the currently loged in user
        $user = Auth::user();

        return view('auth.edit-profile', ['user' => $user]);
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        // validate the profile form input
        $validatedFields = $request->validate([
            'username' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'password' => ['nullable', 'min:3', 'confirmed'],
            'avatar' => ['nullable', 'image', 'mimes:jpg,jpeg,png,gif,svg,webp', 'max:2048'],
        ]);
            // update username and email with cleaned input
        $user->username = strip_tags($validatedFields['username']);
        $user->email = strip_tags($validatedFields['email']);

        if (!empty($validatedFields['password'])) {
            $user->password = Hash::make($validatedFields['password']);
        }

        // replace the old avatar if a new one was uploaded
        if ($request->hasFile('avatar')) {
            if ($user->avatar) {
                Storage::disk('public')->delete($user->avatar);
            }

            $user->avatar = $request->file('avatar')->store('avatars', 'public');
        }

        $user->save();

        return back()->with('success', 'Profile updated successfully.');
    }
}