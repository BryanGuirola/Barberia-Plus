<section style="background-color: #F3ECE7; color: #1E212D;" class="p-6 rounded-xl">
    <header>
        <h2 class="text-lg font-medium" style="color: #1E212D;">
            {{ __('Profile Information') }}
        </h2>

        <p class="mt-1 text-sm" style="color: #2E2E2D;">
            {{ __("Update your account's profile information and email address.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('cliente.profile.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full border border-[#D4A373] focus:border-[#B06C49] focus:ring-[#B06C49]" :value="old('name', $user->name)" required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full border border-[#D4A373] focus:border-[#B06C49] focus:ring-[#B06C49]" :value="old('email', $user->email)" required autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div>
                    <p class="text-sm mt-2" style="color: #2E2E2D;">
                        {{ __('Your email address is unverified.') }}
                        <button form="send-verification" class="underline text-sm text-gray-600 hover:text-[#1E212D] rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#B06C49]">
                            {{ __('Click here to re-send the verification email.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm text-green-600">
                            {{ __('A new verification link has been sent to your email address.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <div class="flex items-center gap-4">
            <button type="submit" class="btn btn-success text-white px-4 py-2 rounded hover:bg-[#D4A373] focus:outline-none focus:ring-2 focus:ring-[#D4A373]">
                {{ __('Save') }}
            </button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm"
                    style="color: #2E2E2D;"
                >{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>
