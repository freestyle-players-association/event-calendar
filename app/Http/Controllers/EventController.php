<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEventRequest;
use App\Http\Requests\UpdateEventRequest;
use App\Models\Event;
use Illuminate\Http\UploadedFile;
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
        if (isset($validated['banner']) && $validated['banner'] instanceof UploadedFile) {
            $banner = $validated['banner'];
            unset($validated['banner']);
        }

        if (isset($validated['icon']) && $validated['icon'] instanceof UploadedFile) {
            $icon = $validated['icon'];
            unset($validated['icon']);
        }

        $event = $request->user()->events()->create($validated);

        if (isset($banner)) {
            $fileName = $event->id.'.'.$banner->extension();
            $banner->storeAs('banners', $fileName, 'public');
            $validated['banner'] = $fileName;
        }

        if (isset($icon)) {
            $fileName = $event->id.'.'.$icon->extension();
            $icon->storeAs('icons', $fileName, 'public');
            $validated['icon'] = $fileName;
        }

        if (isset($banner) || isset($icon)) {
            $event->update($validated);
        }


        return redirect()->route('dashboard', $event)->with('success', 'Event created.');
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

        if (isset($validated['banner']) && $validated['banner'] instanceof UploadedFile) {
            $fileName = $event->id.'.'.$validated['banner']->extension();
            $validated['banner']->storeAs('banners', $fileName, 'public');
            $validated['banner'] = $fileName;
        }

        if (isset($validated['icon']) && $validated['icon'] instanceof UploadedFile) {
            $fileName = $event->id.'.'.$validated['icon']->extension();
            $validated['icon']->storeAs('icons', $fileName, 'public');
            $validated['icon'] = $fileName;
        }

        $event->update($validated);

        return redirect()->route('events.show', $event)->with('success', 'Event updated.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Event $event)
    {
        if (Auth::user()->cannot('delete', $event)) {
            return view('events.event', [
                'event' => $event,
            ])->with('error', 'You do not have permission to delete this event.');
        }

        if ($event->banner) {
            unlink(storage_path('app/public/banners/'.$event->banner));
        }

        if ($event->icon) {
            unlink(storage_path('app/public/icons/'.$event->icon));
        }

        $event->delete();

        return redirect()->route('events.index')->with('success', 'Event deleted.');
    }
}
