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
                <div class="flex gap-4 items-center">
                    <hr class="w-full h-px my-8 bg-slate-200 border-0 dark:bg-slate-400">
                    <h3 class="text-xl font-bold">{{ $month }}</h3>
                    <hr class="w-full h-px my-8 bg-slate-200 border-0 dark:bg-slate-400">
                </div>
                <div class="grid gap-4 grid-cols-1 md:grid-cols-2 lg:grid-cols-3">
                    @foreach($events as $event)
                        <x-event-card :event="$event"/>
                    @endforeach
                </div>
            </section>
        @endforeach
    @endforeach
</x-app-layout>
