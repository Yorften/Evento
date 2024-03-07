<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Organizer Information') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __('Update your organization information.') }}
        </p>
    </header>

    <form method="post" action="{{ route('organizer.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        <!-- INPE Number -->
        <div>
            <x-input-label for="inpe" :value="__('INPE Number')" />
            <x-text-input id="inpe" class="block mt-1 w-full" type="text" name="inpe" :value="old('inpe', $doctor->inpe)"
                autofocus />
            <x-input-error-js id="inpeErr"></x-input-error-js>
            <x-input-error :messages="$errors->get('inpe')" class="mt-2" />
        </div>

        <!-- Degree -->
        <div class="mt-4">
            <x-input-label for="diploma" :value="__('Diploma')" />
            <x-text-input id="diploma" class="block mt-1 w-full" type="text" name="diploma" :value="old('diploma', $doctor->diploma)"
                autofocus />
            <x-input-error-js id="diplomaErr"></x-input-error-js>
            <x-input-error :messages="$errors->get('diploma')" class="mt-2" />
        </div>

        <!-- Phone number -->
        <div class="mt-4">
            <x-input-label for="phone" :value="__('Phone Number')" />
            <x-text-input id="phone" class="block mt-1 w-full" type="text" name="phone_number" :value="old('phone_number', $doctor->phone_number)"
                autofocus />
            <x-input-error-js id="phoneErr"></x-input-error-js>
            <x-input-error :messages="$errors->get('phone_number')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label for="speciality" :value="__('Speciality')" />
            <x-select-input id="speciality" class="block mt-1 w-full" name="speciality_id" :value="old('speciality_id')">
                <option value="" disabled hidden>Select your speciality...</option>
                @unless (count($specialities) == 0)
                    <div class="grid grid-cols-1 md:grid-cols-2 md:mt-12 lg:grid-cols-3 mt-8 gap-2">
                        @foreach ($specialities as $speciality)
                            <option value="{{ $speciality->id }}"
                                {{ $speciality->id == $doctor->speciality_id ? 'selected' : '' }}>{{ $speciality->name }}
                            </option>
                        @endforeach
                    </div>
                @else
                    <option value="">No specialities found</option>
                @endunless
            </x-select-input>
            <x-input-error-js id="specialityErr"></x-input-error-js>
            <x-input-error :messages="$errors->get('speciality_id')" class="mt-2" />
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
