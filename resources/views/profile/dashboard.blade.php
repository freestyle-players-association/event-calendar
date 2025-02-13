<x-app-layout>
    <x-h1 class="mb-4">Events I am organizing</x-h1>
    <div class="grid gap-4 grid-cols-1 md:grid-cols-2 lg:grid-cols-3">
        @foreach($events as $event)
            <x-event-card :event="$event"/>
        @endforeach
    </div>
</x-app-layout>
