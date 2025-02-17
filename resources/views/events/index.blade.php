<x-app-layout>
    @foreach($calendar as $year => $months)
        <x-h1>Events in {{ $year }}</x-h1>
        @foreach($months as $month => $events)
            <section class="my-4">
                <div class="flex gap-4 items-center my-8">
                    <hr class="w-full h-px bg-slate-500 border-0 ">
                    <x-h2>{{ $month }}</x-h2>
                    <hr class="w-full h-px bg-slate-500 border-0">
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
