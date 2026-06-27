<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        // get posts that belong to the logged in user
        $posts = Auth::user()
            ->posts()
            ->with('user')
            ->latest()
            ->paginate(6);

        return view('users.dashboard', ['posts' => $posts]);
    }

    public function userPosts(User $user)
    {
         // get all posts for the selected user
        $posts = $user->posts()
            ->with('user')
            ->latest()
            ->paginate(6);

            // send user and their posts to the view
        return view('users.posts', [
            'user' => $user,
            'posts' => $posts,
        ]);
    }
}