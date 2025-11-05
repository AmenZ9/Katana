<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // --- THIS IS THE CRITICAL FIX ---
        // We must call the UserSeeder from the main DatabaseSeeder.
        $this->call([
            //UserSeeder::class,
            // You can add other seeders here in the future, like PostSeeder::class, etc.
        ]);
    }
}
