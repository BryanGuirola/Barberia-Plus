<x-guest-layout>
    <form method="POST" action="{{ route('register') }}">
        @csrf
        <style>
            label,
            .text-sm,
            .text-gray-600,
            .dark\:text-gray-400,
            .dark\:text-gray-600 {
                color: #1E212D !important;
            }
            input {
                background-color: #fff;
                border: 1px solid #ccc;
                border-radius: 6px;
                padding: 10px;
                color: #1E212D;
            }
        </style>

      

        <div class="mb-3">
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" class="form-control mt-1 w-100" type="text" name="name" :value="old('name')" required autofocus />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <div class="mb-3">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="form-control mt-1 w-100" type="email" name="email" :value="old('email')" required />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="mb-3">
            <x-input-label for="password" :value="__('Password')" />
            <x-text-input id="password" class="form-control mt-1 w-100" type="password" name="password" required />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="mb-3">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
            <x-text-input id="password_confirmation" class="form-control mt-1 w-100" type="password" name="password_confirmation" required />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="d-flex justify-content-between align-items-center">
            <a href="{{ route('login') }}" class="text-decoration-none" style="color: #B06C49;">{{ __('Already registered?') }}</a>
            <button class="btn btn-primary">{{ __('Register') }}</button>
        </div>
    </form>
</x-guest-layout>