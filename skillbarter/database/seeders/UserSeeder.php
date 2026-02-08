<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'name' => 'Alice',
            'email' => 'alice@example.com',
            'password' => Hash::make('password123'),
            'role' => 'teacher',
            'bio' => 'Experienced teacher',
            'experience_level' => 'advanced'
        ]);

        User::create([
            'name' => 'Bob',
            'email' => 'bob@example.com',
            'password' => Hash::make('password123'),
            'role' => 'student',
            'bio' => 'Eager learner',
            'experience_level' => 'beginner'
        ]);
    }
}
