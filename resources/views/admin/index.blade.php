<x-app-layout>
    <div class="max-w-xl flex flex-col gap-4 mx-auto">
        <x-h1 class="flex gap-4 items-end justify-center pb-4">
            <x-heroicon-o-exclamation-triangle class="h-8"/>
            Danger Zone
            <x-heroicon-o-exclamation-triangle class="h-8"/>
        </x-h1>
        @foreach($events as $event)
            <article class="mb-4 flex flex-col gap-2 border-b pb-4">
                <x-h2 class="grow">{{ $event->name }}</x-h2>
                <div class="flex items-center gap-4">
                    <p>{{ $event->start_date }}</p>
                    <x-link href="{{ route('events.edit', $event) }}">Edit</x-link>
                    <x-danger-button
                        x-on:click.prevent="$dispatch('open-modal', 'confirm_{{ $event->id }}')"
                    >
                        {{ __('Delete Event') }}
                    </x-danger-button>
                </div>

                <x-modal name='confirm_{{ $event->id }}' :show="$errors->eventDeletion->isNotEmpty()" focusable>
                    <form method="post" action="{{ route('admin.events.destroy', $event) }}" class="p-6">
                        @csrf
                        @method('delete')

                        <h2 class="text-lg font-medium text-gray-900">
                            {{ __('Are you sure you want to delete this event?') }}
                        </h2>

                        <div class="mt-6 flex justify-end">
                            <x-secondary-button x-on:click="$dispatch('close')">
                                {{ __('Cancel') }}
                            </x-secondary-button>

                            <x-danger-button class="ms-3">
                                {{ __('Delete Event') }}
                            </x-danger-button>
                        </div>
                    </form>
                </x-modal>
            </article>
        @endforeach
    </div>
</x-app-layout>
