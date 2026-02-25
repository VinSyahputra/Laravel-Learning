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

        $teacher = User::factory()->create([
            'name' => 'Teacher User',
            'email' => 'teacher@mail.com',
            'password' => bcrypt('password'),
        ]);

        $teacher->assignRole('teacher');

        $student = User::factory()->create([
            'name' => 'Student User',
            'email' => 'student@mail.com',
            'password' => bcrypt('password'),
        ]);

        $student->assignRole('student');    
    }                                                                                                                                                                                                                                                  
}
