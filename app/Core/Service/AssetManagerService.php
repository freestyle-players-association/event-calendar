<?php

namespace App\Core\Service;

use App\Core\Enum\AssetType;
use Illuminate\Support\Facades\Storage;

class AssetManagerService
{
    public function store(AssetType $type, string $fileName, string $contents): bool
    {
        return Storage::disk('public')->put($this->getPath($type, $fileName), $contents);
    }

    public function delete(AssetType $type, string $fileName): bool
    {
        return Storage::disk('public')->delete($this->getPath($type, $fileName));
    }

    public function deleteAll(AssetType $type): bool
    {
        return Storage::disk('public')->deleteDirectory($type->getPath());
    }

    public function url(AssetType $type, string $fileName): string
    {
        return asset(Storage::url($this->getPath($type, $fileName)));
    }

    public function dimensions(AssetType $type, string $fileName): array
    {
        $path = Storage::disk('public')->path($this->getPath($type, $fileName));
        if (! file_exists($path)) {
            return [0, 0];
        }
        [$width, $height] = getimagesize($path);

        return [$width, $height];
    }

    private function getPath(AssetType $type, string $fileName): string
    {
        return $type->getPath().'/'.$fileName;
    }
}
