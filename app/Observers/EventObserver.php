<?php

namespace App\Observers;

use App\Core\Enum\AssetType;
use App\Core\Service\AssetManagerService;
use App\Models\Event;

class EventObserver
{
    public function __construct(private AssetManagerService $assetManagerService)
    {
    }

    public function creating(Event $event): void
    {
        $event->slug = \Str::slug($event->name);
    }

    public function updating(Event $event): void
    {
        $event->slug = \Str::slug($event->name);
    }

    public function deleted(Event $event): void
    {
        // Delete the event's banner and icon
        if ($event->banner) {
            $this->assetManagerService->delete(AssetType::BANNER, $event->banner);
        }
        if ($event->icon) {
            $this->assetManagerService->delete(AssetType::ICON, $event->icon);
        }
    }
}
