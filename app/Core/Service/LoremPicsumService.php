<?php

namespace App\Core\Service;

use App\Core\Enum\AssetType;
use Exception;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class LoremPicsumService
{
    const string URL = 'https://picsum.photos/';

    public function __construct(
        private readonly AssetManagerService $assetManagerService
    )
    {
    }

    public function getBanner(): string
    {
        return self::process(AssetType::BANNER);
    }

    public function getIcon(): string
    {
        return self::process(AssetType::ICON);
    }

    private function process(AssetType $type): string
    {
        $fileName = Str::random(40) . '.jpg';
        $size = AssetType::BANNER === $type ? '1920/600' : '200';
        $url = self::URL . $size;
        if (!$image = self::getImage($url)) {
            return '';
        }

        return $this->assetManagerService->store(
            $type,
            $fileName,
            $image
        ) ? $fileName : '';
    }

    private function getImage(string $url): string
    {
        try {
            $response = Http::get($url);
            if ($response->failed()) {
                throw new Exception("Failed to download image from: {$url}");
            }
            return $response->body();
        } catch (Exception) {
            // todo log this error
        }

        return '';
    }
}
