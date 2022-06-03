<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Block>
 */
class BlockFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $user = User::inRandomOrder()->first();
        $blocker = User::where('id', '!=', $user->id)->inRandomOrder()->first();

        return [
            'user_id' => $user->id,
            'blocker_id' => $blocker->id,
        ];
    }
}
