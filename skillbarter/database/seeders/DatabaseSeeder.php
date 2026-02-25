<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            SkillSeeder::class,
            \Database\Seeders\DevUsersSeeder::class,
            \Database\Seeders\AdminUserSeeder::class,
            \Database\Seeders\AdminAccountSeeder::class,
        ]);
    }
}
