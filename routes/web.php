<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AdminPostController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Api\PostApiController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use App\Http\Middleware\AdminMiddleware;
use Illuminate\Support\Facades\Route;

// send the homepage straight to the posts page
Route::redirect('/', '/posts');

// public post routes anyone can view postss
Route::resource('posts', PostController::class)->only(['index', 'show']);

// routes only logged in users can access
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');


    // logged in users can crate, edit, update and delete posts
    Route::resource('posts', PostController::class)
        ->except(['index', 'show']);

        // profile edit and update routes
    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::post('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

      // page for the JavaScript CMS app   
    Route::view('/cms-app', 'posts.cms-app')
        ->name('cms-app');

         // APi routes
    Route::prefix('cms-api')->name('cms-api.')->group(function () {
        Route::get('/posts/latest', [PostApiController::class, 'latest'])
            ->name('posts.latest');

        Route::get('/posts/mine', [PostApiController::class, 'mine'])
            ->name('posts.mine');

        Route::get('/users/{user}/posts', [PostApiController::class, 'userPosts'])
            ->name('users.posts');

        Route::post('/posts', [PostApiController::class, 'store'])
            ->name('posts.store');

        Route::delete('/posts/{post}', [PostApiController::class, 'destroy'])
            ->name('posts.destroy');
    });

    // admin only routes for managing users and posts
    Route::middleware(AdminMiddleware::class)
        ->prefix('admin')
        ->name('admin.')
        ->group(function () {
            Route::get('/dashboard', [AdminController::class, 'index'])
                ->name('dashboard');

            Route::resource('users', AdminUserController::class)->except(['show']);
            Route::resource('posts', AdminPostController::class)->except(['show']);
        });

    Route::post('/logout', [AuthController::class, 'logout'])
        ->name('logout');
});

        // routes for users who are not logged in
Route::middleware('guest')->group(function () {
    Route::view('/register', 'auth.register')->name('register');
    Route::post('/register', [AuthController::class, 'register']);

    Route::view('/login', 'auth.login')->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

    // public page to view posts by one user
Route::get('/users/{user}/posts', [DashboardController::class, 'userPosts'])
    ->name('posts.user');

Route::get('/logout', function () {
    return redirect()->route('posts.index');
});