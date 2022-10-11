<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'title' => fake()->sentence(mt_rand(10, 15)),
            'content'=>fake()->paragraph(mt_rand(5, 20)),
            'category_id'=>mt_rand(1, 3),
            'user_id' => mt_rand(1, 1),
        ];
    }
}
