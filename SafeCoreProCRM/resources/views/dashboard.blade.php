<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('messages.dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100 text-lg font-medium">
                    {{ __('messages.welcome_back') }}, {{ Auth::user()->name }}! 👋
                </div>
            </div>

            <div class="flex flex-col lg:flex-row gap-6 w-full">

                <div class="flex-1 bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg border-l-4 border-blue-500">
                    <div class="p-6">
                        <div class="text-sm font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                            {{ __('messages.total_patients') }}
                        </div>
                        <div class="mt-2 text-3xl font-bold text-gray-900 dark:text-white">
                            {{ $totalPatients }}
                        </div>
                    </div>
                </div>

                <div class="flex-1 bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg border-l-4 border-green-500">
                    <div class="p-6">
                        <div class="text-sm font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                            {{ __('messages.appointments_today') }}
                        </div>
                        <div class="mt-2 text-3xl font-bold text-gray-900 dark:text-white">
                            {{ $appointmentsToday }}
                        </div>
                    </div>
                </div>

                <div class="flex-1 bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg border-l-4 border-purple-500">
                    <div class="p-6">
                        <div class="text-sm font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                            {{ __('messages.appointments_month') }}
                        </div>
                        <div class="mt-2 text-3xl font-bold text-gray-900 dark:text-white">
                            {{ $appointmentsMonth }}
                        </div>
                    </div>
                </div>

            </div>

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">
                        {{ __('messages.appointments_by_status') }}
                    </h3>

                    <div class="relative h-72 w-full flex justify-center">
                        <canvas id="statusChart"></canvas>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">
                            {{ __('messages.appointments_doctor_today') }}
                        </h3>
                        <div class="relative h-72 w-full flex justify-center">
                            <canvas id="doctorTodayChart"></canvas>
                        </div>
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">
                            {{ __('messages.appointments_doctor_month') }}
                        </h3>
                        <div class="relative h-72 w-full flex justify-center">
                            <canvas id="doctorMonthChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('statusChart').getContext('2d');

            // Recebendo os dados do PHP de forma segura
            const chartData = @json($chartData);

            // Tradução dinâmica das Labels (i18n)
            const labels = [
                "{{ __('messages.scheduled') }}",
                "{{ __('messages.completed') }}",
                "{{ __('messages.canceled') }}"
            ];

            const data = [
                chartData.scheduled,
                chartData.completed,
                chartData.canceled
            ];

            new Chart(ctx, {
                type: 'doughnut', // Gráfico de rosca premium
                data: {
                    labels: labels,
                    datasets: [{
                        data: data,
                        backgroundColor: [
                            '#3b82f6', // Azul (Agendado)
                            '#10b981', // Verde (Concluído)
                            '#ef4444' // Vermelho (Cancelado)
                        ],
                        borderWidth: 0,
                        hoverOffset: 4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                // Deixa a fonte adaptável ao Dark/Light mode usando variáveis nativas
                                color: document.documentElement.classList.contains('dark') ? '#9ca3af' : '#4b5563',
                                font: {
                                    size: 14,
                                    family: "'Figtree', sans-serif"
                                }
                            }
                        }
                    }
                }
            });

            // --- CÓDIGO DO GRÁFICO DE STATUS AQUI --- //

            // ==== NOVOS GRÁFICOS DE BARRAS ==== //
            // Cores do Tema (Dark/Light) para os eixos e linhas de grade
            const textColor = document.documentElement.classList.contains('dark') ? '#9ca3af' : '#4b5563';
            const gridColor = document.documentElement.classList.contains('dark') ? '#374151' : '#e5e7eb';

            // Dados vindos do Controller
            const labelsToday = @json($labelsToday);
            const dataToday = @json($dataToday);
            const labelsMonth = @json($labelsMonth);
            const dataMonth = @json($dataMonth);

            // Função reutilizável para criar Gráficos de Barras premium
            function createBarChart(canvasId, labels, data, bgColor) {
                const ctxBar = document.getElementById(canvasId).getContext('2d');
                new Chart(ctxBar, {
                    type: 'bar',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: "{{ __('messages.appointments') }}",
                            data: data,
                            backgroundColor: bgColor,
                            borderRadius: 6, // Cantos arredondados premium
                            borderSkipped: false,
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                display: false
                            } // Esconde a legenda pois o título já explica
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: {
                                    precision: 0, // Apenas números inteiros
                                    color: textColor
                                },
                                grid: {
                                    color: gridColor
                                }
                            },
                            x: {
                                ticks: {
                                    color: textColor
                                },
                                grid: {
                                    display: false
                                } // Remove as linhas verticais para ficar mais limpo
                            }
                        }
                    }
                });
            }

            // Inicializa os gráficos (Azul para Hoje, Roxo para o Mês)
            createBarChart('doctorTodayChart', labelsToday, dataToday, '#3b82f6');
            createBarChart('doctorMonthChart', labelsMonth, dataMonth, '#8b5cf6');
        });
    </script>
</x-app-layout>
