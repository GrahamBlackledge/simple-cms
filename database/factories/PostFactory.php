<?php

namespace Database\Factories;

use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Post>
 */
class PostFactory extends Factory
{
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'title' => fake()->sentence(),
            'body' => fake()->paragraph(12),
            'filter' => fake()->randomElement(['warm', 'cool', 'black-white', null]),
            'image' => null,
        ];
    }
}