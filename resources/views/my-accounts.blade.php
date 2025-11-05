<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('My Linked Accounts') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- Success/Error Messages --}}
            @if (session('status'))
                <div class="p-4 mb-4 text-sm text-green-700 bg-green-100 rounded-lg dark:bg-green-200 dark:text-green-800" role="alert">
                    {{ session('status') }}
                </div>
            @endif
            @if (session('error'))
                <div class="p-4 mb-4 text-sm text-red-700 bg-red-100 rounded-lg dark:bg-red-200 dark:text-red-800" role="alert">
                    {{ session('error') }}
                </div>
            @endif

            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                        {{ __('Link Social Accounts') }}
                    </h3>
                    <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                        {{ __('Connect your social media accounts to log in with them.') }}
                    </p>

                    {{-- Check if GitHub account is already linked --}}
                    @php
                        $githubAccount = $user->linkedAccounts->firstWhere('provider_name', 'github');
                    @endphp

                    @if (!$githubAccount)
                        {{-- If NOT linked, show the button --}}
                        <div class="mt-6">
                            <a href="{{ route('auth.github.redirect') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                                Link GitHub Account
                            </a>
                        </div>
                    @endif

                </div>
            </div>

            {{-- Display Linked Accounts --}}
            @if ($user->linkedAccounts->isNotEmpty())
                <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                    <div class="max-w-xl">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                            {{ __('Your Linked Accounts') }}
                        </h3>

                        <div class="mt-6 space-y-4">
                            @foreach ($user->linkedAccounts as $account)
                                <div class="flex items-center justify-between p-4 border rounded-lg dark:border-gray-700">
                                    <div class="flex items-center">
                                        <img class="h-10 w-10 rounded-full" src="{{ $account->avatar }}" alt="{{ $account->name }}">
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900 dark:text-gray-100">{{ $account->name }} ({{ $account->nickname }})</div>
                                            <div class="text-sm text-gray-500 dark:text-gray-400">Linked via {{ ucfirst($account->provider_name) }}</div>
                                        </div>
                                    </div>
                                    {{-- Optional: Add a "Remove" button here in the future --}}
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif

        </div>
    </div>
</x-app-layout>
