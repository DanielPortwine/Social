<?php

namespace Database\Seeders;

use App\Models\Follower;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FollowerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach(User::get() as $user) {
            foreach(User::where('id', '!=', $user->id)->inRandomOrder()->limit(20)->get() as $follower) {
                Follower::factory()->create([
                    'user_id' => $user->id,
                    'follower_id' => $follower->id,
                ]);
            }
        }
    }
}
