<x-guest-layout>
    <style>
        input {
            background-color: #fff;
            border: 1px solid #ccc;
            border-radius: 6px;
            padding: 10px;
            color: #1E212D;
        }
        label,
        .text-sm,
        .text-gray-600,
        .dark\:text-gray-400,
        .dark\:text-gray-600 {
            color: #1E212D !important;
        }
    </style>

  

    <div class="mb-4 text-sm" style="color: #1E212D;">
        {{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
    </div>

    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <div class="mb-3">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="form-control mt-1 w-100" type="email" name="email" :value="old('email')" required autofocus />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="d-flex justify-content-end">
            <button class="btn btn-primary">{{ __('Email Password Reset Link') }}</button>
        </div>
    </form>
</x-guest-layout>
