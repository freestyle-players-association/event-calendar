<?php

namespace App\Models;

use App\Core\Enum\AssetType;
use App\Core\Enum\EventUserStatus;
use App\Core\LocaleDateFormatter;
use App\Core\Service\AssetManagerService;
use App\Models\Scopes\OrderByStartAsc;
use App\Observers\EventObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Attributes\ScopedBy;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Tonysm\RichTextLaravel\Models\Traits\HasRichText;

#[ObservedBy(EventObserver::class)]
#[ScopedBy(OrderByStartAsc::class)]
class Event extends Model
{
    /** @use HasFactory<\Database\Factories\EventFactory> */
    use HasFactory, HasRichText, HasUlids;

    // add description manually so the rich text editor can save it
    protected $fillable = [
        'name',
        'start_date',
        'end_date',
        'location',
        'description',
        'banner',
        'icon',
    ];

    protected $richTextAttributes = [
        'description',
    ];

    public function dateRange(): Attribute
    {
        $locale = request()->getPreferredLanguage();

        return Attribute::make(
            get: fn (mixed $value, array $attributes) => LocaleDateFormatter::formatShort($locale, $attributes['start_date'])
                .' - '.
                LocaleDateFormatter::formatShort($locale, $attributes['end_date']),
        );
    }

    public function dateRangeFull(): Attribute
    {
        $locale = request()->getPreferredLanguage();

        return Attribute::make(
            get: fn (mixed $value, array $attributes) => LocaleDateFormatter::format($locale, $attributes['start_date'])
                .' - '.
                LocaleDateFormatter::format($locale, $attributes['end_date']),
        );
    }

    public function getBannerUrlAttribute(): ?string
    {
        return $this->banner
            ? app(AssetManagerService::class)->url(AssetType::BANNER, $this->banner)
            : null;
    }

    public function getBannerWidthHeight(): array
    {
        return app(AssetManagerService::class)->dimensions(AssetType::BANNER, $this->banner);
    }

    public function getIconUrlAttribute(): ?string
    {
        return $this->icon
            ? app(AssetManagerService::class)->url(AssetType::ICON, $this->icon)
            : null;
    }

    public function getDayAttribute(): string
    {
        return date('j', strtotime($this->start_date));
    }

    public function getMonthAttribute(): string
    {
        return date('F', strtotime($this->start_date));
    }

    public function getYearAttribute(): string
    {
        return date('Y', strtotime($this->start_date));
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class)->withPivot('status');
    }

    public function interested(): BelongsToMany
    {
        return $this->belongsToMany(User::class)
            ->wherePivot('status', EventUserStatus::INTERESTED);
    }

    public function attending(): BelongsToMany
    {
        return $this->belongsToMany(User::class)
            ->wherePivot('status', EventUserStatus::ATTENDING);
    }
}
