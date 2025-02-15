<a wire:navigate {{ $attributes->merge(['class' => 'inline-flex items-center px-2 py-1 bg-indigo-100 border border-transparent rounded-md font-semibold text-xs uppercase tracking-widest hover:bg-indigo-300 transition ease-in-out duration-200']) }}>
    {{ $slot }}
</a>

