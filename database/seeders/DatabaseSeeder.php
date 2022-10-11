<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Article;
use App\Models\Category;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // User
        User::factory(1)->create([
            'name' => 'Arif Dwi Nugroho',
            'email' => 'arif@example.com',
            'password'=>bcrypt('password'),
        ]);

        // Category
         Category::create([
          'name' => 'PHP',
          'user_id' => '1'
        ]);

        Category::create([
            'name' => 'Javascript',
            'user_id' => '1'
          ]);

          Category::create([
            'name' => 'Laravel',
            'user_id' => '1'
          ]);

        // Article
        Article::factory(5)->create();
        
        // Post
        Post::factory()->create();
        
        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        //     'password'=>bcrypt('password'),
        // ]);
    }
}
