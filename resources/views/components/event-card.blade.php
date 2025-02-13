<a href="{{ route('events.show', $event) }}" class="bg-white hover:bg-slate-50">
    <article class="border p-4 rounded-md shadow-md h-full flex flex-col justify-between">
        <x-h2 class="pb-2">{{ $event->name }}</x-h2>
        <div class="flex justify-between items-center gap-4 pt-2">
            @if($event->icon)
                <img
                    src="{{ $event->icon_url }}"
                    alt="{{ $event->name }}"
                    class="rounded-lg h-16 w-16 object-contain"
                />
            @endif
            <div class="grow">
                <p class="flex gap-2 items-center text-slate-500">
                    <x-heroicon-o-calendar-days class="h-5"/>{{ $event->date_range }}
                </p>
                <p class="flex gap-2 items-center text-slate-500">
                    <x-heroicon-o-map-pin class="h-5"/>{{ $event->location }}
                </p>
            </div>
        </div>
    </article>
</a>
