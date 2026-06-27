<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;

class PostApiController extends Controller
{
    public function latest(): JsonResponse
    {
        // get the latest posts 
        $posts = Post::with('user')
            ->latest()
            ->take(12)
            ->get();

        return response()->json([
            'success' => true,
            'posts' => $posts,
        ]);
    }

    public function mine(): JsonResponse
    {
        // get posts that belong to the logged in user
        $posts = Auth::user()
            ->posts()
            ->with('user')
            ->latest()
            ->get();

        return response()->json([
            'success' => true,
            'posts' => $posts,
        ]);
    }

    public function userPosts(User $user): JsonResponse
    {
        // get posts for a selected user
        $posts = $user->posts()
            ->with('user')
            ->latest()
            ->get();

        return response()->json([
            'success' => true,
            'user' => $user->only(['id', 'username']),
            'posts' => $posts,
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        // validate post form input
        $validatedFields = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'body' => ['required', 'string', 'max:2000'],
            'filter' => ['nullable', 'string', 'max:100'],
            'image' => ['nullable', 'file', 'max:3000', 'mimes:png,jpg,jpeg,webp'],
        ]);

        $imagePath = null;

        // save image if one was uploaded
        if ($request->hasFile('image')) {
            $imagePath = Storage::disk('public')
                ->put('post_images', $request->file('image'));
        }


        // create the post for the logged in user
        $post = Auth::user()->posts()->create([
            'title' => strip_tags($validatedFields['title']),
            'body' => strip_tags($validatedFields['body']),
            'filter' => strip_tags($validatedFields['filter'] ?? ''),
            'image' => $imagePath,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Your post was created.',
            'post' => $post->load('user'),
        ], 201);
    }

    public function destroy(Post $post): JsonResponse
    {
         // check the user is allowed to delete this post
        Gate::authorize('modify', $post);



        // delete the stored image before deleting the post
        if ($post->image) {
            Storage::disk('public')->delete($post->image);
        }

        $post->delete();

        return response()->json([
            'success' => true,
            'message' => 'Your post was deleted.',
        ]);
    }
}