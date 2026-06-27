<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminPostController extends Controller
{
    public function index()
    {
        // get latest posts with their users for the admin posts page
        $posts = Post::with('user')
            ->latest()
            ->paginate(10);

        return view('admin.posts.index', ['posts' => $posts]);
    }

    public function edit(Post $post)
    {
        // get users so admin can change the post author
        $users = User::orderBy('username')->get();

        return view('admin.posts.edit', [
            'post' => $post,
            'users' => $users,
        ]);
    }

    public function update(Request $request, Post $post)
    {
        // validate admin post edit form
        $validatedFields = $request->validate([
            'title' => ['required', 'max:255'],
            'body' => ['required'],
            'filter' => ['nullable', 'max:100'],
            'image' => ['nullable', 'file', 'max:3000', 'mimes:png,jpg,jpeg,webp'],
            'user_id' => ['required', 'exists:users,id'],
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

        // update the post with cleaned input
        $post->update([
            'title' => strip_tags($validatedFields['title']),
            'body' => strip_tags($validatedFields['body']),
            'filter' => strip_tags($validatedFields['filter'] ?? ''),
            'image' => $imagePath,
            'user_id' => $validatedFields['user_id'],
        ]);

        return redirect()
            ->route('admin.posts.index')
            ->with('success', 'Post updated successfully.');
    }

    public function destroy(Post $post)
    {
        if ($post->image) {
            Storage::disk('public')->delete($post->image);
        }

        $post->delete();

        return back()->with('success', 'Post deleted successfully.');
    }
}