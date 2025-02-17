<?php

namespace App\Models;

use App\Core\LocaleDateFormatter;
use App\Models\Scopes\OrderByStartAsc;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Facades\Storage;
use Tonysm\RichTextLaravel\Models\Traits\HasRichText;

class Event extends Model
{
    /** @use HasFactory<\Database\Factories\EventFactory> */
    use HasFactory, HasUlids, HasRichText;

    public static string $interested = 'interested';
    public static string $attending = 'attending';

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

    public function getBannerWidthHeight(): array
    {
        if ($this->banner) {
            $path = storage_path('app/public/banners/'.$this->banner);
            [$width, $height] = getimagesize($path);
            return [$width, $height];
        }

        return [0, 0];
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

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class)->withPivot('status');
    }

    public function interested(): BelongsToMany
    {
        return $this->belongsToMany(User::class)->wherePivot('status', self::$interested);
    }

    public function attending(): BelongsToMany
    {
        return $this->belongsToMany(User::class)->wherePivot('status', self::$attending);
    }

    public function status(User $user): string
    {
        return $this->users()->where('user_id', $user->id)->first()?->pivot->status ?? '';
    }

    protected static function booted()
    {
        static::addGlobalScope(new OrderByStartAsc);

        static::creating(function ($model) {
            $model->slug = \Str::slug($model->name);
        });

        static::updating(function ($model) {
            $model->slug = \Str::slug($model->name);
        });

        static::deleted(function ($model) {
            $model->users()->detach();
            if ($model->banner) {
                unlink(storage_path('app/public/banners/'.$model->banner));
            }
            if ($model->icon) {
                unlink(storage_path('app/public/icons/'.$model->icon));
            }
        });
    }
}
