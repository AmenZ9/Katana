<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('My Linked Accounts') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8"> {{-- Added space-y for consistent spacing --}}

            <!-- Session Status -->
            @if (session('status'))
                <div class="p-4 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400" role="alert">
                    {{ session('status') }}
                </div>
            @endif

            {{-- Box to add new accounts --}}
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">Link a New Account</h3>
                    <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                        Connect your gaming and social accounts to build your ultimate gamer profile.
                    </p>

                    <div class="mt-6">
                        <a href="{{ route('auth.github.redirect') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                            Link GitHub Account
                        </a>
                        {{-- We will add buttons for Steam, Riot, etc. here later --}}
                    </div>
                </div>
            </div>

            {{-- Grid of linked accounts --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse ($linkedAccounts as $account)
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-lg">
                        <div class="p-6 flex items-center space-x-4">
                            {{-- Avatar --}}
                            <img class="h-16 w-16 rounded-full" src="{{ $account->avatar }}" alt="{{ $account->nickname }}'s avatar">

                            {{-- Info --}}
                            <div>
                                <div class="flex items-center space-x-2">
                                    <h4 class="text-lg font-semibold text-gray-900 dark:text-gray-100">{{ $account->nickname }}</h4>
                                    <span class="px-2 py-1 text-xs font-semibold text-white bg-gray-600 rounded-full">{{ $account->provider_name }}</span>
                                </div>
                                <p class="text-sm text-gray-600 dark:text-gray-400">{{ $account->name }}</p>

                                {{-- Unlink Button (for the future) --}}
                                <div class="mt-3">
                                    <a href="#" class="text-sm text-red-500 hover:text-red-700">Unlink</a>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 text-center text-gray-500 dark:text-gray-400">
                            You haven't linked any accounts yet.
                        </div>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>
