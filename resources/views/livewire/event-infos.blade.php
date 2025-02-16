<div class="grow">
    <p class="flex gap-2 items-center text-slate-500">
        <x-heroicon-o-calendar-days class="h-5"/>{{ $event->date_range_full }}
    </p>
    <p class="flex gap-2 items-center text-slate-500">
        <x-heroicon-o-map-pin class="h-5"/>{{ $event->location }}
    </p>
    <p class="flex gap-2 items-center text-slate-500">
        <x-heroicon-o-user-group class="h-5"/>{{ $event->attending->count() }} attending
    </p>
    <p class="flex gap-2 items-center text-slate-500">
        <x-heroicon-o-question-mark-circle class="h-5"/>{{ $event->interested->count() }} interested
    </p>
</div>
