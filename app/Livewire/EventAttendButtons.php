<?php

namespace App\Livewire;

use App\Models\Event;
use Livewire\Component;

class EventAttendButtons extends Component
{
    public Event $event;
    public string $status;

    public function mount(Event $event)
    {
        $this->event = $event;
        $this->status = auth()->user() ? $event->status(auth()->user()) : '';
    }

    public function render()
    {
        return view('livewire.event-attend-buttons');
    }

    public function toggleStatus(string $status)
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
