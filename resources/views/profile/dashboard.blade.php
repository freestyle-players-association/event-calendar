<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Events created by me') }}
        </h2>
    </x-slot>

    <div class="grid gap-4 grid-cols-1 md:grid-cols-2 lg:grid-cols-3">
        @foreach($events as $event)
            <div class="border p-4 rounded-lg shadow-md">
                <a href="{{ route('events.show', $event) }}" ><h2 class="text-xl font-bold">{{ $event->name }}</h2></a>
                <p class="text-gray-500">{{ $event->start_date }} - {{ $event->end_date }}</p>
                <p class="text-gray-500">{{ $event->location }}</p>
                <div class="flex justify-between">
                    <x-primary-button><a href="{{ route('events.edit', $event) }}">{{ __('Edit') }}</a></x-primary-button>
                </div>
            </div>
        @endforeach
    </div>
</x-app-layout>
