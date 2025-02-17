<?php

namespace App\Core;

use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class LoremPicsum
{
    private static string $url = 'https://picsum.photos/';

    public static function getBanner(): string
    {
        $fileName = Str::random(40) . '.jpg';

        self::store(
            self::$url . '1920/600',
            'banners/' . $fileName
        );

        return $fileName;
    }

    public static function getIcon(): string
    {
        $fileName = Str::random(40) . '.jpg';

        self::store(
            self::$url . '200',
            'icons/' . $fileName
        );

        return $fileName;
    }

    /**
     * @throws ConnectionException
     */
    public static function store(string $url, string $path): void
    {
        try {
            // Use Laravel's HTTP client to get the image content
            $response = Http::get($url);

            if ($response->failed()) {
                // Optionally log the error or throw an exception
                throw new \Exception("Failed to download banner image from: {$url}");
            }

            // Save the image to the 'public' disk which is usually linked to public/storage
            Storage::disk('public')->put($path, $response->body());
        } catch (\Exception $e) {
            throw $e;
        }
    }
}
