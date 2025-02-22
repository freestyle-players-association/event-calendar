<?php

namespace App\Core\Service;

use App\Models\Event;
use App\Models\User;

class EventStatusService
{
    public function getStatus(Event $event, User $user): string
    {
        return $event->users()->where('user_id', $user->id)->first()?->pivot->status ?? '';
    }
}
