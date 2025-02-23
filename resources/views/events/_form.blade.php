<form method="POST"
      action="{{ $actionUrl }}"
      enctype="multipart/form-data"
      x-data="{
          startDate: '{{ old('start_date', $event->start_date ?? '') }}',
          endDate: '{{ old('end_date', $event->end_date ?? '') }}',
          init() {
              this.$watch('startDate', value => {
                  if (!this.endDate || new Date(value) > new Date(this.endDate)) {
                      this.endDate = value;
                  }
              });
          }
      }">
    @csrf
    @if($method !== 'POST')
        @method($method)
    @endif

    <x-h1 class="mb-4">{{ $headerText }}</x-h1>
    <div class="border rounded-md p-4">
        <x-h3>{{ __('Event Details') }}</x-h3>
        <!-- Name Field -->
        <div class="mt-4">
            <x-input-label for="name" :value="__('Name')"/>
            <x-text-input id="name"
                          class="block mt-1 w-full md:w-1/2"
                          type="text"
                          name="name"
                          value="{{ old('name', $event->name ?? '') }}"
                          required
                          autofocus/>
            <x-input-error :messages="$errors->get('name')" class="mt-2"/>
        </div>
        <!-- Start and End Date Fields -->
        <div class="mt-4 flex gap-4 justify-between md:justify-normal">
            <div>
                <x-input-label for="start_date" :value="__('Start Date')"/>
                <x-date-input id="start_date"
                              name="start_date"
                              x-model="startDate"
                              required/>
                <x-input-error :messages="$errors->get('start_date')" class="mt-2"/>
            </div>
            <div>
                <x-input-label for="end_date" :value="__('End Date')"/>
                <x-date-input id="end_date"
                              name="end_date"
                              x-model="endDate"
                              required/>
                <x-input-error :messages="$errors->get('end_date')" class="mt-2"/>
            </div>
        </div>
        <div class="mt-4">
            <x-input-label for="location" :value="__('Location')"/>
            <x-text-input id="location"
                          class="w-full md:w-1/2"
                          type="text"
                          name="location"
                          value="{{ old('location', $event->location ?? '') }}"
                          required/>
            <x-input-error :messages="$errors->get('location')" class="mt-2"/>
        </div>
    </div>
    <div class="mt-4 border rounded-md p-4">
        <x-h3>{{ __('Description') }}</x-h3>
        <x-input-label for="description" :value="__('Write something about the event!')"/>
        <x-trix-input id="description"
                      name="description"
                      value="{!! old('description', $event?->description->body->toTrixHtml() ?? '') !!}"/>
        <x-input-error :messages="$errors->get('description')" class="mt-2"/>
    </div>
    <div class="md:flex md:gap-4">
        <div class="mt-4 border rounded-md p-4 md:w-1/2">
            <x-h3>{{ __('Banner') }}</x-h3>
            <x-input-label for="banner" class="mt-4">
                {{ __('Add a banner, will be shown on the event details page') }}
            </x-input-label>
            <div x-data="{ fileName: '' }">
                <x-secondary-button class="flex gap-2 my-2" x-on:click="$refs.fileInput.click()">
                    <x-heroicon-o-folder-open class="h-5" />{{ __('Upload Banner') }}
                </x-secondary-button>
                <input id="banner"
                       name="banner"
                       type="file"
                       accept="image/*"
                       class="hidden"
                       x-ref="fileInput"
                       x-on:change="fileName = $event.target.files[0] ? $event.target.files[0].name : ''">
                <template x-if="fileName">
                    <div class="mt-2 text-sm text-gray-600" x-text="fileName"></div>
                </template>
            </div>
            <x-input-error :messages="$errors->get('banner')" class="mt-2"/>

            @isset($event)
                @if($event->banner)
                    <div class="mt-4" id="banner_display">
                        <x-input-label for="current-banner" :value="__('Current Banner')"/>
                        <img src="{{ $event->banner_url }}" alt="{{ $event->name }}" class="w-full">
                        <!-- Hidden field to signal deletion -->
                        <input type="hidden" name="delete_banner" id="deleteBannerField" value="0">
                        <!-- Delete Banner Button -->
                        <x-danger-button
                            class="mt-2"
                            onclick="
                            event.preventDefault();
                            document.getElementById('deleteBannerField').value = '1';
                            document.getElementById('banner_display').style.display = 'none';
                        ">
                            {{ __('Delete Banner') }}
                        </x-danger-button>
                    </div>
                @endif
            @endisset
        </div>
        <div class="mt-4 border rounded-md p-4 md:w-1/2">
            <x-h3>{{ __('Icon') }}</x-h3>
            <x-input-label for="icon" class="mt-4">
                {{__('Add a small picture for the calendar (should be square)')}}
            </x-input-label>
            <div x-data="{ fileName: '' }">
                <x-secondary-button class="flex gap-2 my-2" x-on:click="$refs.fileInput.click()">
                    <x-heroicon-o-folder-open class="h-5" />Upload Icon
                </x-secondary-button>
                <input id="icon"
                       name="icon"
                       type="file"
                       accept="image/*"
                       class="hidden"
                       x-ref="fileInput"
                       x-on:change="fileName = $event.target.files[0] ? $event.target.files[0].name : ''">
                <template x-if="fileName">
                    <div class="mt-2 text-sm text-gray-600" x-text="fileName"></div>
                </template>
            </div>
            <x-input-error :messages="$errors->get('icon')" class="mt-2"/>
            @isset($event)
                @if($event->icon)
                    <div class="mt-4" id="icon_display">
                        <x-input-label for="current-icon" :value="__('Current Icon')"/>
                        <img src="{{ $event->icon_url }}" alt="{{ $event->name }}" class="w-16 h-16 rounded-lg">
                        <!-- Hidden field to signal deletion -->
                        <input type="hidden" name="delete_icon" id="deleteIconField" value="0">
                        <!-- Delete Icon Button -->
                        <x-danger-button
                            class="mt-2"
                            onclick="
                            event.preventDefault();
                            document.getElementById('deleteIconField').value = '1';
                            document.getElementById('icon_display').style.display = 'none';
                        ">
                            {{ __('Delete Icon') }}
                        </x-danger-button>
                    </div>
                @endif
            @endisset
        </div>
    </div>
    <div class="flex items-center justify-end mt-4">
        <x-primary-button class="ml-4">
            {{ $buttonText }}
        </x-primary-button>
    </div>
</form>
