<x-app-layout>
    <x-slot name="banner">
        @if($event->banner)
            <img
                src="{{ $event->banner_url }}"
                alt="{{ $event->name }}"
                class="w-full max-h-64 md:max-h-80 object-cover">
        @endif
    </x-slot>

    <div class="border rounded-lg shadow-md p-4 bg-white">
        <h1 class="text-2xl font-bold pb-8">{{ $event->name }}</h1>
        <div class="flex justify-between gap-4">
            <div class="grow">
                <p class="flex gap-2 items-center text-slate-500">
                    <x-heroicon-o-calendar-days class="h-5"/>{{ $event->date_range_full }}
                </p>
                <p class="flex gap-2 items-center text-slate-500">
                    <x-heroicon-o-map-pin class="h-5"/>{{ $event->location }}
                </p>
            </div>
        </div>
        <hr class="w-full h-px my-8 bg-slate-200 border-0">
        <x-event-buttons :event="$event"/>
        <div>{!! $event->description !!}</div>
    </div>
</x-app-layout>
