<x-app-layout>
    <x-h1 class="mb-4">Events I am organizing</x-h1>
    <div class="grid gap-4 grid-cols-1 md:grid-cols-2 lg:grid-cols-3">
        @foreach($events as $event)
            <x-event-card :event="$event"/>
        @endforeach
    </div>
    <div class="mt-8 md:hidden">
        <a href="{{ route('events.create') }}" class="inline-flex items-center px-8 py-4 bg-primary-700 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 transition ease-in-out duration-150">
            Add Event
        </a>
    </div>
    <x-h2 class="mt-8">Events I am attending</x-h2>
    <div class="grid gap-4 grid-cols-1 md:grid-cols-2 lg:grid-cols-3">
        @foreach($attending as $event)
            <x-event-card :event="$event"/>
        @endforeach
    </div>
</x-app-layout>
