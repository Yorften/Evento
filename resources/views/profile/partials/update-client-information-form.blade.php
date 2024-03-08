<section>
    @push('vite')
        <script src="https://code.jquery.com/jquery-3.7.1.min.js"
            integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js" defer></script>
    @endpush
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Patient Information') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __("Update your account's private information.") }}
        </p>
    </header>


    <form method="post" action="{{ route('clients.update', $client->id) }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        <!-- Country -->
        <div>
            <x-input-label for="country" :value="__('Country')" />
            <x-select-country id="country" class="block mt-1 w-full" type="text" name="country" :value="old('country', $client->country)"
                autofocus />
            <x-input-error-js id="countryErr"></x-input-error-js>
            <x-input-error :messages="$errors->get('country')" class="mt-2" />
        </div>

        <!-- City -->
        <div class="mt-4">
            <x-input-label for="city" :value="__('City')" />
            <x-text-input id="city" class="block mt-1 w-full" type="text" name="city" :value="old('city', $client->city)"
                autofocus />
            <x-input-error-js id="cityErr"></x-input-error-js>
            <x-input-error :messages="$errors->get('city')" class="mt-2" />
        </div>

        <!-- Phone Number -->
        <div class="mt-4">
            <x-input-label for="phone" :value="__('Phone Number')" />
            <x-text-input id="phone" class="block mt-1 w-full" type="text" name="phone" :value="old('phone', $client->phone)"
                autofocus />
            <x-input-error-js id="phoneErr"></x-input-error-js>
            <x-input-error :messages="$errors->get('phone_number')" class="mt-2" />
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>

            @if (session('status') === 'patient-updated')
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600">{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
    @push('scripts')
        <script>
            $(document).ready(function() {
                $('#country').select2({
                    width: '100%',
                });
            });
        </script>
    @endpush
</section>
