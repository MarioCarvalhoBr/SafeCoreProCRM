<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('messages.welcome_portal') }}, {{ Auth::user()->name }}!
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative">
                    {{ session('success') }}
                </div>
            @endif

            <div class="flex justify-end">
                <a href="{{ route('portal.book') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                    {{ __('messages.new_appointment') }}
                </a>
            </div>

            <!-- Lista de Consultas do Paciente -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">{{ __('messages.my_appointments') }}</h3>

                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900">
                                    <th class="py-3 px-4 font-semibold text-gray-600 dark:text-gray-400 text-sm uppercase">{{ __('messages.date') }} & {{ __('messages.time') }}</th>
                                    <th class="py-3 px-4 font-semibold text-gray-600 dark:text-gray-400 text-sm uppercase">{{ __('messages.doctor') }}</th>
                                    <th class="py-3 px-4 font-semibold text-gray-600 dark:text-gray-400 text-sm uppercase">{{ __('messages.status') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($appointments as $appointment)
                                    <tr class="border-b border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                                        <td class="py-3 px-4">
                                            <span class="font-bold text-gray-900 dark:text-white">{{ \Carbon\Carbon::parse($appointment->appointment_date)->format('d/m/Y') }}</span>
                                            <span class="text-gray-500 dark:text-gray-400 ml-2">{{ \Carbon\Carbon::parse($appointment->appointment_time)->format('H:i') }}</span>
                                        </td>
                                        <td class="py-3 px-4 text-gray-700 dark:text-gray-300">Dr(a). {{ $appointment->doctor->name ?? 'N/A' }}</td>
                                        <td class="py-3 px-4">
                                            @if($appointment->status === 'scheduled')
                                                <span class="px-2 py-1 bg-blue-100 text-blue-800 text-xs rounded-full">{{ __('messages.scheduled') }}</span>
                                            @elseif($appointment->status === 'completed')
                                                <span class="px-2 py-1 bg-green-100 text-green-800 text-xs rounded-full">{{ __('messages.completed') }}</span>
                                            @else
                                                <span class="px-2 py-1 bg-red-100 text-red-800 text-xs rounded-full">{{ __('messages.canceled') }}</span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="py-6 text-center text-gray-500 dark:text-gray-400">Sem consultas marcadas.</td>
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
