<?php

namespace App\Models;

use App\Core\Enum\EventUserStatus;
use App\Core\Enum\UserRole;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, HasUlids, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $casts = [
        'role' => UserRole::class,
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

    public function events(): HasMany
    {
        return $this->hasMany(Event::class);
    }

    public function interestedEvents(): BelongsToMany
    {
        return $this->belongsToMany(Event::class)
            ->wherePivotIn('status', [EventUserStatus::INTERESTED, EventUserStatus::ATTENDING])
            ->where('events.user_id', '!=', $this->id);
    }

    public function attendingEvents(): BelongsToMany
    {
        return $this->belongsToMany(Event::class)
            ->wherePivot('status', EventUserStatus::ATTENDING)
            ->where('events.user_id', '!=', $this->id);
    }

    public function isAdmin(): bool
    {
        return $this->role->isAdmin();
    }
}
