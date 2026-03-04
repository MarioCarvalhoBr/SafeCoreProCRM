<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('messages.edit_staff') }}: {{ $user->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    <form method="POST" action="{{ route('users.update', $user->id) }}" class="space-y-6">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                            <div>
                                <x-input-label for="name" :value="__('messages.name')" />
                                <x-text-input id="name" name="name" type="text" class="mt-1 block w-full dark:bg-gray-900 dark:border-gray-700" :value="old('name', $user->name)" required autofocus autocomplete="name" />
                                <x-input-error class="mt-2" :messages="$errors->get('name')" />
                            </div>

                            <div>
                                <x-input-label for="email" :value="__('messages.email')" />
                                <x-text-input id="email" name="email" type="email" class="mt-1 block w-full dark:bg-gray-900 dark:border-gray-700" :value="old('email', $user->email)" required autocomplete="username" />
                                <x-input-error class="mt-2" :messages="$errors->get('email')" />
                            </div>

                            <div>
                                <x-input-label for="password" :value="__('messages.password')" />
                                <x-text-input id="password" name="password" type="password" class="mt-1 block w-full dark:bg-gray-900 dark:border-gray-700" autocomplete="new-password" />
                                <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">{{ __('messages.leave_blank_to_keep') }}</p>
                                <x-input-error class="mt-2" :messages="$errors->get('password')" />
                            </div>

                            <div>
                                <x-input-label for="password_confirmation" :value="__('messages.password_confirmation')" />
                                <x-text-input id="password_confirmation" name="password_confirmation" type="password" class="mt-1 block w-full dark:bg-gray-900 dark:border-gray-700" autocomplete="new-password" />
                                <x-input-error class="mt-2" :messages="$errors->get('password_confirmation')" />
                            </div>

                            <div class="md:col-span-2">
                                <x-input-label for="role" :value="__('messages.role')" />
                                <select id="role" name="role" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 rounded-md shadow-sm" required {{ $user->id === auth()->id() ? 'disabled' : '' }}>
                                    @foreach($roles as $role)
                                        <option value="{{ $role->name }}" {{ old('role', $userRole) == $role->name ? 'selected' : '' }}>
                                            {{ strtoupper($role->name) }}
                                        </option>
                                    @endforeach
                                </select>

                                @if($user->id === auth()->id())
                                    <input type="hidden" name="role" value="{{ $userRole }}">
                                    <p class="mt-1 text-xs text-red-500">{{ __('messages.cannot_delete_self') }} (Proteção de Papel)</p>
                                @endif

                                <x-input-error class="mt-2" :messages="$errors->get('role')" />
                            </div>

                        </div>

                        <div class="flex items-center gap-4 mt-6">
                            <x-primary-button>{{ __('messages.save') }}</x-primary-button>
                            <a href="{{ route('users.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-300 dark:bg-gray-700 border border-transparent rounded-md font-semibold text-xs text-gray-800 dark:text-gray-300 uppercase tracking-widest hover:bg-gray-400 dark:hover:bg-gray-600 transition ease-in-out duration-150">{{ __('messages.cancel') }}</a>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
