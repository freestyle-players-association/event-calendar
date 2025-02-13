<footer class="border-t bg-white">
    <div class="max-w-7xl mx-auto py-6 px-8 sm:px-6 lg:px-8 flex justify-between items-center">
        <div class="flex gap-4">
            <a href="{{ route('home') }}" class="text-sm text-gray-500 hover:text-gray-600">
                {{ __('Event Calendar') }}
            </a>
        </div>
        <div class="text-sm text-gray-500">
            <a href="{{ route('contact.show') }}" class="text-sm text-gray-500 hover:text-gray-600">
                {{ __('Contact') }}
            </a>
        </div>
    </div>
</footer>
