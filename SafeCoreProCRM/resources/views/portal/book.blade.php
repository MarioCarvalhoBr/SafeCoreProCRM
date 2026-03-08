<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('messages.book_appointment') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    <form method="POST" action="{{ route('portal.store_appointment') }}" class="space-y-6">
                        @csrf

                        <!-- Escolher Médico -->
                        <div>
                            <x-input-label for="doctor_id" :value="__('messages.choose_doctor')" />
                            <select id="doctor_id" name="doctor_id" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 rounded-md shadow-sm" required>
                                <option value="">-- {{ __('messages.choose_doctor') }} --</option>
                                @foreach($doctors as $doctor)
                                    <option value="{{ $doctor->id }}">{{ $doctor->name }} ({{ $doctor->specialty ?? 'Geral' }})</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Data e Hora -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <x-input-label for="appointment_date" :value="__('messages.choose_date')" />
                                <x-text-input id="appointment_date" name="appointment_date" type="date" class="mt-1 block w-full dark:bg-gray-900 dark:border-gray-700" required />
                            </div>
                            <div>
                                <x-input-label for="appointment_time" :value="__('messages.choose_time')" />
                                <x-text-input id="appointment_time" name="appointment_time" type="time" class="mt-1 block w-full dark:bg-gray-900 dark:border-gray-700" required />
                            </div>
                        </div>

                        <!-- Motivo / Notas -->
                        <div>
                            <x-input-label for="notes" :value="__('messages.reason')" />
                            <textarea id="notes" name="notes" rows="3" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 rounded-md shadow-sm" placeholder="Descreva brevemente o motivo da consulta..."></textarea>
                        </div>

                        <div class="flex items-center gap-4 mt-6">
                            <x-primary-button>{{ __('messages.save') }}</x-primary-button>
                            <a href="{{ route('portal.dashboard') }}" class="text-sm text-gray-600 dark:text-gray-400 hover:underline">{{ __('messages.cancel') }}</a>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
