<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@social.com',
            'remember_token' => 'Hfkk1ZgTEAnGZHQdmyJQ8BNU761i94m0yzyHIgZFi6Ir0BLHotRoDFUjLGKA',
        ]);

        User::factory()->times(50)->create();
    }
}
