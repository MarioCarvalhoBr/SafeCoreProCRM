<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('messages.staff') }}
            </h2>
            <a href="{{ route('users.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded transition">
                {{ __('messages.add_staff') }}
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

            @if ($errors->any())
                <div class="mb-4 bg-red-100 dark:bg-red-900 border border-red-400 dark:border-red-700 text-red-700 dark:text-red-300 px-4 py-3 rounded relative">
                    {{ $errors->first() }}
                </div>
            @endif

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    <div class="overflow-x-auto">

                    <form method="GET" action="{{ route('users.index') }}" class="mb-6 flex gap-2">
                        <input type="hidden" name="sort_by" value="{{ request('sort_by') }}">
                        <input type="hidden" name="sort_dir" value="{{ request('sort_dir') }}">
                        <x-text-input name="search" value="{{ request('search') }}" placeholder="{{ __('messages.search') }}" class="w-full md:w-1/3 dark:bg-gray-900" />
                        <x-primary-button type="submit">{{ __('messages.search_button') }}</x-primary-button>
                        @if(request('search'))
                            <a href="{{ route('users.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-300 dark:bg-gray-700 text-gray-800 dark:text-gray-200 rounded-md hover:bg-gray-400 dark:hover:bg-gray-600 transition">{{ __('messages.clear') }}</a>
                        @endif
                    </form>
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="border-b border-gray-200 dark:border-gray-700">
                                    <th class="py-3 px-4 uppercase font-semibold text-sm">
                                        <x-sortable-header column="name" :label="__('messages.name')" />
                                    </th>
                                    <th class="py-3 px-4 uppercase font-semibold text-sm">
                                        <x-sortable-header column="email" :label="__('messages.email')" />
                                    </th>
                                    <th class="py-3 px-4 uppercase font-semibold text-sm">{{ __('messages.role') }}</th>
                                    <th class="py-3 px-4 uppercase font-semibold text-sm text-center">{{ __('messages.actions') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($users as $user)
                                    <tr class="border-b border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                                        <td class="py-3 px-4 font-medium">{{ $user->name }}</td>
                                        <td class="py-3 px-4 text-gray-500 dark:text-gray-400">{{ $user->email }}</td>

                                        <td class="py-3 px-4">
                                            @foreach($user->roles as $role)
                                                @if($role->name == 'Admin')
                                                    <span class="px-2 py-1 bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-200 text-xs rounded-full font-bold">ADMIN</span>
                                                @elseif($role->name == 'Doctor')
                                                    <span class="px-2 py-1 bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200 text-xs rounded-full font-bold">DOCTOR</span>
                                                @else
                                                    <span class="px-2 py-1 bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-200 text-xs rounded-full font-bold">{{ strtoupper($role->name) }}</span>
                                                @endif
                                            @endforeach
                                        </td>

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
                                                        <x-dropdown-link :href="route('users.edit', $user->id)" class="text-blue-600 dark:text-blue-400">
                                                            {{ __('messages.edit') }}
                                                        </x-dropdown-link>

                                                        <div class="border-t border-gray-200 dark:border-gray-600"></div>

                                                        <!-- Excluir (Abre Modal) -->
                                                        <button type="button" x-data="" x-on:click.prevent="$dispatch('open-modal', 'confirm-deletion-{{ $user->id }}')" class="block w-full px-4 py-2 text-start text-sm leading-5 text-red-600 dark:text-red-400 hover:bg-gray-100 dark:hover:bg-gray-800 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-800 transition duration-150 ease-in-out">
                                                            {{ __('messages.delete') }}
                                                        </button>
                                                    </x-slot>
                                                </x-dropdown>

                                                <!-- Modal de Exclusão (Fora do Dropdown) -->
                                                <x-modal name="confirm-deletion-{{ $user->id }}" focusable>
                                                    <form method="post" action="{{ route('users.destroy', $user->id) }}" class="p-6 text-left">
                                                        @csrf
                                                        @method('delete')

                                                        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                                                            {{ __('messages.confirm_delete') }}: <span class="text-red-600 dark:text-red-400">{{ $user->name }}</span>
                                                        </h2>

                                                        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                                                            {{ __('messages.delete_user_text') }}
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
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-4">{{ $users->links() }}</div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
