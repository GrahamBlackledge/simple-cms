<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    public function index()
    {
        // get latest postss with the user who created them
        $posts = Post::with('user')
            ->latest()
            ->paginate(6);

        return view('posts.index', ['posts' => $posts]);
    }

    public function store(Request $request)
    {
         // validate the form input before creating the post
        $validatedFields = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'body' => ['required', 'string', 'max:2000'],
            'filter' => ['nullable', 'string', 'max:100'],
            'image' => ['nullable', 'file', 'max:3000', 'mimes:png,jpg,jpeg,webp'],
        ]);

        $imagePath = null;

         // save image to public storage if one was uploadd
        if ($request->hasFile('image')) {
            $imagePath = Storage::disk('public')
                ->put('post_images', $request->file('image'));
        }

        // create the post for the currently logged in user
        Auth::user()->posts()->create([
            'title' => strip_tags($validatedFields['title']),
            'body' => strip_tags($validatedFields['body']),
            'filter' => strip_tags($validatedFields['filter'] ?? ''),
            'image' => $imagePath,
        ]);

        return back()->with('success', 'Your post was created.');
    }

    public function show(Post $post)
    {
        return view('posts.show', ['post' => $post]);
    }

    public function edit(Post $post)
    {
        // only allow the owner or admin to edit the post
        Gate::authorize('modify', $post);

        return view('posts.edit', ['post' => $post]);
    }

    public function update(Request $request, Post $post)
    {
        // check the user is allowed to update this post
        Gate::authorize('modify', $post);

        $validatedFields = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'body' => ['required', 'string', 'max:2000'],
            'filter' => ['nullable', 'string', 'max:100'],
            'image' => ['nullable', 'file', 'max:3000', 'mimes:png,jpg,jpeg,webp'],
        ]);

        $imagePath = $post->image;

        // replace the old image if a new one is uploaded
        if ($request->hasFile('image')) {
            if ($post->image) {
                Storage::disk('public')->delete($post->image);
            }

            $imagePath = Storage::disk('public')
                ->put('post_images', $request->file('image'));
        }

        // update the post with the cleaned form data
        $post->update([
            'title' => strip_tags($validatedFields['title']),
            'body' => strip_tags($validatedFields['body']),
            'filter' => strip_tags($validatedFields['filter'] ?? ''),
            'image' => $imagePath,
        ]);

        return redirect()
            ->route('dashboard')
            ->with('success', 'Your post was updated.');
    }

    public function destroy(Post $post)
    {
        // check the user is allowed to delete this post
        Gate::authorize('modify', $post);


          // delete the image from storage before deleting the post
        if ($post->image) {
            Storage::disk('public')->delete($post->image);
        }

        $post->delete();

        return back()->with('delete', 'Your post was deleted.');
    }
}