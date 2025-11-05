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
    Schema::create('linked_accounts', function (Blueprint $table) {
        $table->id(); // Primary key

        // Foreign key to link to the 'users' table
        $table->foreignId('user_id')->constrained()->onDelete('cascade');

        // Provider info
        $table->string('provider_name'); // e.g., 'github', 'steam'
        $table->string('provider_id');   // The user's unique ID on that platform

        // User details from the provider
        $table->string('nickname')->nullable();
        $table->string('name')->nullable();
        $table->string('email')->nullable();
        $table->string('avatar')->nullable();

        // OAuth tokens
        $table->text('token'); // The access token (should be encrypted)
        $table->text('refresh_token')->nullable(); // Not all providers give this

        $table->timestamps(); // created_at and updated_at

        // Add a unique constraint to prevent duplicates
        $table->unique(['provider_name', 'provider_id']);
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('linked_accounts');
    }
};
