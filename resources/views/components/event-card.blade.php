<div class="flex justify-between items-center border p-4 rounded-md shadow-md">
    <div>
        <a href="{{ route('events.show', $event) }}"><h2 class="text-xl font-bold">{{ $event->name }}</h2></a>
        <p class="flex gap-2 items-center text-slate-500">
            <x-icon-calendar/>{{ $event->date_range }}
        </p>
        <p class="flex gap-2 items-center text-slate-500">
            <x-icon-location/>{{ $event->location }}
        </p>
    </div>
    <div>
        <x-link
            href="{{ route('events.show', $event) }}"
            class="bg-indigo-100 border border-transparent rounded-md hover:bg-indigo-400 transition ease-in-out duration-200">
            <x-icon-arrow/>
        </x-link>
    </div>
</div>
