<?php

namespace Database\Seeders;

use App\Models\Block;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BlockSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach(User::get() as $user) {
            foreach(User::where('id', '!=', $user->id)->inRandomOrder()->limit(20)->get() as $blocker) {
                Block::factory()->create([
                    'user_id' => $user->id,
                    'blocker_id' => $blocker->id,
                ]);
            }
        }
    }
}
