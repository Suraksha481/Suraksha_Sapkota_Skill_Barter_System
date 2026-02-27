<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            SkillSeeder::class,
            // ensure administrator record exists
            AdminSeeder::class,
            UserSeeder::class,
            DevUsersSeeder::class,
            // add other project seeders here as needed
        ]);
    }
}
