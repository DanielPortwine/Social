<?php

namespace Database\Seeders;

use App\Models\Post;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $posts = Post::factory()->times(200)->create();

        foreach ($posts as $post) {
            Post::factory()->times(rand(1, 10))->create([
                'parent_id' => $post->id,
            ]);
        }

        foreach (Post::whereNotNull('parent_id')->inRandomOrder()->limit(Post::count() / 2)->get() as $comment) {
            Post::factory()->times(rand(1, 3))->create([
                'parent_id' => $comment->id,
            ]);
        }
    }
}
