<x-app-layout>
    <div class="py-4">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-4 sm:px-10 bg-white border-b border-gray-200">
                    <form method="POST" action="{{ route('events.update', $event) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div>
                            <x-input-label for="name" :value="__('Name')"/>
                            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name"
                                          value="{{ $event->name }}" required autofocus/>
                        </div>
                        <div class="flex gap-2">
                            <div class="mt-4">
                                <x-input-label for="start_date" :value="__('Start Date')"/>
                                <x-date-input id="start_date" name="start_date" value="{{ $event->start_date }}"
                                              required/>
                            </div>
                            <div class="mt-4">
                                <x-input-label for="end_date" :value="__('End Date')"/>
                                <x-date-input id="end_date" name="end_date" value="{{ $event->end_date }}" required/>
                            </div>
                        </div>
                        <div class="mt-4">
                            <x-input-label for="location" :value="__('Location')"/>
                            <x-text-input id="location" class="block mt-1 w-full" type="text" name="location"
                                          value="{{ $event->location }}" required/>
                        </div>
                        <div class="mt-4">
                            <x-input-label for="description" :value="__('Description')"/>
                            <x-trix-input id="description" name="description"
                                          value="{!! $event->description->body->toTrixHtml() !!}"/>
                        </div>
                        <!-- Banner File Upload -->
                        <div class="mt-4">
                            <x-input-label for="banner" :value="__('Banner')" />
                            <!-- Standard file input field; you can adjust styling as needed -->
                            <input id="banner" class="block mt-1 w-full" type="file" name="banner" accept="image/*">
                        </div>
                        <!-- Icon File Upload -->
                        <div class="mt-4">
                            <x-input-label for="icon" :value="__('Icon')" />
                            <input id="icon" class="block mt-1 w-full" type="file" name="icon" accept="image/*">
                        </div>
                        <div class="flex items-center justify-end mt-4">
                            <x-primary-button class="ml-4">
                                {{ __('Update') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
