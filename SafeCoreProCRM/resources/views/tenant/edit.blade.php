<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Clinic Settings
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    @if (session('status') === 'settings-updated')
                        <div x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 3000)" class="mb-4 bg-green-100 dark:bg-green-900 border border-green-400 dark:border-green-700 text-green-700 dark:text-green-300 px-4 py-3 rounded relative">
                            Settings saved successfully!
                        </div>
                    @endif

                    <form method="POST" action="{{ route('tenant.update') }}" enctype="multipart/form-data" class="space-y-6">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                            <div>
                                <x-input-label for="name" value="Clinic Name" />
                                <x-text-input id="name" name="name" type="text" class="mt-1 block w-full dark:bg-gray-900 dark:border-gray-700" :value="old('name', $tenant->name)" required autofocus />
                                <x-input-error class="mt-2" :messages="$errors->get('name')" />
                            </div>

                            <div>
                                <x-input-label for="phone" value="Phone Number" />
                                <x-text-input id="phone" name="phone" type="text" class="mt-1 block w-full dark:bg-gray-900 dark:border-gray-700" :value="old('phone', $tenant->phone)" />
                                <x-input-error class="mt-2" :messages="$errors->get('phone')" />
                            </div>

                            <div class="md:col-span-2">
                                <x-input-label for="email" value="Public Email" />
                                <x-text-input id="email" name="email" type="email" class="mt-1 block w-full dark:bg-gray-900 dark:border-gray-700" :value="old('email', $tenant->email)" />
                                <x-input-error class="mt-2" :messages="$errors->get('email')" />
                            </div>

                            <div>
                                <x-input-label for="logo" value="Clinic Logo (PNG, JPG, WEBP)" />
                                <input id="logo" name="logo" type="file" class="mt-1 block w-full text-sm text-gray-500 dark:text-gray-400 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 dark:file:bg-gray-700 dark:file:text-gray-300 hover:file:bg-blue-100 dark:hover:file:bg-gray-600 transition" />
                                <x-input-error class="mt-2" :messages="$errors->get('logo')" />

                                @if($tenant->logo_path)
                                    <div class="mt-4">
                                        <p class="text-sm text-gray-500 dark:text-gray-400 mb-2">Current Logo:</p>
                                        <img src="{{ asset('storage/' . $tenant->logo_path) }}" alt="Logo" class="h-16 rounded shadow">
                                    </div>
                                @endif
                            </div>

                            <div>
                                <x-input-label for="banner" value="Clinic Banner (Optional)" />
                                <input id="banner" name="banner" type="file" class="mt-1 block w-full text-sm text-gray-500 dark:text-gray-400 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 dark:file:bg-gray-700 dark:file:text-gray-300 hover:file:bg-blue-100 dark:hover:file:bg-gray-600 transition" />
                                <x-input-error class="mt-2" :messages="$errors->get('banner')" />

                                @if($tenant->banner_path)
                                    <div class="mt-4">
                                        <p class="text-sm text-gray-500 dark:text-gray-400 mb-2">Current Banner:</p>
                                        <img src="{{ asset('storage/' . $tenant->banner_path) }}" alt="Banner" class="h-16 w-full object-cover rounded shadow">
                                    </div>
                                @endif
                            </div>

                        </div>

                        <div class="flex items-center gap-4 mt-6">
                            <x-primary-button>{{ __('Save Settings') }}</x-primary-button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
