<?php

namespace App\Http\Controllers;

use App\Core\Enum\AssetType;
use App\Core\Service\AssetManagerService;
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
        if (! auth()->user()) {
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
            $banner->storeAs(AssetType::BANNER->getPath(), $fileName, 'public');
            $validated['banner'] = $fileName;
        }

        if (isset($icon)) {
            $fileName = $event->id.'.'.$icon->extension();
            $icon->storeAs(AssetType::ICON->getPath(), $fileName, 'public');
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
    public function show(Event $event, $slug = null)
    {
        // If the slug is missing or outdated, redirect to the correct URL
        if ($slug !== $event->slug) {
            return redirect()->route('events.show', [
                'event' => $event->id,
                'slug' => $event->slug,
            ], 301);
        }

        return view('events.event', compact('event'));
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
    public function update(UpdateEventRequest $request, Event $event, HtmlSanitizer $sanitizer, AssetManagerService $assetManagerService)
    {
        $validated = $request->validated();
        if (isset($validated['description'])) {
            $validated['description'] = $sanitizer->sanitize($validated['description']);
        }

        if (isset($validated['banner']) && $validated['banner'] instanceof UploadedFile) {
            $fileName = $event->id.'.'.$validated['banner']->extension();
            $validated['banner']->storeAs(AssetType::BANNER->getPath(), $fileName, 'public');
            $validated['banner'] = $fileName;
        } elseif ($request->input('delete_banner')) {
            $assetManagerService->delete(AssetType::BANNER, $event->banner);
            $validated['banner'] = null;
        }

        if (isset($validated['icon']) && $validated['icon'] instanceof UploadedFile) {
            $fileName = $event->id.'.'.$validated['icon']->extension();
            $validated['icon']->storeAs(AssetType::ICON->getPath(), $fileName, 'public');
            $validated['icon'] = $fileName;
        } elseif ($request->input('delete_icon')) {
            $assetManagerService->delete(AssetType::ICON, $event->icon);
            $validated['icon'] = null;
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

        $event->delete();

        return redirect()->route('events.index')->with('success', 'Event deleted.');
    }
}
