<x-guest-layout>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4" x-data="{ show: false }">
            <x-input-label for="password" :value="__('Password')" />
            <div class="relative">
                <x-text-input id="password" class="block mt-1 w-full"
                                :type="show ? 'text' : 'password'"
                                name="password"
                                required autocomplete="new-password" />

                <div @click="show = !show" class="absolute inset-y-0 right-0 pr-3 flex items-center cursor-pointer">
                    <svg class="h-6 w-6 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path x-show="!show" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7 1.274-4.057 5.064-7 9.542-7 .847 0 1.67.127 2.455.364m-6.91 6.91a3 3 0 014.242-4.242" />
                        <path x-show="!show" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.98 8.223A10.034 10.034 0 002.458 12c1.274 4.057 5.064 7 9.542 7a10.034 10.034 0 003.777-.623M12 5v.01M19.978 15.777A10.034 10.034 0 0021.542 12c-1.274-4.057-5.064-7-9.542-7a10.034 10.034 0 00-3.777.623m1.903 1.903A3 3 0 0112 9a3 3 0 012.121.879" />
                        <path x-show="!show" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 1l22 22" />
                        <path x-show="show" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path x-show="show" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    </svg>
                </div>
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4" x-data="{ show: false }">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
            <div class="relative">
                <x-text-input id="password_confirmation" class="block mt-1 w-full"
                                :type="show ? 'text' : 'password'"
                                name="password_confirmation"
                                required autocomplete="new-password" />

                <div @click="show = !show" class="absolute inset-y-0 right-0 pr-3 flex items-center cursor-pointer">
                    <svg class="h-6 w-6 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path x-show="!show" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7 1.274-4.057 5.064-7 9.542-7 .847 0 1.67.127 2.455.364m-6.91 6.91a3 3 0 014.242-4.242" />
                        <path x-show="!show" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.98 8.223A10.034 10.034 0 002.458 12c1.274 4.057 5.064 7 9.542 7a10.034 10.034 0 003.777-.623M12 5v.01M19.978 15.777A10.034 10.034 0 0021.542 12c-1.274-4.057-5.064-7-9.542-7a10.034 10.034 0 00-3.777.623m1.903 1.903A3 3 0 0112 9a3 3 0 012.121.879" />
                        <path x-show="!show" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 1l22 22" />
                        <path x-show="show" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path x-show="show" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    </svg>
                </div>
            </div>
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800" href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>

            <x-primary-button class="ms-4">
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
