<div x-data="{
        sidebarOpen: window.innerWidth >= 1024,
        updateLayout() {
            // Empurra o corpo da página para a direita se estiver no PC e a gaveta estiver aberta
            document.body.style.paddingLeft = (this.sidebarOpen && window.innerWidth >= 1024) ? '16rem' : '0px';
        }
    }"
    @resize.window="updateLayout()"
    x-init="
        document.body.classList.add('transition-all', 'duration-300', 'ease-in-out');
        $watch('sidebarOpen', () => updateLayout());
        updateLayout();
    ">

    <!-- OVERLAY ESCURO PARA MOBILE (Fecha a gaveta ao clicar fora) -->
    <div x-show="sidebarOpen"
         x-transition:enter="transition-opacity ease-linear duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition-opacity ease-linear duration-300"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 bg-gray-900/80 z-40 lg:hidden"
         @click="sidebarOpen = false"
         style="display: none;">
    </div>

    <!-- SIDEBAR (GAVETA DE NAVEGAÇÃO) -->
    <aside class="fixed top-0 left-0 z-50 h-screen w-64 bg-white dark:bg-gray-800 border-r border-gray-200 dark:border-gray-700 transition-transform duration-300 ease-in-out flex flex-col shadow-xl lg:shadow-none"
           :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'">

        <!-- Logotipo da Gaveta -->
        <div class="flex items-center justify-center h-16 border-b border-gray-200 dark:border-gray-700 px-4">
            <a href="{{ route('dashboard') }}" class="flex items-center gap-2">
                <x-application-logo class="block h-8 w-auto fill-current text-indigo-600 dark:text-indigo-400" />
            </a>
        </div>

        <!-- Links da Gaveta -->
        <nav class="flex-1 overflow-y-auto py-4 space-y-1 px-3">

            @php
                $activeClass = 'bg-indigo-50 dark:bg-gray-900/50 text-indigo-700 dark:text-indigo-400 rounded-md font-semibold';
                $inactiveClass = 'text-gray-600 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-700 hover:text-gray-900 dark:hover:text-gray-200 rounded-md font-medium transition-colors duration-200';
            @endphp

            @unlessrole('Patient')
            <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-3 py-2.5 {{ request()->routeIs('dashboard') ? $activeClass : $inactiveClass }}" @click="if(window.innerWidth < 1024) sidebarOpen = false">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                {{ __('messages.dashboard') }}
            </a>

            <a href="{{ route('patients.index') }}" class="flex items-center gap-3 px-3 py-2.5 {{ request()->routeIs('patients.*') ? $activeClass : $inactiveClass }}" @click="if(window.innerWidth < 1024) sidebarOpen = false">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                {{ __('messages.patients') }}
            </a>

            <a href="{{ route('appointments.index') }}" class="flex items-center gap-3 px-3 py-2.5 {{ request()->routeIs('appointments.*') ? $activeClass : $inactiveClass }}" @click="if(window.innerWidth < 1024) sidebarOpen = false">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                {{ __('messages.appointments') }}
            </a>
            @endunlessrole

            @hasrole('Patient')
            <a href="{{ route('portal.dashboard') }}" class="flex items-center gap-3 px-3 py-2.5 {{ request()->routeIs('portal.dashboard') ? $activeClass : $inactiveClass }}" @click="if(window.innerWidth < 1024) sidebarOpen = false">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                {{ __('messages.my_appointments') }}
            </a>

            <a href="{{ route('portal.book') }}" class="flex items-center gap-3 px-3 py-2.5 {{ request()->routeIs('portal.book') ? $activeClass : $inactiveClass }}" @click="if(window.innerWidth < 1024) sidebarOpen = false">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                {{ __('messages.new_appointment') }}
            </a>
            @endhasrole

            @hasrole('Admin')
            <div class="pt-6 pb-2 px-3 text-xs font-semibold text-gray-400 dark:text-gray-500 uppercase tracking-wider">
                {{ __('messages.administration') }}
            </div>

            <a href="{{ route('users.index') }}" class="flex items-center gap-3 px-3 py-2.5 {{ request()->routeIs('users.*') ? $activeClass : $inactiveClass }}" @click="if(window.innerWidth < 1024) sidebarOpen = false">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                {{ __('messages.staff') }}
            </a>
            @endhasrole

        </nav>

        <!-- Rodapé da Gaveta (Perfil Simplificado) -->
        <div class="p-4 border-t border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800/50">
            <div class="font-medium text-sm text-gray-900 dark:text-gray-100 truncate">{{ Auth::user()->name }}</div>
            <div class="text-xs text-gray-500 dark:text-gray-400 truncate">{{ Auth::user()->email }}</div>
        </div>
    </aside>

    <!-- TOOLBAR SUPERIOR -->
    <nav class="bg-white dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700 transition duration-300 ease-in-out relative z-30">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">

                <!-- Esquerda: Hamburger + Nome do App -->
                <div class="flex items-center gap-3">
                    <button @click="sidebarOpen = !sidebarOpen" class="inline-flex items-center justify-center p-2 rounded-md text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 transition duration-150 ease-in-out">
                        <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>

                    <span class="font-bold text-lg text-gray-800 dark:text-gray-200 tracking-wide truncate">
                        {{ config('app.name', __('messages.app_name')) }}
                    </span>
                </div>

                <!-- Direita: Ícones de Ação e Menu de Utilizador -->
                <div class="flex items-center space-x-2 sm:space-x-4">

                    <!-- Dark Mode -->
                    <button @click="darkMode = !darkMode" class="p-2 text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 transition duration-150 ease-in-out rounded-full hover:bg-gray-100 dark:hover:bg-gray-700">
                        <svg x-cloak x-show="darkMode" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="display: none;">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path>
                        </svg>
                        <svg x-cloak x-show="!darkMode" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path>
                        </svg>
                    </button>

                    <div class="hidden sm:block h-5 w-px bg-gray-300 dark:bg-gray-600"></div>

                    <!-- Idioma -->
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button class="inline-flex items-center p-2 border border-transparent text-sm font-medium rounded-md text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 focus:outline-none transition ease-in-out duration-150">
                                <span class="uppercase font-bold">{{ strtoupper(App::getLocale()) }}</span>
                            </button>
                        </x-slot>
                        <x-slot name="content">
                            <x-dropdown-link :href="route('lang.switch', 'en')" class="{{ App::getLocale() == 'en' ? 'font-bold text-indigo-600 dark:text-indigo-400 bg-indigo-50 dark:bg-gray-800' : '' }}">EN - English</x-dropdown-link>
                            <x-dropdown-link :href="route('lang.switch', 'pt')" class="{{ App::getLocale() == 'pt' ? 'font-bold text-indigo-600 dark:text-indigo-400 bg-indigo-50 dark:bg-gray-800' : '' }}">PT - Português</x-dropdown-link>
                            <x-dropdown-link :href="route('lang.switch', 'es')" class="{{ App::getLocale() == 'es' ? 'font-bold text-indigo-600 dark:text-indigo-400 bg-indigo-50 dark:bg-gray-800' : '' }}">ES - Español</x-dropdown-link>
                        </x-slot>
                    </x-dropdown>

                    <div class="hidden sm:block h-5 w-px bg-gray-300 dark:bg-gray-600"></div>

                    <!-- Utilizador / Configurações -->
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button class="inline-flex items-center p-2 border border-transparent text-sm font-medium rounded-md text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 focus:outline-none transition ease-in-out duration-150">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </button>
                        </x-slot>
                        <x-slot name="content">
                            <x-dropdown-link :href="route('profile.edit')">
                                {{ __('messages.profile') }}
                            </x-dropdown-link>

                            @hasrole('Admin')
                                <x-dropdown-link :href="route('tenant.edit')">
                                    {{ __('messages.clinic_settings') }}
                                </x-dropdown-link>
                                <x-dropdown-link :href="route('audit.index')">
                                    {{ __('messages.audit_logs') }}
                                </x-dropdown-link>
                                <x-dropdown-link :href="route('backups.index')">
                                    {{ __('messages.backups') }}
                                </x-dropdown-link>
                            @endhasrole

                            <div class="border-t border-gray-100 dark:border-gray-700"></div>

                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-dropdown-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();" class="text-red-600 dark:text-red-400">
                                    {{ __('messages.logout') }}
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>

                </div>
            </div>
        </div>
    </nav>
</div>
