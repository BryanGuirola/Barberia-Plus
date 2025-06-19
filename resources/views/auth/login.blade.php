<x-guest-layout>
    <style>
        label,
        .text-sm,
        .text-gray-600,
        .dark\:text-gray-400,
        .dark\:text-gray-600 {
            color: #1E212D !important;
        }
        input[type="email"],
        input[type="password"],
        input[type="text"] {
            background-color: #fff;
            border: 1px solid #ccc;
            border-radius: 6px;
            padding: 10px;
            color: #1E212D;
        }
        .btn-primary {
            background-color: #B06C49;
            border: none;
        }
        .btn-primary:hover {
            background-color: #D4A373;
        }
        .brand-logo {
            width: 48px;
            height: 48px;
            display: block;
            margin: 0 auto 1rem;
            object-fit: contain;
        }
    </style>



    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf
        <div class="mb-3">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="form-control mt-1 w-100" type="email" name="email" :value="old('email')" required autofocus />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="mb-3">
            <x-input-label for="password" :value="__('Password')" />
            <x-text-input id="password" class="form-control mt-1 w-100" type="password" name="password" required />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="mb-3">
            <label for="remember_me" class="form-check-label" style="color: #1E212D;">
                <input id="remember_me" type="checkbox" class="form-check-input" name="remember">
                <span class="ms-2 text-sm">{{ __('Remember me') }}</span>
            </label>
        </div>

        <div class="d-flex justify-content-between align-items-center">
            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}" class="text-decoration-none" style="color: #B06C49;">{{ __('Forgot your password?') }}</a>
            @endif

            <button class="btn btn-primary ms-3">{{ __('Log in') }}</button>
        </div>
    </form>
</x-guest-layout>
