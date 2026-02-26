<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            SkillSeeder::class,
            DevUsersSeeder::class,
            AdminUserSeeder::class,
            AdminAccountSeeder::class,
            UserSeeder::class,
            DevUsersSeeder::class,
            DatabaseSeeder::class,
            
        ]);
    }
}
