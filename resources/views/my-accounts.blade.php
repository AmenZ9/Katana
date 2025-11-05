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
                <div class="p-4 mb-4 text-sm text-green-700 bg-green-100 rounded-lg dark:bg-green-200 dark:text-green-800"
                    role="alert">
                    {{ session('status') }}
                </div>
            @endif
            @if (session('error'))
                <div class="p-4 mb-4 text-sm text-red-700 bg-red-100 rounded-lg dark:bg-red-200 dark:text-red-800"
                    role="alert">
                    {{ session('error') }}
                </div>
            @endif

            {{-- Section for Linking New Accounts --}}
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
                        // Use the $linkedAccounts variable that we passed from the controller
                        $githubAccount = $linkedAccounts->firstWhere('provider_name', 'github');
                    @endphp

                    @if (!$githubAccount)
                        {{-- If NOT linked, show the button --}}
                        <div class="mt-6">
                            <a href="{{ route('auth.social.redirect', ['provider' => 'github']) }}" ...>
                                Link GitHub Account
                            </a>
                        </div>
                    @else
                        <p class="mt-4 text-sm text-green-600 dark:text-green-400">Your GitHub account is already linked.
                        </p>
                    @endif
                </div>
            </div>

            {{-- Section for Displaying and Unlinking Accounts --}}
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <header>
                    <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                        {{ __('Your Linked Accounts') }}
                    </h2>
                </header>

                <div class="mt-6 space-y-4">
                    @forelse ($linkedAccounts as $account)
                        <div class="flex items-center justify-between p-4 border rounded-lg dark:border-gray-700">
                            {{-- Account Info --}}
                            <div class="flex items-center">
                                <img class="h-10 w-10 rounded-full" src="{{ $account->avatar }}" alt="{{ $account->name }}">
                                <div class="ms-4">
                                    <div class="font-medium text-gray-900 dark:text-gray-100">
                                        {{ $account->name ?? $account->nickname }}</div>
                                    <div class="text-sm text-gray-500 dark:text-gray-400">
                                        Linked via {{ ucfirst($account->provider_name) }}
                                    </div>
                                </div>
                            </div>

                            {{-- Unlink Button Form --}}
                            <form method="POST" action="{{ route('my-accounts.destroy', $account) }}">
                                @csrf
                                @method('DELETE')

                                <button type="submit"
                                    class="text-sm font-medium text-red-600 dark:text-red-400 hover:underline"
                                    onclick="return confirm('Are you sure you want to unlink this account?')">
                                    Unlink
                                </button>
                            </form>
                        </div>
                    @empty
                        <p class="text-gray-500 dark:text-gray-400">You have no linked accounts yet.</p>
                    @endforelse
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
