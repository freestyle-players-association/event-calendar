<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ $event->name }}
            </h2>
            <x-primary-button>
                <a href="{{ route('home') }}">
                    {{ __('See all events') }}
                </a>
            </x-primary-button>
        </div>
    </x-slot>

    <div class="border p-4 rounded-lg shadow-md">
        <p class="text-gray-500">{{ $event->description }}</p>
        <p class="text-gray-500">{{ $event->start_date }} - {{ $event->end_date }}</p>
        <p class="text-gray-500">{{ $event->location }}</p>
    </div>
</x-app-layout>
