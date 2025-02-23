<x-app-layout>
    <div class="py-4">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-4 sm:px-10 bg-white border-b border-gray-200">
                    @include('events._form', [
                        'actionUrl' => route('events.store'),
                        'method' => 'POST',
                        'headerText' => __('Add a new Event'),
                        'buttonText' => __('Create'),
                        'event' => null
                    ])
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
