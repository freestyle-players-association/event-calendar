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
        $this->status = $event->status(auth()->user());
    }

    public function render()
    {
        return view('livewire.event-attend-buttons');
    }

    public function toggleStatus(string $status)
    {
        $user = auth()->user();
        if ($this->status) {
            $this->event->users()->updateExistingPivot($user->id, ['status' => $status]);
        } else {
            if ($status) {
                $this->event->users()->attach($user->id, ['status' => $status]);
            } else {
                $this->event->users()->detach($user->id);
            }
        }
        $this->status = $status;
    }
    public function toggleAttending()
    {
        $user = auth()->user();
        if ($this->attending) {
            $this->event->attending()->detach($user);
            $this->attending = false;
        } else {
            if ($this->interested) {
                $this->event->interested()->detach($user);
                $this->interested = false;
            }
            $this->event->attending()->attach($user, ['status' => Event::$attending]);
            $this->attending = true;
        }
    }

    public function toggleInterested()
    {
        $user = auth()->user();
        if ($this->interested) {
            $this->event->interested()->detach($user);
            $this->interested = false;
        } else {
            if ($this->attending) {
                $this->event->attending()->detach($user);
                $this->attending = false;
            }
            $this->event->interested()->attach($user, ['status' => Event::$interested]);
            $this->interested = true;
        }
    }
}
