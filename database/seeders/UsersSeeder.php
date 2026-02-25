<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@mail.com',
            'password' => bcrypt('password'),
        ]);

        $user = User::first();

        // Assign role
        $user->assignRole('admin');
    }
}
