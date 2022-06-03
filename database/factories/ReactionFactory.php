<?php

namespace Database\Factories;

use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Reaction>
 */
class ReactionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $post = Post::inRandomOrder()->first();
        $reaction = $this->faker->randomElement(config('reactions'));

        return [
            'post_id' => $post->id,
            'user_id' => User::where('id', '!=', $post->user_id)->inRandomOrder()->first()->id,
            'reaction' => $reaction['name'],
        ];
    }
}
