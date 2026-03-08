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

                    <form method="GET" action="{{ route('patients.index') }}" class="mb-6 flex gap-2">
                        <input type="hidden" name="sort_by" value="{{ request('sort_by') }}">
                        <input type="hidden" name="sort_dir" value="{{ request('sort_dir') }}">

                        <x-text-input name="search" value="{{ request('search') }}" placeholder="{{ __('messages.search') }}" class="w-full md:w-1/3 dark:bg-gray-900" />

                        <x-primary-button type="submit">
                            {{ __('messages.search_button') }}
                        </x-primary-button>

                        @if(request('search'))
                            <a href="{{ route('patients.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-300 dark:bg-gray-700 text-gray-800 dark:text-gray-200 rounded-md hover:bg-gray-400 dark:hover:bg-gray-600 transition">
                                {{ __('messages.clear') }}
                            </a>
                        @endif
                    </form>

                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="border-b border-gray-200 dark:border-gray-700">
                                    <th class="py-3 px-4 uppercase font-semibold text-sm">
                                        <x-sortable-header column="name" :label="__('messages.name')" />
                                    </th>
                                    <th class="py-3 px-4 uppercase font-semibold text-sm">
                                        <x-sortable-header column="document_id" :label="__('messages.document_id')" />
                                    </th>
                                    <th class="py-3 px-4 uppercase font-semibold text-sm">
                                        <x-sortable-header column="phone" :label="__('messages.phone')" />
                                    </th>
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
                                    <td class="py-3 px-4 text-center">
                                        <div class="flex justify-center items-center space-x-3">


                                            <a href="{{ route('patients.show', $patient->id) }}" class="inline-flex items-center px-3 py-1.5 bg-blue-400 dark:bg-blue-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 dark:hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                                                {{ __('messages.open') }}
                                            </a>

                                            <a href="{{ route('patients.edit', $patient->id) }}" class="inline-flex items-center px-3 py-1.5 bg-blue-600 dark:bg-blue-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 dark:hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                                                {{ __('messages.edit') }}
                                            </a>

                                            <button x-data="" x-on:click.prevent="$dispatch('open-modal', 'confirm-deletion-{{ $patient->id }}')" class="inline-flex items-center px-3 py-1.5 bg-red-600 dark:bg-red-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 dark:hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                                                {{ __('messages.delete') }}
                                            </button>

                                            <x-modal name="confirm-deletion-{{ $patient->id }}" focusable>
                                                <form method="post" action="{{ route('patients.destroy', $patient->id) }}" class="p-6 text-left">
                                                    @csrf
                                                    @method('delete')

                                                    <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                                                        {{ __('messages.confirm_delete') }}: <span class="text-red-600 dark:text-red-400">{{ $patient->name }}</span>
                                                    </h2>

                                                    <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                                                        {{ __('messages.delete_patient_text') }}
                                                    </p>

                                                    <div class="mt-6 flex justify-end">
                                                        <button type="button" x-on:click="$dispatch('close')" class="inline-flex items-center px-4 py-2 bg-gray-300 dark:bg-gray-700 border border-transparent rounded-md font-semibold text-xs text-gray-800 dark:text-gray-300 uppercase tracking-widest hover:bg-gray-400 dark:hover:bg-gray-600 transition ease-in-out duration-150">
                                                            {{ __('messages.cancel') }}
                                                        </button>

                                                        <button type="submit" class="ms-3 inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                                                            {{ __('messages.delete') }}
                                                        </button>
                                                    </div>
                                                </form>
                                            </x-modal>

                                        </div>
                                    </td>
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
