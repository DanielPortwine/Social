<?php

namespace Database\Seeders;

use App\Models\Ban;
use Illuminate\Database\Seeder;

class BanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Ban::factory()->times(10)->create([
            'banner_id' => 1,
        ]);
    }
}
