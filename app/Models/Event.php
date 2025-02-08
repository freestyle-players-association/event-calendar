<?php

namespace App\Models;

use App\Models\Scopes\OrderByStartAsc;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Event extends Model
{
    /** @use HasFactory<\Database\Factories\EventFactory> */
    use HasFactory, HasUuids;

    protected $guarded = ['id', 'user_id'];

    public function getStartDateAttribute($value): string
    {
        return date('Y-m-d', strtotime($value));
    }

    public function getEndDateAttribute($value): string
    {
        return date('Y-m-d', strtotime($value));
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    protected static function booted()
    {
        static::addGlobalScope(new OrderByStartAsc);

        static::creating(function ($model) {
            $model->appendYearToSlug();
        });

        static::updating(function ($model) {
            $model->appendYearToSlug();
        });
    }

    protected function appendYearToSlug(): void
    {
        $this->slug = \Str::slug($this->name);
        $year = date('Y', strtotime($this->start_date));
        // Check if the slug already ends with a 4-digit number
        if (preg_match('/-\d{4}$/', $this->slug)) {
            // Replace the year at the end of the slug
            $this->slug = preg_replace('/-\d{4}$/', "-{$year}", $this->slug);
        } else {
            // Append the year to the slug
            $this->slug = "{$this->slug}-{$year}";
        }
    }
}
