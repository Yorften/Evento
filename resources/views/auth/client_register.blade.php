<x-guest-layout>
    <form method="POST" id="register_form" action="{{ route('register.patient') }}">
        @csrf

        <!-- Insurance Company -->
        <div>
            <x-input-label for="insurance" :value="__('Insurance Company')" />
            <x-text-input id="insurance" class="block mt-1 w-full" type="text" name="insurance" :value="old('insurance')"
                autofocus />
            <x-input-error-js id="insuranceErr"></x-input-error-js>
            <x-input-error :messages="$errors->get('insurance')" class="mt-2" />
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
    @endpush
</x-guest-layout>
