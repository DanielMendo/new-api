<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Category;
use App\Models\Post;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory(5)->create();

        // Category::factory()->create([
        //     'name' => 'Ciencia',
        //     'image' => 'https://via.placeholder.com/150',
        // ]);

        // Post::factory()->create([
        //     'user_id' => 1,
        //     'category_id' => 1,
        //     'title' => 'How To Create A Blog With Laravel',
        //     'content' => 'Create a blog with Laravel is a simple process. You can create a blog with Laravel in just a few minutes. In this tutorial, you will learn how to create a blog with Laravel.',
        //     'image' => 'https://via.placeholder.com/150',
        //     'html' => '<p>Create a blog with Laravel is a simple process. You can create a blog with Laravel in just a few minutes. In this tutorial, you will learn how to create a blog with Laravel.</p>',
        //     'is_published' => true,
        // ]);

        //User::factory()->create([
        //    'name' => 'Test User',
        //    'email' => 'test@example.com',
        //]);
    }
}
