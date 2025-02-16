<a wire:navigate {{ $attributes->merge(['class' => 'items-center px-4 py-2 bg-primary-100 border border-transparent rounded-md font-semibold text-xs uppercase tracking-widest hover:bg-primary-300 transition ease-in-out duration-200']) }}>
    {{ $slot }}
</a>

