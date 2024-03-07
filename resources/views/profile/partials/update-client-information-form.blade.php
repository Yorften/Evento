<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Patient Information') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __("Update your account's private information.") }}
        </p>
    </header>

    <form method="post" action="{{ route('patient.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        <!-- Insurance Company -->
        <div>
            <x-input-label for="insurance" :value="__('Insurance Company')" />
            <x-text-input id="insurance" class="block mt-1 w-full" type="text" name="insurance_name" :value="old('insurance_name', $patient->insurance_name)"
                autofocus />
            <x-input-error-js id="insuranceErr"></x-input-error-js>
            <x-input-error :messages="$errors->get('insurance_name')" class="mt-2" />
        </div>

        <!-- Phone Number -->
        <div>
            <x-input-label for="phone" :value="__('Phone Number')" />
            <x-text-input id="phone" class="block mt-1 w-full" type="text" name="phone_number" :value="old('phone_number', $patient->phone_number)"
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
</section>
