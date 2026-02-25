<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;

class AdminAccountSeeder extends Seeder
{
    public function run()
    {
        Admin::updateOrCreate(
            ['email' => 'superadmin@local'],
            [
                'name' => 'Super Admin',
                'password' => Hash::make('supersecret'),
            ]
        );
    }
}
