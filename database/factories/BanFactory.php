<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Ban>
 */
class BanFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $user = User::inRandomOrder()->first();
        $banner = User::where('id', '!=', $user->id)->inRandomOrder()->first();
        $duration = $this->faker->randomElement(config('bans.durations'));

        return [
            'user_id' => $user->id,
            'banner_id' => $banner->id,
            'reason' => $this->faker->sentence,
            'duration' => $duration['name'],
            'end' => date('Y-m-d H:i:s', strtotime('+'.$duration['seconds'].' seconds')),
        ];
    }
}
