<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ $event->name }}
            </h2>
            <x-link href="{{ route('home') }}" class="hidden sm:block">
                {{ __('See all events') }}
            </x-link>
        </div>
    </x-slot>

    <div class="border p-4 rounded-lg shadow-md">
        <div class="flex justify-between">
            <div>
                <p class="text-gray-500">{{ $event->date_range }}</p>
                <p class="text-gray-500">{{ $event->location }}</p>
            </div>
            @if(Auth::user() && Auth::user()->can('update', $event))
                <x-link href="{{ route('events.edit', $event) }}">
                    {{ __('Edit') }}
                </x-link>
            @endif
        </div>
        <p class="text-gray-500">{!! $event->description !!}</p>
    </div>
</x-app-layout>
