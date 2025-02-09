<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Events created by me') }}
        </h2>
    </x-slot>

    <div class="grid gap-4 grid-cols-1 md:grid-cols-2 lg:grid-cols-3">
        @foreach($events as $event)
            <x-event-card :event="$event"/>
        @endforeach
    </div>
</x-app-layout>
