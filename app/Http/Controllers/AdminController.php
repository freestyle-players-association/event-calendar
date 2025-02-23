<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function index()
    {
        return view('admin.index', ['events' => Event::all()]);
    }

    public function destroy(Event $event)
    {
        if (Auth::user()->cannot('delete', $event)) {
            return view('events.event', [
                'event' => $event,
            ])->with('error', 'You do not have permission to delete this event.');
        }

        $event->delete();

        return redirect()->route('admin');
    }
}
