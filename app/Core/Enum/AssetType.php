<?php

namespace App\Core\Enum;

enum AssetType: string
{
    case BANNER = 'banners';
    case ICON = 'icons';

    public function getPath(): string
    {
        return $this->value;
    }
}
