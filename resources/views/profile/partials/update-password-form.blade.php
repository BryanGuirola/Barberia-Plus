<section style="background-color: #F3ECE7; color: #1E212D;" class="p-6 rounded-xl">
    <header>
        <h2 class="text-lg font-medium" style="color: #1E212D;">
            {{ __('Update Password') }}
        </h2>

        <p class="mt-1 text-sm" style="color: #2E2E2D;">
            {{ __('Ensure your account is using a long, random password to stay secure.') }}
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('put')

        <div>
            <x-input-label for="update_password_current_password" :value="__('Current Password')" />
            <x-text-input id="update_password_current_password" name="current_password" type="password" class="mt-1 block w-full border border-[#D4A373] focus:border-[#B06C49] focus:ring-[#B06C49]" autocomplete="current-password" />
            <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="update_password_password" :value="__('New Password')" />
            <x-text-input id="update_password_password" name="password" type="password" class="mt-1 block w-full border border-[#D4A373] focus:border-[#B06C49] focus:ring-[#B06C49]" autocomplete="new-password" />
            <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="update_password_password_confirmation" :value="__('Confirm Password')" />
            <x-text-input id="update_password_password_confirmation" name="password_confirmation" type="password" class="mt-1 block w-full border border-[#D4A373] focus:border-[#B06C49] focus:ring-[#B06C49]" autocomplete="new-password" />
            <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center gap-4">
            <button type="submit" class="btn btn-success text-white px-4 py-2 rounded hover:bg-[#D4A373] focus:outline-none focus:ring-2 focus:ring-[#D4A373]">
                {{ __('Save') }}
            </button>

            @if (session('status') === 'password-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm"
                    style="color: #B06C49;"
                >{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>
