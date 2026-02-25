<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;

class CreatePersonalAdminSeeder extends Seeder
{
    public function run()
    {
        // Replace with your desired admin credentials
        $email = 'suraksha.sapkota.a23@icp.edu.np';
        $password = '12345678';

        Admin::updateOrCreate(
            ['email' => $email],
            [
                'name' => 'Suraksha Sapkota',
                'password' => Hash::make($password),
            ]
        );
    }
}
