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
            <livewire:event-infos :event="$event"/>
        </div>
        <hr class="w-full h-px my-8 bg-slate-200 border-0">
        <livewire:event-attend-buttons :event="$event"/>
        <hr class="w-full h-px my-8 bg-slate-200 border-0">
        <x-event-buttons :event="$event"/>
        <div>{!! $event->description !!}</div>
    </div>
</x-app-layout>
