<div class="flex space-x-2">
    <!-- Attending -->
    <label for="attending"
           class="text-sm cursor-pointer text-center px-2 py-1 border rounded-md transition-colors
                {{ $status === 'attending' ? 'bg-blue-600 text-white' : 'bg-white text-gray-800' }}">
        <input type="radio" name="status" id="attending" class="sr-only"
               wire:click="toggleStatus('attending')"
            {{ $status === 'attending' ? 'checked' : '' }}>
        Attending
    </label>

    <!-- Interested -->
    <label for="interested"
           class="text-sm cursor-pointer text-center px-2 py-1 border rounded-md transition-colors
                {{ $status === 'interested' ? 'bg-blue-600 text-white' : 'bg-white text-gray-800' }}">
        <input type="radio" name="status" id="interested" class="sr-only"
               wire:click="toggleStatus('interested')"

            {{ $status === 'interested' ? 'checked' : '' }}>
        Interested
    </label>

    <!-- Not Attending -->
    <label for="not-attending"
           class="text-sm cursor-pointer text-center px-2 py-1 border rounded-md transition-colors
                {{ !$status ? 'bg-blue-600 text-white' : 'bg-white text-gray-800' }}">
        <input type="radio" name="status" id="not-attending" class="sr-only"
               wire:click="toggleStatus('')"
            {{ !$status ? 'checked' : '' }}>
        Not Attending
    </label>
</div>
