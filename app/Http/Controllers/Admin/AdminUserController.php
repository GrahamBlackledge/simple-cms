<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class AdminUserController extends Controller
{
    public function index()
    {
        // get latest users for the admin users page
        $users = User::latest()->paginate(10);

        return view('admin.users.index', ['users' => $users]);
    }

    public function create()
    {
        // show form for creating a new user
        return view('admin.users.create');
    }

    public function store(Request $request)
    {
        // validation new user form input
        $validatedFields = $request->validate([
            'username' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:users,email'],
            'password' => ['required', 'min:3', 'confirmed'],
            'role' => ['required', 'in:user,admin'],
            'avatar' => ['nullable', 'image', 'max:2048'],
        ]);

        $avatarPath = null;



        // save avatar if one was uploaded
        if ($request->hasFile('avatar')) {
            $avatarPath = $request->file('avatar')->store('avatars', 'public');
        }

         // create the user with cleaned input
        User::create([
            'username' => strip_tags($validatedFields['username']),
            'email' => strip_tags($validatedFields['email']),
            'password' => Hash::make($validatedFields['password']),
            'role' => $validatedFields['role'],
            'avatar' => $avatarPath,
        ]);

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'User created successfully.');
    }

    public function edit(User $user)
    {
        return view('admin.users.edit', ['user' => $user]);
    }

    public function update(Request $request, User $user)
    {
        // validate updated user details
        $validatedFields = $request->validate([
            'username' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:users,email,' . $user->id],
            'role' => ['required', 'in:user,admin'],
            'avatar' => ['nullable', 'image', 'max:2048'],
        ]);

        $data = [
            'username' => strip_tags($validatedFields['username']),
            'email' => strip_tags($validatedFields['email']),
            'role' => $validatedFields['role'],
        ];

        // replace old avatar if a new one is uploaded
        if ($request->hasFile('avatar')) {
            if ($user->avatar) {
                Storage::disk('public')->delete($user->avatar);
            }

            $data['avatar'] = $request->file('avatar')->store('avatars', 'public');
        }

        $user->update($data);

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'User updated successfully.');
    }

    public function destroy(User $user)
    {
        // delete user avatar from storage before deleting the user
        if ($user->avatar) {
            Storage::disk('public')->delete($user->avatar);
        }

        $user->delete();

        return back()->with('success', 'User deleted successfully.');
    }
}