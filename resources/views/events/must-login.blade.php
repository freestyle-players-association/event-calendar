<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create Event') }}
        </h2>
    </x-slot>

    <div class="py-4">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-4 sm:px-10 bg-white border-b border-gray-200">
                    <p class="text-lg text-gray-800">{{ __('Please log in to create an event') }}</p>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>
