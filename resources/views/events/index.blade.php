<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Upcoming Events') }}
        </h2>
    </x-slot>

    @foreach($calendar as $year => $months)
        <h2 class="text-2xl font-bold">Events in {{ $year }}</h2>
        @foreach($months as $month => $events)
            <section class="py-2">
                <h3 class="text-xl font-bold">{{ $month }}</h3>
                <div class="grid gap-4 grid-cols-1 md:grid-cols-2 lg:grid-cols-3">
                    @foreach($events as $event)
                        <div class="border p-4 rounded-lg shadow-md">
                            <a href="{{ route('events.show', $event) }}" ><h2 class="text-xl font-bold">{{ $event->name }}</h2></a>
                            <p class="text-gray-500">{{ $event->date_range }}</p>
                            <p class="text-gray-500">{{ $event->location }}</p>
                        </div>
                    @endforeach
                </div>
            </section>
        @endforeach
    @endforeach
</x-app-layout>
