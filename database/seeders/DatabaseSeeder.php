<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Database\Factories\UserFactory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'admin',
            'email' => 'admin@admin.com',
            'password' => 'admin',
            'is_admin' => true,
        ]);

        $this->call([
            UserSeeder::class,
            PostSeeder::class,
            TagSeeder::class,
        ]);

        $posts = Post::all();
        $users = User::all();
        $posts->each(function (Post $post) use ($users) {
            Comment::factory(rand(0,5))->create([
                'post_id' => $post->id,
                'user_id' => $users->random()->id,
            ]);
        });
    }
}
