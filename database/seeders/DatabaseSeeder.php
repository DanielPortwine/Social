<?php

namespace Database\Seeders;

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
        $this->call(UserSeeder::class);
        $this->call(FollowerSeeder::class);
        $this->call(BlockSeeder::class);
        $this->call(BanSeeder::class);
        $this->call(PostSeeder::class);
        $this->call(ReactionSeeder::class);
        $this->call(ReportSeeder::class);
    }
}
