<a href="{{ $href }}"
   class="border-b-2"
   wire:navigate
   wire:current.exact="border-secondary-900">
    <div class="flex flex-col items-center pb-1">
        <div>
            <x-dynamic-component :component="$icon" class="h-8 text-secondary-900"/>
        </div>
        <span class="text-sm">{{ __($label) }}</span>
    </div>
</a>
