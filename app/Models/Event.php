<?php

namespace App\Models;

use App\Core\LocaleDateFormatter;
use App\Models\Scopes\OrderByStartAsc;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;
use Tonysm\RichTextLaravel\Models\Traits\HasRichText;

class Event extends Model
{
    /** @use HasFactory<\Database\Factories\EventFactory> */
    use HasFactory, HasUuids, HasRichText;

    protected $guarded = ['id', 'user_id'];

    protected $fillable = [
        'name',
        'start_date',
        'end_date',
        'location',
        'description',
        'banner',
        'icon',
    ]; // add description manually so wysiwyg editor can save it

    protected $richTextAttributes = [
        'description',
    ];

    public function dateRange(): Attribute
    {
        $locale = request()->getPreferredLanguage();
        return Attribute::make(
            get: fn(mixed $value, array $attributes) => LocaleDateFormatter::formatShort($locale, $attributes['start_date'])
                . ' - ' .
                LocaleDateFormatter::formatShort($locale, $attributes['end_date']),
        );
    }

    public function dateRangeFull(): Attribute
    {
        $locale = request()->getPreferredLanguage();
        return Attribute::make(
            get: fn(mixed $value, array $attributes) => LocaleDateFormatter::format($locale, $attributes['start_date'])
                . ' - ' .
                LocaleDateFormatter::format($locale, $attributes['end_date']),
        );
    }

    public function bannerUrl(): Attribute
    {
        return Attribute::make(
            get: fn(mixed $value, array $attributes) => $attributes['banner'] ? asset(Storage::url('banners/'.$attributes['banner'])) : null,
        );
    }

    public function iconUrl(): Attribute
    {
        return Attribute::make(
            get: fn(mixed $value, array $attributes) => $attributes['icon'] ? asset(Storage::url('icons/'.$attributes['icon'])) : null,
        );
    }

    public function day(): Attribute
    {
        return Attribute::make(
            get: fn(mixed $value, array $attributes) => date('j', strtotime($attributes['start_date'])),
        );
    }

    public function month(): Attribute
    {
        return Attribute::make(
            get: fn(mixed $value, array $attributes) => date('F', strtotime($attributes['start_date'])),
        );
    }

    public function year(): Attribute
    {
        return Attribute::make(
            get: fn(mixed $value, array $attributes) => date('Y', strtotime($attributes['start_date'])),
        );
    }

    public function startDate(): Attribute
    {
        return Attribute::make(
            get: fn(string $value) => date('Y-m-d', strtotime($value)),
        );
    }

    public function endDate(): Attribute
    {
        return Attribute::make(
            get: fn(string $value) => date('Y-m-d', strtotime($value)),
        );
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
