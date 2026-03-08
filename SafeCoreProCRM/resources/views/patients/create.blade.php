<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('messages.add_patient') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    <form method="POST" action="{{ route('patients.store') }}" class="space-y-6">
                        @csrf

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                            <div>
                                <x-input-label for="name" :value="__('messages.name')" />
                                <x-text-input id="name" name="name" type="text" class="mt-1 block w-full dark:bg-gray-900 dark:border-gray-700" :value="old('name')" required autofocus />
                                <x-input-error class="mt-2" :messages="$errors->get('name')" />
                            </div>

                            <div>
                                <x-input-label for="document_id" :value="__('messages.document_id')" />
                                <x-text-input id="document_id" name="document_id" type="text" class="mt-1 block w-full dark:bg-gray-900 dark:border-gray-700" :value="old('document_id')" />
                                <x-input-error class="mt-2" :messages="$errors->get('document_id')" />
                            </div>

                            <div>
                                <x-input-label for="email" :value="__('messages.email')" />
                                <x-text-input id="email" name="email" type="email" class="mt-1 block w-full dark:bg-gray-900 dark:border-gray-700" :value="old('email')" />
                                <x-input-error class="mt-2" :messages="$errors->get('email')" />
                            </div>

                            <div>
                                <x-input-label for="phone" :value="__('messages.phone')" />
                                <x-text-input id="phone" name="phone" type="text" class="mt-1 block w-full dark:bg-gray-900 dark:border-gray-700" :value="old('phone')" />
                                <x-input-error class="mt-2" :messages="$errors->get('phone')" />
                            </div>

                            <div>
                                <x-input-label for="birth_date" :value="__('messages.birth_date')" />
                                <x-text-input id="birth_date" name="birth_date" type="date" class="mt-1 block w-full dark:bg-gray-900 dark:border-gray-700 [&::-webkit-calendar-picker-indicator]:dark:invert" :value="old('birth_date')" />
                                <x-input-error class="mt-2" :messages="$errors->get('birth_date')" />
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                                <div>
                                    <x-input-label for="gender" :value="__('messages.gender')" />
                                    <select id="gender" name="gender" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 rounded-md shadow-sm">
                                        <option value="">--</option>
                                        <option value="M" {{ old('gender', $patient->gender ?? '') == 'M' ? 'selected' : '' }}>{{ __('messages.male') }}</option>
                                        <option value="F" {{ old('gender', $patient->gender ?? '') == 'F' ? 'selected' : '' }}>{{ __('messages.female') }}</option>
                                    </select>
                                </div>

                                <div>
                                    <x-input-label for="address" :value="__('messages.address')" />
                                    <x-text-input id="address" name="address" type="text" class="mt-1 block w-full" :value="old('address', $patient->address ?? '')" />
                                </div>
                            </div>

                        </div>

                        <div class="flex items-center gap-4 mt-6">
                            <x-primary-button>
                                {{ __('messages.save') }}
                            </x-primary-button>

                            <a href="{{ route('patients.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-300 dark:bg-gray-700 border border-transparent rounded-md font-semibold text-xs text-gray-800 dark:text-gray-300 uppercase tracking-widest hover:bg-gray-400 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                                {{ __('messages.cancel') }}
                            </a>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
