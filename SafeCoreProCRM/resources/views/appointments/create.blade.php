<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('messages.add_appointment') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    <form method="POST" action="{{ route('appointments.store') }}" class="space-y-6">
                        @csrf

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                            <div>
                                <x-input-label for="patient_id" :value="__('messages.patient')" />
                                <select id="patient_id" name="patient_id" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm" required autofocus>
                                    <option value="">-- {{ __('messages.patient') }} --</option>
                                    @foreach($patients as $patient)
                                        <option value="{{ $patient->id }}" {{ old('patient_id') == $patient->id ? 'selected' : '' }}>
                                            {{ $patient->name }} ({{ $patient->document_id ?? 'Sem doc' }})
                                        </option>
                                    @endforeach
                                </select>
                                <x-input-error class="mt-2" :messages="$errors->get('patient_id')" />
                            </div>

                            <div>
                                <x-input-label for="user_id" :value="__('messages.doctor')" />
                                <select id="user_id" name="user_id" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm" required>
                                    <option value="">-- {{ __('messages.doctor') }} --</option>
                                    @foreach($doctors as $doctor)
                                        <option value="{{ $doctor->id }}" {{ old('user_id') == $doctor->id ? 'selected' : '' }}>
                                            Dr(a). {{ $doctor->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <x-input-error class="mt-2" :messages="$errors->get('user_id')" />
                            </div>

                            <div>
                                <x-input-label for="appointment_date" :value="__('messages.date')" />
                                <x-text-input id="appointment_date" name="appointment_date" type="date" class="mt-1 block w-full dark:bg-gray-900 dark:border-gray-700 [&::-webkit-calendar-picker-indicator]:dark:invert" :value="old('appointment_date')" required />
                                <x-input-error class="mt-2" :messages="$errors->get('appointment_date')" />
                            </div>

                            <div>
                                <x-input-label for="appointment_time" :value="__('messages.time')" />
                                <x-text-input id="appointment_time" name="appointment_time" type="time" class="mt-1 block w-full dark:bg-gray-900 dark:border-gray-700 [&::-webkit-calendar-picker-indicator]:dark:invert" :value="old('appointment_time')" required />
                                <x-input-error class="mt-2" :messages="$errors->get('appointment_time')" />
                            </div>

                            <div class="md:col-span-2">
                                <x-input-label for="notes" :value="__('messages.notes')" />
                                <textarea id="notes" name="notes" rows="3" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">{{ old('notes') }}</textarea>
                                <x-input-error class="mt-2" :messages="$errors->get('notes')" />
                            </div>

                        </div>

                        <div class="flex items-center gap-4 mt-6">
                            <x-primary-button>
                                {{ __('messages.save') }}
                            </x-primary-button>

                            <a href="{{ route('appointments.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-300 dark:bg-gray-700 border border-transparent rounded-md font-semibold text-xs text-gray-800 dark:text-gray-300 uppercase tracking-widest hover:bg-gray-400 dark:hover:bg-gray-600 transition ease-in-out duration-150">
                                {{ __('messages.cancel') }}
                            </a>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
