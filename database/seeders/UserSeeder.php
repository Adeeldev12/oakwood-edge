<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
         // 🔑 Super Admin (YOU)
        User::create([
            'name' => 'Super Admin',
            'email' => 'admin@oakwoodedge.com', // change to yours
            'password' => Hash::make('SuperAdmin@123'),
            'role' => 'superadmin',
        ]);

        // 👤 Admin Accounts
        $admins = [
            ['Sir Ahti', 'info@ahtiarshad.com'],
            ['Madam Bushra', 'bushraqaiser@hotmail.com'],
            ['Usman', 'Usman.mac.02@gmail.com'],
            ['Kainat', 'Kainatn754@gmail.com'],
        ];

        foreach ($admins as $admin) {
            User::create([
                'name' => $admin[0],
                'email' => $admin[1],
                'password' => Hash::make('Admin@' . rand(1000,9999)),
                'role' => 'admin',
            ]);
        }
    }
}
