<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('messages.backups') }}
            </h2>

            <form action="{{ route('backups.create') }}" method="POST">
                @csrf
                <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded transition inline-flex items-center">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path>
                    </svg>
                    {{ __('messages.generate_backup') }}
                </button>
            </form>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if (session('success'))
            <div class="mb-4 bg-green-100 dark:bg-green-900 border border-green-400 text-green-700 dark:text-green-300 px-4 py-3 rounded">
                {{ session('success') }}
            </div>
            @endif
            @if ($errors->any())
            <div class="mb-4 bg-red-100 dark:bg-red-900 border border-red-400 text-red-700 dark:text-red-300 px-4 py-3 rounded">
                {{ $errors->first() }}
            </div>
            @endif

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse text-sm">
                            <thead>
                                <tr class="border-b border-gray-200 dark:border-gray-700">
                                    <th class="py-3 px-4 uppercase font-semibold">{{ __('messages.file_name') }}</th>
                                    <th class="py-3 px-4 uppercase font-semibold">{{ __('messages.file_size') }}</th>
                                    <th class="py-3 px-4 uppercase font-semibold">{{ __('messages.date') }}</th>
                                    <th class="py-3 px-4 uppercase font-semibold text-center">{{ __('messages.actions') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($backups as $backup)
                                <tr class="border-b border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700">
                                    <td class="py-3 px-4 font-mono text-indigo-600 dark:text-indigo-400">
                                        {{ $backup['file_name'] }}
                                    </td>
                                    <td class="py-3 px-4">{{ $backup['file_size'] }}</td>
                                    <td class="py-3 px-4">{{ $backup['last_modified'] }}</td>

                                    <td class="py-3 px-4 text-center">
                                            @php
                                                $modalId = \Illuminate\Support\Str::slug($backup['file_name']);
                                            @endphp

                                            <div class="flex justify-center items-center space-x-3">

                                                <a href="{{ route('backups.download', $backup['file_name']) }}" class="inline-flex items-center px-3 py-1.5 bg-blue-600 dark:bg-blue-500 rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 dark:hover:bg-blue-600 transition">
                                                    {{ __('messages.download') }}
                                                </a>

                                                <button x-data="" x-on:click.prevent="$dispatch('open-modal', 'confirm-restore-{{ $modalId }}')" class="inline-flex items-center px-3 py-1.5 bg-green-600 dark:bg-green-500 rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 dark:hover:bg-green-600 transition">
                                                    {{ __('messages.restore') }}
                                                </button>

                                                <button x-data="" x-on:click.prevent="$dispatch('open-modal', 'confirm-deletion-{{ $modalId }}')" class="inline-flex items-center px-3 py-1.5 bg-red-600 dark:bg-red-500 rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 dark:hover:bg-red-600 transition">
                                                    {{ __('messages.delete') }}
                                                </button>

                                                <x-modal name="confirm-restore-{{ $modalId }}" focusable>
                                                    <form method="post" action="{{ route('backups.restore', $backup['file_name']) }}" class="p-6 text-left">
                                                        @csrf
                                                        <div class="flex items-center justify-center w-12 h-12 rounded-full bg-red-100 mb-4">
                                                            <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                                                        </div>
                                                        <h2 class="text-lg font-bold text-red-600 dark:text-red-400">Aviso de Sobrescrita de Dados</h2>
                                                        <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
                                                            {{ __('messages.confirm_restore') }} <strong>({{ $backup['file_name'] }})</strong>
                                                        </p>
                                                        <div class="mt-6 flex justify-end">
                                                            <button type="button" x-on:click="$dispatch('close')" class="inline-flex items-center px-4 py-2 bg-gray-300 dark:bg-gray-700 rounded-md font-semibold text-xs text-gray-800 dark:text-gray-300 uppercase tracking-widest hover:bg-gray-400 transition">{{ __('messages.cancel') }}</button>
                                                            <button type="submit" class="ms-3 inline-flex items-center px-4 py-2 bg-green-600 rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 transition">{{ __('messages.restore') }}</button>
                                                        </div>
                                                    </form>
                                                </x-modal>

                                                <x-modal name="confirm-deletion-{{ $modalId }}" focusable>
                                                    <form method="post" action="{{ route('backups.destroy', $backup['file_name']) }}" class="p-6 text-left">
                                                        @csrf
                                                        @method('delete')
                                                        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">{{ __('messages.confirm_delete') ?? 'Confirmar Exclusão' }}</h2>
                                                        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">Tem certeza de que deseja excluir o arquivo de backup <strong>{{ $backup['file_name'] }}</strong>? Esta ação não pode ser desfeita.</p>
                                                        <div class="mt-6 flex justify-end">
                                                            <button type="button" x-on:click="$dispatch('close')" class="inline-flex items-center px-4 py-2 bg-gray-300 dark:bg-gray-700 rounded-md font-semibold text-xs text-gray-800 dark:text-gray-300 uppercase tracking-widest hover:bg-gray-400 transition">{{ __('messages.cancel') }}</button>
                                                            <button type="submit" class="ms-3 inline-flex items-center px-4 py-2 bg-red-600 rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 transition">{{ __('messages.delete') }}</button>
                                                        </div>
                                                    </form>
                                                </x-modal>

                                            </div>
                                        </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="py-6 px-4 text-center text-gray-500">
                                        {{ __('messages.no_backups_found') }}
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
