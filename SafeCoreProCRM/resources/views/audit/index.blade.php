<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('messages.audit_logs') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    <div class="overflow-x-auto">
                        <form method="GET" action="{{ route('audit.index') }}" class="mb-6 flex gap-2">
                            <input type="hidden" name="sort_by" value="{{ request('sort_by') }}">
                            <input type="hidden" name="sort_dir" value="{{ request('sort_dir') }}">
                            <x-text-input name="search" value="{{ request('search') }}" placeholder="{{ __('messages.search') }}" class="w-full md:w-1/3 dark:bg-gray-900" />
                            <x-primary-button type="submit">{{ __('messages.search_button') }}</x-primary-button>
                            @if(request('search'))
                            <a href="{{ route('audit.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-300 dark:bg-gray-700 text-gray-800 dark:text-gray-200 rounded-md hover:bg-gray-400 dark:hover:bg-gray-600 transition">{{ __('messages.clear') }}</a>
                            @endif
                        </form>
                        <table class="w-full text-left border-collapse text-sm">
                            <thead>
                                <tr class="border-b border-gray-200 dark:border-gray-700">
                                    <th class="py-3 px-4 uppercase font-semibold text-xs">
                                        <x-sortable-header column="created_at" :label="__('messages.date')" />
                                    </th>
                                    <th class="py-3 px-4 uppercase font-semibold text-xs">{{ __('messages.user') }}</th>
                                    <th class="py-3 px-4 uppercase font-semibold text-xs">
                                        <x-sortable-header column="event" :label="__('messages.action')" />
                                    </th>
                                    <th class="py-3 px-4 uppercase font-semibold text-xs">
                                        <x-sortable-header column="subject_type" :label="__('messages.module')" />
                                    </th>
                                    <th class="py-3 px-4 uppercase font-semibold text-xs">{{ __('messages.details') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($logs as $log)
                                <tr class="border-b border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                                    <td class="py-3 px-4 whitespace-nowrap">
                                        {{ $log->created_at->format('d/m/Y H:i:s') }}
                                    </td>

                                    <td class="py-3 px-4 font-medium text-blue-600 dark:text-blue-400">
                                        {{ $log->causer ? $log->causer->name : 'Sistema / Auto' }}
                                    </td>

                                    <td class="py-3 px-4">
                                        @if($log->event === 'created')
                                        <span class="px-2 py-1 bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200 text-xs rounded-full">{{ __('messages.created') }}</span>
                                        @elseif($log->event === 'updated')
                                        <span class="px-2 py-1 bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200 text-xs rounded-full">{{ __('messages.updated') }}</span>
                                        @elseif($log->event === 'deleted')
                                        <span class="px-2 py-1 bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200 text-xs rounded-full">{{ __('messages.deleted') }}</span>
                                        @endif
                                    </td>

                                    <td class="py-3 px-4 text-gray-500 dark:text-gray-400">
                                        {{ class_basename($log->subject_type) }} #{{ $log->subject_id }}
                                    </td>

                                    <td class="py-3 px-4">
                                        <pre class="text-xs bg-gray-100 dark:bg-gray-900 p-2 rounded overflow-x-auto max-w-xs">{{ json_encode($log->properties, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="py-6 px-4 text-center text-gray-500 dark:text-gray-400">
                                        {{ __('messages.no_logs_found') }}
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        {{ $logs->links() }}
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
