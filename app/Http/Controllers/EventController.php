<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEventRequest;
use App\Http\Requests\UpdateEventRequest;
use App\Models\Event;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HtmlSanitizer\HtmlSanitizer;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $events = Event::all();
        $calendar = $events->groupBy(['year', 'month']);
        return view('events.index', [
            'events' => $events,
            'calendar' => $calendar,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // users must be logged in to create events
        if (!auth()->user()) {
            return view('events.must-login');
        }

        return view('events.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreEventRequest $request, HtmlSanitizer $sanitizer)
    {
        $validated = $request->validated();
        if (isset($validated['description'])) {
            $validated['description'] = $sanitizer->sanitize($validated['description']);
        }

        $event = $request->user()->events()->create($validated);

        return redirect()->route('events.show', $event);
    }

    /**
     * Display the specified resource.
     */
    public function show(Event $event)
    {
        return view('events.event', [
            'event' => $event,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Event $event)
    {
        if (Auth::user()->cannot('update', $event)) {
            return view('events.must-login');
        }

        return view('events.edit', [
            'event' => $event,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateEventRequest $request, Event $event, HtmlSanitizer $sanitizer)
    {
        $validated = $request->validated();
        if (isset($validated['description'])) {
            $validated['description'] = $sanitizer->sanitize($validated['description']);
        }
        $event->update($validated);
        return redirect()->route('events.show', $event);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Event $event)
    {
        $event->delete();
        return redirect()->route('events.index');
    }
}
