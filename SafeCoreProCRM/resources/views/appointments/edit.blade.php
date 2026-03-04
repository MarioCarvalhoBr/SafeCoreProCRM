<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('messages.edit_appointment') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    <form method="POST" action="{{ route('appointments.update', $appointment->id) }}" class="space-y-6">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                            <div>
                                <x-input-label for="patient_id" :value="__('messages.patient')" />
                                <select id="patient_id" name="patient_id" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 rounded-md shadow-sm" required>
                                    @foreach($patients as $patient)
                                        <option value="{{ $patient->id }}" {{ old('patient_id', $appointment->patient_id) == $patient->id ? 'selected' : '' }}>
                                            {{ $patient->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <x-input-error class="mt-2" :messages="$errors->get('patient_id')" />
                            </div>

                            <div>
                                <x-input-label for="user_id" :value="__('messages.doctor')" />
                                <select id="user_id" name="user_id" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 rounded-md shadow-sm" required>
                                    @foreach($doctors as $doctor)
                                        <option value="{{ $doctor->id }}" {{ old('user_id', $appointment->user_id) == $doctor->id ? 'selected' : '' }}>
                                            Dr(a). {{ $doctor->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <x-input-error class="mt-2" :messages="$errors->get('user_id')" />
                            </div>

                            <div>
                                <x-input-label for="appointment_date" :value="__('messages.date')" />
                                <x-text-input id="appointment_date" name="appointment_date" type="date" class="mt-1 block w-full dark:bg-gray-900 dark:border-gray-700 [&::-webkit-calendar-picker-indicator]:dark:invert" :value="old('appointment_date', $appointment->appointment_date)" required />
                                <x-input-error class="mt-2" :messages="$errors->get('appointment_date')" />
                            </div>

                            <div>
                                <x-input-label for="appointment_time" :value="__('messages.time')" />
                                <x-text-input id="appointment_time" name="appointment_time" type="time" class="mt-1 block w-full dark:bg-gray-900 dark:border-gray-700 [&::-webkit-calendar-picker-indicator]:dark:invert" :value="old('appointment_time', \Carbon\Carbon::parse($appointment->appointment_time)->format('H:i'))" required />
                                <x-input-error class="mt-2" :messages="$errors->get('appointment_time')" />
                            </div>

                            <div>
                                <x-input-label for="status" :value="__('messages.status')" />
                                <select id="status" name="status" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 rounded-md shadow-sm" required>
                                    <option value="scheduled" {{ old('status', $appointment->status) === 'scheduled' ? 'selected' : '' }}>{{ __('messages.scheduled') }}</option>
                                    <option value="completed" {{ old('status', $appointment->status) === 'completed' ? 'selected' : '' }}>{{ __('messages.completed') }}</option>
                                    <option value="canceled" {{ old('status', $appointment->status) === 'canceled' ? 'selected' : '' }}>{{ __('messages.canceled') }}</option>
                                </select>
                                <x-input-error class="mt-2" :messages="$errors->get('status')" />
                            </div>

                            <div class="md:col-span-2">
                                <x-input-label for="notes" :value="__('messages.notes')" />
                                <textarea id="notes" name="notes" rows="3" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 rounded-md shadow-sm">{{ old('notes', $appointment->notes) }}</textarea>
                                <x-input-error class="mt-2" :messages="$errors->get('notes')" />
                            </div>

                        </div>

                        <div class="flex items-center gap-4 mt-6">
                            <x-primary-button>{{ __('messages.save') }}</x-primary-button>
                            <a href="{{ route('appointments.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-300 dark:bg-gray-700 border border-transparent rounded-md font-semibold text-xs text-gray-800 dark:text-gray-300 uppercase tracking-widest hover:bg-gray-400 dark:hover:bg-gray-600 transition ease-in-out duration-150">{{ __('messages.cancel') }}</a>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
