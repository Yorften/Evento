<x-guest-layout>
    <form method="POST" id="register_form" action="{{ route('organizers.store') }}">
        @csrf

        <!-- Company -->
        <div>
            <x-input-label for="company" :value="__('Company')" />
            <x-text-input id="company" class="block mt-1 w-full" type="text" name="company" :value="old('company')"
                autofocus />
            <x-input-error-js id="companyErr"></x-input-error-js>
            <x-input-error :messages="$errors->get('company')" class="mt-2" />
        </div>

        <!-- Company email -->
        <div class="mt-4">
            <x-input-label for="company_email" :value="__('Company Email')" />
            <x-text-input id="company_email" class="block mt-1 w-full" type="text" name="company_email"
                :value="old('company_email')" autofocus />
            <x-input-error-js id="company_emailErr"></x-input-error-js>
            <x-input-error :messages="$errors->get('company_email')" class="mt-2" />
        </div>

        <!-- Website -->
        <div class="mt-4">
            <x-input-label for="website" :value="__('Website')" />
            <x-text-input id="website" class="block mt-1 w-full" type="text" name="website" :value="old('website')"
                autofocus />
            <x-input-error-js id="websiteErr"></x-input-error-js>
            <x-input-error :messages="$errors->get('website')" class="mt-2" />
        </div>

        <!-- Phone number -->
        <div class="mt-4">
            <x-input-label for="phone" :value="__('Phone Number')" />
            <x-text-input id="phone" class="block mt-1 w-full" type="text" name="phone" :value="old('phone')"
                autofocus />
            <x-input-error-js id="phoneErr"></x-input-error-js>
            <x-input-error :messages="$errors->get('phone')" class="mt-2" />
        </div>


        <div class="mt-4">
            <x-input-label for="type" :value="__('Organizer Type')" />
            <x-select-input id="type" class="block mt-1 w-full" name="type">
                <option value="" disabled selected hidden>Select your type...</option>
                <option value="nonprofit">Non Profit</option>
                <option value="company">Company</option>
            </x-select-input>
            <x-input-error-js id="typeErr"></x-input-error-js>
            <x-input-error :messages="$errors->get('type')" class="mt-2" />
        </div>


        <div class="flex items-center justify-end mt-4">
            <x-primary-button class="ms-4">
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form>
    @push('scripts')
    @endpush
</x-guest-layout>
