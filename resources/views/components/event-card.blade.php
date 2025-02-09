<div class="gap-4 border py-4 px-4 rounded-md shadow-md">
    <a href="{{ route('events.show', $event) }}"><h2 class="text-xl font-bold">{{ $event->name }}</h2></a>
    <div class="flex justify-between gap-4 pt-4">
        <div class="rounded-full bg-slate-300 h-16 w-16">

        </div>
        <div class="grow">
            <p class="flex gap-2 items-center text-slate-500">
                <x-icon-calendar/>{{ $event->date_range }}
            </p>
            <p class="flex gap-2 items-center text-slate-500">
                <x-icon-location/>{{ $event->location }}
            </p>
        </div>
    </div>
</div>
