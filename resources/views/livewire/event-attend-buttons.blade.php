<div class="flex gap-2">
    @if(Auth::user())
        <!-- Attending -->
        <label for="attending"
               class="text-sm cursor-pointer flex items-center justify-center px-4 py-2 border border-secondary-900 rounded-md transition-colors
                    {{ $status === 'attending' ? 'bg-secondary-900 text-white' : 'bg-white text-gray-800' }}">
            <input type="radio" name="status" id="attending" class="sr-only"
                   wire:click="toggleStatus('attending')"
                {{ $status === 'attending' ? 'checked' : '' }}>
            Attending
        </label>

        <!-- Interested -->
        <label for="interested"
               class="text-sm cursor-pointer flex items-center justify-center px-4 py-2 border border-secondary-900 rounded-md transition-colors
                    {{ $status === 'interested' ? 'bg-secondary-900 text-white' : 'bg-white text-gray-800' }}">
            <input type="radio" name="status" id="interested" class="sr-only"
                   wire:click="toggleStatus('interested')"

                {{ $status === 'interested' ? 'checked' : '' }}>
            Interested
        </label>

        <!-- Not Attending -->
        <label for="not-attending"
               class="text-sm cursor-pointer text-center flex items-center justify-center px-4 py-2 border border-secondary-900 rounded-md transition-colors
                    {{ !$status ? 'bg-secondary-900 text-white' : 'bg-white text-gray-800' }}">
            <input type="radio" name="status" id="not-attending" class="sr-only"
                   wire:click="toggleStatus('')"
                {{ !$status ? 'checked' : '' }}>
            Not Attending
        </label>
    @else
        <a href="{{ route('login') }}"
           class="text-sm cursor-pointer flex items-center justify-center px-4 py-2 border rounded-md transition-colors
                bg-white text-gray-800">
            Login to RSVP
        </a>
    @endif
</div>
