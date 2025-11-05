public function up(): void
{
    Schema::create('linked_accounts', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained()->onDelete('cascade');
        $table->string('provider_name');
        $table->string('provider_id'); // Keeping as string is safer for very large IDs

        $table->string('name')->nullable();
        $table->string('nickname')->nullable();
        $table->string('email')->nullable();
        $table->string('avatar')->nullable();
        $table->text('token');
        $table->text('refresh_token')->nullable();
        $table->timestamp('expires_at')->nullable();
        $table->timestamps();

        // --- THIS IS THE CRITICAL FIX ---
        // Add a unique constraint to prevent duplicate accounts
        $table->unique(['user_id', 'provider_name']);
    });
}
