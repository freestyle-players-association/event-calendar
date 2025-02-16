<x-app-layout>
    {!! NoCaptcha::renderJs() !!}
    <x-h1 class="pb-4">
        {{ __('Get in touch') }}
    </x-h1>
    <p class="pb-4">
        {{ __('If you have any questions or feedback, feel free to send us a message using the form below.') }}
    </p>
    <form method="POST" action="{{ route('contact.submit') }}">
        @csrf
        <div class="mb-4">
            <label for="name" class="block text-sm font-medium text-gray-700">{{ __('Name') }}</label>
            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" value="{{ Auth::check() ? Auth::user()->name : '' }}" required />
            @error('name')
            <x-input-error :messages="$errors->first('name')" />
            @enderror
        </div>

        <div class="mb-4">
            <label for="email" class="block text-sm font-medium text-gray-700">{{ __('Email') }}</label>
            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" value="{{ Auth::check() ? Auth::user()->email : '' }}" required />
            @error('email')
            <x-input-error :messages="$errors->first('email')" />
            @enderror
        </div>

        <div class="mb-4">
            <label for="body" class="block text-sm font-medium text-gray-700">{{ __('Message') }}</label>
            <textarea id="body" name="body" rows="4" class="border-gray-300 focus:border-primary-500 focus:ring-primary-500 rounded-md shadow-sm mt-1 block w-full" required></textarea>
            @error('body')
            <x-input-error :messages="$errors->first('body')" />
            @enderror
        </div>
        <div class="mb-4">
            @if ($errors->has('g-recaptcha-response'))
                <span class="help-block">
                    <strong>{{ $errors->first('g-recaptcha-response') }}</strong>
                </span>
            @endif
            {!! NoCaptcha::display() !!}
        </div>
        <div class="flex gap-4 items-center">
            <x-primary-button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md">
                {{ __('Send') }}
            </x-primary-button>
            @if(session('success'))
                <div class="font-medium text-sm text-green-600">
                    {{ session('success') }}
                </div>
            @endif
        </div>
    </form>
</x-app-layout>
