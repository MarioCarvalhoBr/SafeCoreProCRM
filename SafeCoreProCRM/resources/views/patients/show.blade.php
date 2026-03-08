<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('messages.view_record') }}: {{ $patient->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @if (session('success'))
                <div class="bg-green-100 dark:bg-green-900 border border-green-400 text-green-700 dark:text-green-300 px-4 py-3 rounded">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Card Superior: Informações Básicas -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg border-l-4 border-blue-500">
                <div class="p-6 text-gray-900 dark:text-gray-100 grid grid-cols-1 md:grid-cols-4 gap-4">
                    <div>
                        <span class="block text-sm text-gray-500 dark:text-gray-400">{{ __('messages.email') }}</span>
                        <span class="font-bold">{{ $patient->email }}</span>
                    </div>
                    <div>
                        <span class="block text-sm text-gray-500 dark:text-gray-400">{{ __('messages.phone') }}</span>
                        <span class="font-bold">{{ $patient->phone }}</span>
                    </div>
                    <div>
                        <span class="block text-sm text-gray-500 dark:text-gray-400">{{ __('messages.document_id') }}</span>
                        <span class="font-bold">{{ $patient->document_id }}</span>
                    </div>
                    <div>
                        <span class="block text-sm text-gray-500 dark:text-gray-400">{{ __('messages.birth_date') }}</span>
                        <span class="font-bold">{{ \Carbon\Carbon::parse($patient->birth_date)->format('d/m/Y') }}</span>
                    </div>
                </div>
            </div>

            <!-- Card Inferior: Prontuário Médico Clínico -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
                        {{ __('messages.medical_record') }}
                    </h3>

                    <form method="POST" action="{{ route('medical_records.update', $patient->id) }}" class="space-y-6">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 gap-6">
                            <div class="md:w-1/4">
                                <x-input-label for="blood_type" :value="__('messages.blood_type')" />
                                <select id="blood_type" name="blood_type" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 rounded-md shadow-sm">
                                    <option value="">--</option>
                                    @foreach(['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-'] as $type)
                                        <option value="{{ $type }}" {{ old('blood_type', $patient->medicalRecord->blood_type ?? '') == $type ? 'selected' : '' }}>{{ $type }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <x-input-label for="allergies" :value="__('messages.allergies')" />
                                <textarea id="allergies" name="allergies" rows="2" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 rounded-md shadow-sm">{{ old('allergies', $patient->medicalRecord->allergies ?? '') }}</textarea>
                            </div>

                            <div>
                                <x-input-label for="current_medications" :value="__('messages.current_medications')" />
                                <textarea id="current_medications" name="current_medications" rows="2" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 rounded-md shadow-sm">{{ old('current_medications', $patient->medicalRecord->current_medications ?? '') }}</textarea>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <x-input-label for="family_history" :value="__('messages.family_history')" />
                                    <textarea id="family_history" name="family_history" rows="3" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 rounded-md shadow-sm">{{ old('family_history', $patient->medicalRecord->family_history ?? '') }}</textarea>
                                </div>
                                <div>
                                    <x-input-label for="past_surgeries" :value="__('messages.past_surgeries')" />
                                    <textarea id="past_surgeries" name="past_surgeries" rows="3" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 rounded-md shadow-sm">{{ old('past_surgeries', $patient->medicalRecord->past_surgeries ?? '') }}</textarea>
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center gap-4 mt-6">
                            <x-primary-button>{{ __('messages.save') }}</x-primary-button>
                            <a href="{{ route('patients.index') }}" class="text-sm text-gray-600 dark:text-gray-400 hover:underline">{{ __('messages.cancel') }}</a>
                        </div>
                    </form>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mt-6">
                <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        {{ __('messages.appointment_history') }}
                    </h3>

                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse text-sm">
                            <thead>
                                <tr class="border-b border-gray-200 dark:border-gray-700">
                                    <th class="py-3 px-4 uppercase font-semibold text-gray-600 dark:text-gray-400">{{ __('messages.date') }} & {{ __('messages.time') }}</th>
                                    <th class="py-3 px-4 uppercase font-semibold text-gray-600 dark:text-gray-400">{{ __('messages.doctor') }}</th>
                                    <th class="py-3 px-4 uppercase font-semibold text-gray-600 dark:text-gray-400">{{ __('messages.status') }}</th>
                                    <th class="py-3 px-4 uppercase font-semibold text-gray-600 dark:text-gray-400">{{ __('messages.notes') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($patient->appointments->sortByDesc('appointment_date') as $appointment)
                                    <tr class="border-b border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                                        <td class="py-3 px-4 whitespace-nowrap">
                                            <span class="font-medium text-gray-900 dark:text-white">
                                                {{ \Carbon\Carbon::parse($appointment->appointment_date)->format('d/m/Y') }}
                                            </span>
                                            <span class="text-gray-500 dark:text-gray-400 ml-2">
                                                {{ \Carbon\Carbon::parse($appointment->appointment_time)->format('H:i') }}
                                            </span>
                                        </td>

                                        <td class="py-3 px-4 text-gray-700 dark:text-gray-300">
                                            {{ $appointment->doctor->name ?? 'N/A' }}
                                        </td>

                                        <td class="py-3 px-4">
                                            @if($appointment->status === 'scheduled')
                                                <span class="px-2 py-1 bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200 text-xs rounded-full">{{ __('messages.scheduled') }}</span>
                                            @elseif($appointment->status === 'completed')
                                                <span class="px-2 py-1 bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200 text-xs rounded-full">{{ __('messages.completed') }}</span>
                                            @elseif($appointment->status === 'canceled')
                                                <span class="px-2 py-1 bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200 text-xs rounded-full">{{ __('messages.canceled') }}</span>
                                            @endif
                                        </td>

                                        <td class="py-3 px-4 text-gray-600 dark:text-gray-400 max-w-xs truncate" title="{{ $appointment->notes }}">
                                            {{ $appointment->notes ?: '--' }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="py-6 px-4 text-center text-gray-500 dark:text-gray-400">
                                            {{ __('messages.no_appointments_history') }}
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
