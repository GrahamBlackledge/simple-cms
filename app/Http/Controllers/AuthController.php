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

        
        if (Auth::attempt($fields, $request->remember)) {
            return redirect()->intended('dashboard');
        } else {
            return back()->withErrors([
                'failed' => 'Wrong password or email',
            ]);
        }
    }


    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }

}