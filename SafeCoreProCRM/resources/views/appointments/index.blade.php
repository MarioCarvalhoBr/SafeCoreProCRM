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

                        <form method="GET" action="{{ route('appointments.index') }}" class="mb-6 flex gap-2">
                            <input type="hidden" name="sort_by" value="{{ request('sort_by') }}">
                            <input type="hidden" name="sort_dir" value="{{ request('sort_dir') }}">
                            <x-text-input name="search" value="{{ request('search') }}" placeholder="{{ __('messages.search') }}" class="w-full md:w-1/3 dark:bg-gray-900" />
                            <x-primary-button type="submit">{{ __('messages.search_button') }}</x-primary-button>
                            @if(request('search'))
                            <a href="{{ route('appointments.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-300 dark:bg-gray-700 text-gray-800 dark:text-gray-200 rounded-md hover:bg-gray-400 dark:hover:bg-gray-600 transition">{{ __('messages.clear') }}</a>
                            @endif
                        </form>
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="border-b border-gray-200 dark:border-gray-700">
                                    <th class="py-3 px-4 uppercase font-semibold text-sm">
                                        <x-sortable-header column="appointment_date" :label="__('messages.date') . ' & ' . __('messages.time')" />
                                    </th>
                                    <th class="py-3 px-4 uppercase font-semibold text-sm">{{ __('messages.patient') }}</th>
                                    <th class="py-3 px-4 uppercase font-semibold text-sm">{{ __('messages.doctor') }}</th>
                                    <th class="py-3 px-4 uppercase font-semibold text-sm">
                                        <x-sortable-header column="status" :label="__('messages.status')" />
                                    </th>
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
                                        <div class="flex justify-center items-center">

                                            <!-- Componente Dropdown Nativo do Breeze -->
                                            <x-dropdown align="right" width="48">
                                                <x-slot name="trigger">
                                                    <button class="inline-flex items-center px-3 py-2 border border-gray-300 dark:border-gray-600 text-sm leading-4 font-medium rounded-md text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 hover:text-gray-900 dark:hover:text-gray-100 focus:outline-none transition ease-in-out duration-150 shadow-sm">
                                                        {{ __('messages.options') }}
                                                        <div class="ms-1">
                                                            <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                                            </svg>
                                                        </div>
                                                    </button>
                                                </x-slot>

                                                <x-slot name="content">
                                                    <!-- Editar -->
                                                    <x-dropdown-link :href="route('appointments.edit', $appointment->id)" class="text-blue-600 dark:text-blue-400">
                                                        {{ __('messages.edit') }}
                                                    </x-dropdown-link>

                                                    <!-- Financeiro (Abre Modal) -->
                                                    <button type="button" x-data="" x-on:click.prevent="$dispatch('open-modal', 'financial-{{ $appointment->id }}')" class="block w-full px-4 py-2 text-start text-sm leading-5 text-emerald-600 dark:text-emerald-400 hover:bg-gray-100 dark:hover:bg-gray-800 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-800 transition duration-150 ease-in-out">
                                                        {{ __('messages.financial') }}
                                                    </button>

                                                    <!-- Atestado -->
                                                    <x-dropdown-link :href="route('appointments.certificate', $appointment->id)" target="_blank" class="text-orange-600 dark:text-orange-400">
                                                        {{ __('messages.medical_certificate') }}
                                                    </x-dropdown-link>

                                                    <!-- Receita PDF -->
                                                    <x-dropdown-link :href="route('appointments.prescription', $appointment->id)" target="_blank" class="text-green-600 dark:text-green-400">
                                                        {{ __('messages.prescription') ?? 'Receita PDF' }}
                                                    </x-dropdown-link>

                                                    <div class="border-t border-gray-200 dark:border-gray-600"></div>

                                                    <!-- Excluir (Abre Modal) -->
                                                    <button type="button" x-data="" x-on:click.prevent="$dispatch('open-modal', 'confirm-deletion-{{ $appointment->id }}')" class="block w-full px-4 py-2 text-start text-sm leading-5 text-red-600 dark:text-red-400 hover:bg-gray-100 dark:hover:bg-gray-800 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-800 transition duration-150 ease-in-out">
                                                        {{ __('messages.delete') }}
                                                    </button>
                                                </x-slot>
                                            </x-dropdown>

                                            <!-- Modais (Devem ficar fora do dropdown para o z-index não quebrar) -->
                                            <x-modal name="financial-{{ $appointment->id }}" focusable>
                                                <form method="post" action="{{ route('payments.update', $appointment->id) }}" class="p-6 text-left whitespace-normal">
                                                    @csrf
                                                    @method('put')
                                                    <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100 flex items-center mb-4">
                                                        <svg class="w-5 h-5 mr-2 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                                        {{ __('messages.financial') }} - {{ $appointment->patient->name }}
                                                    </h2>
                                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                                        <div>
                                                            <x-input-label for="amount_{{ $appointment->id }}" :value="__('messages.amount')" />
                                                            <x-text-input id="amount_{{ $appointment->id }}" name="amount" type="number" step="0.01" min="0" class="mt-1 block w-full dark:bg-gray-900 dark:border-gray-700" :value="old('amount', $appointment->payment->amount ?? '0.00')" required />
                                                        </div>
                                                        <div>
                                                            <x-input-label for="status_{{ $appointment->id }}" :value="__('messages.status')" />
                                                            <select id="status_{{ $appointment->id }}" name="status" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 rounded-md shadow-sm" required>
                                                                <option value="pending" {{ ($appointment->payment->status ?? '') === 'pending' ? 'selected' : '' }}>{{ __('messages.pending') }}</option>
                                                                <option value="paid" {{ ($appointment->payment->status ?? '') === 'paid' ? 'selected' : '' }}>{{ __('messages.paid') }}</option>
                                                            </select>
                                                        </div>
                                                        <div class="md:col-span-2">
                                                            <x-input-label for="payment_method_{{ $appointment->id }}" :value="__('messages.payment_method')" />
                                                            <select id="payment_method_{{ $appointment->id }}" name="payment_method" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 rounded-md shadow-sm">
                                                                <option value="">--</option>
                                                                <option value="cash" {{ ($appointment->payment->payment_method ?? '') === 'cash' ? 'selected' : '' }}>{{ __('messages.cash') }}</option>
                                                                <option value="credit_card" {{ ($appointment->payment->payment_method ?? '') === 'credit_card' ? 'selected' : '' }}>{{ __('messages.credit_card') }}</option>
                                                                <option value="bank_transfer" {{ ($appointment->payment->payment_method ?? '') === 'bank_transfer' ? 'selected' : '' }}>{{ __('messages.bank_transfer') }}</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="mt-6 flex justify-between items-center">
                                                        <div>
                                                            @if($appointment->payment && $appointment->payment->status === 'paid')
                                                            <a href="{{ route('payments.receipt', $appointment->id) }}" target="_blank" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 transition">
                                                                {{ __('messages.generate_receipt') }}
                                                            </a>
                                                            @endif
                                                        </div>
                                                        <div class="flex gap-3">
                                                            <button type="button" x-on:click="$dispatch('close')" class="inline-flex items-center px-4 py-2 bg-gray-300 dark:bg-gray-700 rounded-md font-semibold text-xs text-gray-800 dark:text-gray-300 uppercase tracking-widest hover:bg-gray-400 transition">{{ __('messages.cancel') }}</button>
                                                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-emerald-600 rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-emerald-700 transition">{{ __('messages.save') }}</button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </x-modal>

                                            <x-modal name="confirm-deletion-{{ $appointment->id }}" focusable>
                                                <form method="post" action="{{ route('appointments.destroy', $appointment->id) }}" class="p-6 text-left">
                                                    @csrf
                                                    @method('delete')
                                                    <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">{{ __('messages.confirm_delete') }}</h2>
                                                    <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">Tem a certeza de que deseja eliminar este agendamento?</p>
                                                    <div class="mt-6 flex justify-end">
                                                        <button type="button" x-on:click="$dispatch('close')" class="inline-flex items-center px-4 py-2 bg-gray-300 dark:bg-gray-700 rounded-md font-semibold text-xs text-gray-800 dark:text-gray-300 uppercase tracking-widest hover:bg-gray-400 transition">{{ __('messages.cancel') }}</button>
                                                        <button type="submit" class="ms-3 inline-flex items-center px-4 py-2 bg-red-600 rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 transition">{{ __('messages.delete') }}</button>
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
