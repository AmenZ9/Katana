<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // This code will be executed when you run `php artisan migrate`
        Schema::table('users', function (Blueprint $table) {
            // Add a new column named 'username' after the 'name' column.
            // It must be unique across all users.
            // It can be empty (nullable) for regular users.
            $table->string('username')->after('name')->unique()->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // This code will be executed if you ever need to rollback the migration
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('username');
        });
    }
};
