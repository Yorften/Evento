<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Organizer Information') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __('Update your organization information.') }}
        </p>
    </header>

    <form method="post" action="{{ route('organizers.update', $organizer->id) }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        <!-- Company -->
        <div>
            <x-input-label for="company" :value="__('Company')" />
            <x-text-input id="company" class="block mt-1 w-full" type="text" name="company" :value="old('company', $organizer->company)"
                autofocus />
            <x-input-error-js id="companyErr"></x-input-error-js>
            <x-input-error :messages="$errors->get('company')" class="mt-2" />
        </div>

        <!-- Company email -->
        <div class="mt-4">
            <x-input-label for="company_email" :value="__('Company Email')" />
            <x-text-input id="company_email" class="block mt-1 w-full" type="text" name="company_email"
                :value="old('company_email', $organizer->company_email)" autofocus />
            <x-input-error-js id="company_emailErr"></x-input-error-js>
            <x-input-error :messages="$errors->get('company_email')" class="mt-2" />
        </div>

        <!-- Website -->
        <div class="mt-4">
            <x-input-label for="website" :value="__('Website')" />
            <x-text-input id="website" class="block mt-1 w-full" type="text" name="website" :value="old('website', $organizer->website)"
                autofocus />
            <x-input-error-js id="websiteErr"></x-input-error-js>
            <x-input-error :messages="$errors->get('website')" class="mt-2" />
        </div>

        <!-- Phone number -->
        <div class="mt-4">
            <x-input-label for="phone" :value="__('Phone Number')" />
            <x-text-input id="phone" class="block mt-1 w-full" type="text" name="phone" :value="old('phone', $organizer->phone)"
                autofocus />
            <x-input-error-js id="phoneErr"></x-input-error-js>
            <x-input-error :messages="$errors->get('phone')" class="mt-2" />
        </div>


        <div class="mt-4">
            <x-input-label for="type" :value="__('Organizer Type')" />
            <x-select-input id="type" class="block mt-1 w-full" name="type" :value="old('type', $organizer->type)">
                <option value="" disabled hidden>Select your type...</option>
                <option value="nonprofit">Non Profit</option>
                <option value="company">Company</option>
            </x-select-input>
            <x-input-error-js id="typeErr"></x-input-error-js>
            <x-input-error :messages="$errors->get('type')" class="mt-2" />
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>

            @if (session('status') === 'doctor-updated')
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600">{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>
