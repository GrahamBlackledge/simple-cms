<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Create admin account
        $adminUser = User::updateOrCreate(
            ['email' => 'admin@example.com'],
            [
                'username' => 'admin',
                'password' => Hash::make('admin'),
                'role' => 'admin',
                'avatar' => null,
            ]
        );

        // Create 5 fake/test users
        User::factory(5)->create();


            //Create fake/test posts
        Post::factory(10)->create([
            'user_id' => $adminUser->id,
        ]);
    }
}