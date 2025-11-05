<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get admin credentials from the .env file
        $adminEmail = env('ADMIN_EMAIL', 'admin@example.com');
        $adminName = env('ADMIN_NAME', 'Admin');
        $adminPassword = env('ADMIN_PASSWORD', 'password');

        // Use firstOrCreate to prevent creating duplicate users on multiple runs.
        User::firstOrCreate(
            // Find by email
            ['email' => $adminEmail],

            // If not found, create with these attributes
            [
                'name' => $adminName,
                'password' => Hash::make($adminPassword),
                'email_verified_at' => now(),
                'role' => 'admin', // The role is still here, which is good.
                // 'username' field has been REMOVED.
            ]
        );
    }
}
