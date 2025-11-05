<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail; // It's good practice to keep this, even if commented out.
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Activitylog\Traits\LogsActivity; // <-- 1. IMPORT THE TRAIT
use Spatie\Activitylog\LogOptions;         // <-- 2. IMPORT THE LOG OPTIONS CLASS

class User extends Authenticatable implements MustVerifyEmail // I've re-enabled MustVerifyEmail as it's part of the default setup
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, LogsActivity; // <-- 3. USE THE TRAIT

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    // In app/Models/User.php

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role', // <-- THIS IS THE CRITICAL FIX
    ];
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Get the linked accounts for the user.
     */
    public function linkedAccounts()
    {
        // The original relationship is correct.
        return $this->hasMany(LinkedAccount::class);
    }

    // --- 4. ADD THIS ENTIRE FUNCTION TO CONFIGURE LOGGING ---
    /**
     * Configure the options for activity logging.
     */
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            // Log changes to these specific attributes
            ->logOnly(['name', 'email'])

            // Use a custom description for the log entries
            ->setDescriptionForEvent(fn(string $eventName) => "User has been {$eventName}")

            // Only log attributes that have actually changed
            ->logOnlyDirty()

            // Prevent logging empty logs
            ->dontSubmitEmptyLogs();
    }
}
