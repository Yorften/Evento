<x-guest-layout>
    @push('vite')
        <script src="https://code.jquery.com/jquery-3.7.1.min.js"
            integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js" defer></script>
    @endpush
    <form method="POST" id="register_form" action="{{ route('clients.store') }}">
        @csrf

        <!-- Country -->
        <div>
            <x-input-label for="country" :value="__('Country')" />
            <x-select-country id="country" class="block mt-1 w-full" type="text" name="country" :value="old('country')"
                autofocus />
            <x-input-error-js id="countryErr"></x-input-error-js>
            <x-input-error :messages="$errors->get('country')" class="mt-2" />
        </div>

        <!-- City -->
        <div class="mt-4">
            <x-input-label for="city" :value="__('City')" />
            <x-text-input id="city" class="block mt-1 w-full" type="text" name="city" :value="old('city')"
                autofocus />
            <x-input-error-js id="cityErr"></x-input-error-js>
            <x-input-error :messages="$errors->get('city')" class="mt-2" />
        </div>

        <!-- Phone number -->
        <div class="mt-4">
            <x-input-label for="phone" :value="__('Phone Number')" />
            <x-text-input id="phone" class="block mt-1 w-full" type="text" name="phone" :value="old('phone')"
                autofocus />
            <x-input-error-js id="phoneErr"></x-input-error-js>
            <x-input-error :messages="$errors->get('phone')" class="mt-2" />
        </div>


        <div class="flex items-center justify-end mt-4">
            <x-primary-button class="ms-4">
                {{ __('Register') }}
            </x-primary-button>
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
</x-guest-layout>
