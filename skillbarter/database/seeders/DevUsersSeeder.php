<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class DevUsersSeeder extends Seeder
{
    public function run()
    {
        if (! app()->environment('local')) return;

        $users = [
            ['name' => 'Admin User', 'email' => 'admin@example.test', 'role' => 'admin', 'password' => 'password'],
            ['name' => 'Teacher User', 'email' => 'teacher@example.test', 'role' => 'teacher', 'password' => 'password'],
            ['name' => 'Student User', 'email' => 'student@example.test', 'role' => 'student', 'password' => 'password'],
        ];

        foreach ($users as $u) {
            User::updateOrCreate([
                'email' => $u['email']
            ], [
                'name' => $u['name'],
                'role' => $u['role'],
                'password' => Hash::make($u['password'])
            ]);
        }
    }
}
