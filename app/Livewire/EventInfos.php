<?php

namespace App\Livewire;

use App\Models\Event;
use Livewire\Attributes\On;
use Livewire\Component;

class EventInfos extends Component
{
    public Event $event;
    public function render()
    {
        return view('livewire.event-infos');
    }

    #[On('event:status-changed')]
    public function refreshEvent()
    {
        $this->event = Event::find($this->event->id);
    }
}
