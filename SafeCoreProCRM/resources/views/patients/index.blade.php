<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('messages.patients') }}
            </h2>
            <a href="{{ route('patients.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded transition duration-150 ease-in-out">
                {{ __('messages.add_patient') }}
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if (session('success'))
                <div x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 4000)" class="mb-4 bg-green-100 dark:bg-green-900 border border-green-400 dark:border-green-700 text-green-700 dark:text-green-300 px-4 py-3 rounded relative">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="border-b border-gray-200 dark:border-gray-700">
                                    <th class="py-3 px-4 uppercase font-semibold text-sm">{{ __('messages.name') }}</th>
                                    <th class="py-3 px-4 uppercase font-semibold text-sm">{{ __('messages.document_id') }}</th>
                                    <th class="py-3 px-4 uppercase font-semibold text-sm">{{ __('messages.phone') }}</th>
                                    <th class="py-3 px-4 uppercase font-semibold text-sm text-center">{{ __('messages.actions') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($patients as $patient)
                                    <tr class="border-b border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700 transition duration-150">
                                        <td class="py-3 px-4">{{ $patient->name }}</td>
                                        <td class="py-3 px-4">{{ $patient->document_id ?? '-' }}</td>
                                        <td class="py-3 px-4">{{ $patient->phone ?? '-' }}</td>
                                        <td class="py-3 px-4 text-center">
                                            <a href="#" class="text-blue-600 dark:text-blue-400 hover:underline">
                                                {{ __('messages.edit_patient') }}
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="py-6 px-4 text-center text-gray-500 dark:text-gray-400">
                                            {{ __('messages.no_patients_found') }}
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        {{ $patients->links() }}
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
