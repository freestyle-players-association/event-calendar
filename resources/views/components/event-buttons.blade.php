@if(Auth::user() && Auth::user()->can('delete', $event)
    || Auth::user() && Auth::user()->can('update', $event))
    <div class="flex justify-between">
        @if(Auth::user() && Auth::user()->can('update', $event))
            <x-link href="{{ route('events.edit', $event) }}">
                {{ __('Edit Event') }}
            </x-link>
        @endif
        @if(Auth::user() && Auth::user()->can('delete', $event))
            <x-danger-button
                x-data=""
                x-on:click.prevent="$dispatch('open-modal', 'confirm-event-deletion')"
            >{{ __('Delete Event') }}</x-danger-button>

            <x-modal name="confirm-event-deletion" :show="$errors->eventDeletion->isNotEmpty()" focusable>
                <form method="post" action="{{ route('events.destroy', $event) }}" class="p-6">
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
        @endif
    </div>
    <hr class="w-full h-px my-8 bg-slate-200 border-0">
@endif
