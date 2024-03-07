<x-guest-layout>
    <form method="POST" id="register_form" action="{{ route('register.doctor') }}">
        @csrf

        <!-- INPE Number -->
        <div>
            <x-input-label for="inpe" :value="__('INPE Number')" />
            <x-text-input id="inpe" class="block mt-1 w-full" type="text" name="inpe" :value="old('inpe')"
                autofocus />
            <x-input-error-js id="inpeErr"></x-input-error-js>
            <x-input-error :messages="$errors->get('inpe')" class="mt-2" />
        </div>

        <!-- Degree -->
        <div class="mt-4">
            <x-input-label for="diploma" :value="__('Diploma')" />
            <x-text-input id="diploma" class="block mt-1 w-full" type="text" name="diploma" :value="old('diploma')"
                autofocus />
            <x-input-error-js id="diplomaErr"></x-input-error-js>
            <x-input-error :messages="$errors->get('diploma')" class="mt-2" />
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
            <x-input-label for="speciality" :value="__('Speciality')" />
            <x-select-input id="speciality" class="block mt-1 w-full" name="speciality">
                <option value="" disabled selected hidden>Select your speciality...</option>
                @unless (count($specialities) == 0)
                    <div class="grid grid-cols-1 md:grid-cols-2 md:mt-12 lg:grid-cols-3 mt-8 gap-2">
                        @foreach ($specialities as $speciality)
                            <option value="{{ $speciality->id }}">{{ $speciality->name }}</option>
                        @endforeach
                    </div>
                @else
                    <option value="">No specialities found</option>
                @endunless
            </x-select-input>
            <x-input-error-js id="specialityErr"></x-input-error-js>
            <x-input-error :messages="$errors->get('speciality')" class="mt-2" />
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
