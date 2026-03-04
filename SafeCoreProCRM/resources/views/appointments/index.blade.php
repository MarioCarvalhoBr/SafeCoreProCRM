<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('messages.appointments') }}
            </h2>
            <a href="{{ route('appointments.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded transition duration-150 ease-in-out">
                {{ __('messages.add_appointment') }}
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
                                    <th class="py-3 px-4 uppercase font-semibold text-sm">{{ __('messages.date') }} & {{ __('messages.time') }}</th>
                                    <th class="py-3 px-4 uppercase font-semibold text-sm">{{ __('messages.patient') }}</th>
                                    <th class="py-3 px-4 uppercase font-semibold text-sm">{{ __('messages.doctor') }}</th>
                                    <th class="py-3 px-4 uppercase font-semibold text-sm">{{ __('messages.status') }}</th>
                                    <th class="py-3 px-4 uppercase font-semibold text-sm text-center">{{ __('messages.actions') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($appointments as $appointment)
                                <tr class="border-b border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700 transition duration-150">
                                    <td class="py-3 px-4 font-medium">
                                        {{ \Carbon\Carbon::parse($appointment->appointment_date)->format('d/m/Y') }}
                                        <span class="text-gray-500 dark:text-gray-400">às {{ \Carbon\Carbon::parse($appointment->appointment_time)->format('H:i') }}</span>
                                    </td>

                                    <td class="py-3 px-4">{{ $appointment->patient->name }}</td>
                                    <td class="py-3 px-4">{{ $appointment->doctor->name }}</td>

                                    <td class="py-3 px-4">
                                        @if($appointment->status === 'scheduled')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200">
                                            {{ __('messages.scheduled') }}
                                        </span>
                                        @elseif($appointment->status === 'completed')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
                                            {{ __('messages.completed') }}
                                        </span>
                                        @else
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200">
                                            {{ __('messages.canceled') }}
                                        </span>
                                        @endif
                                    </td>

                                    <td class="py-3 px-4 text-center">
                                    <td class="py-3 px-4 text-center">
                                        <div class="flex justify-center items-center space-x-3">

                                            <a href="{{ route('appointments.edit', $appointment->id) }}" class="inline-flex items-center px-3 py-1.5 bg-blue-600 dark:bg-blue-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 dark:hover:bg-blue-600 transition ease-in-out duration-150">
                                                {{ __('messages.edit') }}
                                            </a>

                                            <button x-data="" x-on:click.prevent="$dispatch('open-modal', 'confirm-deletion-{{ $appointment->id }}')" class="inline-flex items-center px-3 py-1.5 bg-red-600 dark:bg-red-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 dark:hover:bg-red-600 transition ease-in-out duration-150">
                                                {{ __('messages.delete') }}
                                            </button>

                                            <x-modal name="confirm-deletion-{{ $appointment->id }}" focusable>
                                                <form method="post" action="{{ route('appointments.destroy', $appointment->id) }}" class="p-6 text-left">
                                                    @csrf
                                                    @method('delete')

                                                    <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                                                        {{ __('messages.confirm_delete') }}
                                                    </h2>

                                                    <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                                                        Tem a certeza de que deseja eliminar este agendamento?
                                                    </p>

                                                    <div class="mt-6 flex justify-end">
                                                        <button type="button" x-on:click="$dispatch('close')" class="inline-flex items-center px-4 py-2 bg-gray-300 dark:bg-gray-700 border border-transparent rounded-md font-semibold text-xs text-gray-800 dark:text-gray-300 uppercase tracking-widest hover:bg-gray-400 dark:hover:bg-gray-600 transition ease-in-out duration-150">
                                                            {{ __('messages.cancel') }}
                                                        </button>

                                                        <button type="submit" class="ms-3 inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 transition ease-in-out duration-150">
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
                                    <td colspan="5" class="py-6 px-4 text-center text-gray-500 dark:text-gray-400">
                                        {{ __('messages.no_appointments_found') }}
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        {{ $appointments->links() }}
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
