<?php

namespace App\Livewire;

use App\Core\Service\EventStatusService;
use App\Models\Event;
use Illuminate\View\View;
use Livewire\Component;

class EventAttendButtons extends Component
{
    public Event $event;

    public string $status;

    public function mount(
        Event $event,
        EventStatusService $eventStatusService
    ): void {
        $this->event = $event;
        $this->status = auth()->user() ? $eventStatusService->getStatus($event, auth()->user()) : '';
    }

    public function render(): View
    {
        return view('livewire.event-attend-buttons');
    }

    public function toggleStatus(string $status): void
    {
        $user = auth()->user();
        $this->event->users()->detach($user->id);
        if ($status) {
            $this->event->users()->attach($user->id, ['status' => $status]);
        }

        $this->status = $status;

        $this->dispatch('event:status-changed');
    }
}
