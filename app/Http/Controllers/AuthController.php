<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
     public function register(Request $request)
    {
        // Validate form fields
        $fields = $request->validate([
            'username' => ['required', 'max:255'],
            'email' => ['required', 'max:255', 'email', 'unique:users,email'],
            'password' => ['required', 'min:3', 'confirmed'],
        ]);

        // Create user
        $user = User::create($fields);

        // Log user in
        Auth::login($user);

        // Redirect home
        return redirect()->route('home');
    }

    public function login(Request $request)
{
    // Validate login form fields
    $fields = $request->validate([
        'email' => ['required', 'max:255', 'email'],
        'password' => ['required'],
    ]);

    // Try to log in the user
    if (Auth::attempt($fields, $request->remember)) {
        return redirect()->intended();
    } else {
        return back()->withErrors([
            'failed' => 'Wrong password or email',
        ]);
    }
}
}