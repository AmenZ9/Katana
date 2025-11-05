<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Activitylog\Traits\LogsActivity; // <-- 1. IMPORT THE TRAIT
use Spatie\Activitylog\LogOptions;         // <-- 2. IMPORT THE LOG OPTIONS CLASS

class LinkedAccount extends Model
{
    use HasFactory, LogsActivity; // <-- 3. USE THE TRAIT

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id', // It's crucial that user_id is fillable
        'provider_name',
        'provider_id',
        'name',
        'nickname',
        'email',
        'avatar',
        'token',
        'refresh_token',
        'expires_at',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'expires_at' => 'datetime',
        // It's a good practice to encrypt the token for security
        // 'token' => 'encrypted',
    ];

    /**
     * Get the user that owns the linked account.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // --- 4. ADD THIS ENTIRE FUNCTION TO CONFIGURE LOGGING ---
    /**
     * Configure the options for activity logging.
     */
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            // Log all fillable attributes
            ->logAll()

            // Use a custom description for the log entries
            ->setDescriptionForEvent(fn(string $eventName) => "A social account has been {$eventName}")

            // Only log attributes that have actually changed
            ->logOnlyDirty()

            // Prevent logging empty logs
            ->dontSubmitEmptyLogs();
    }
}
