<x-app-layout>
    <x-slot name="banner">
        @if($event->banner)
            <img
                src="{{ $event->banner_url }}"
                alt="{{ $event->name }}"
                class="w-full object-cover">
        @endif
    </x-slot>

    <div class="border rounded-lg shadow-md p-4 bg-white">
        <h1 class="text-2xl font-bold pb-8">{{ $event->name }}</h1>
        <livewire:event-infos :event="$event"/>
        <livewire:event-attend-buttons :event="$event"/>
        <hr class="w-full h-px my-6 bg-slate-200 border-0">
        <x-event-buttons :event="$event"/>
        <div>{!! $event->description !!}</div>
    </div>
</x-app-layout>
