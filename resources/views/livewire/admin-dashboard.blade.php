{{-- resources/views/livewire/admin-dashboard.blade.php --}}
<div class="space-y-6" x-data="dashboardCharts()" x-init="initCharts()">
    <!-- Header con selector de período -->
    <div class="flex justify-between items-center">
        <h2 class="text-2xl font-bold text-gray-900">Dashboard</h2>
        <select wire:model.live="selectedPeriod"
            class="border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
            <option value="7d">Últimos 7 días</option>
            <option value="30d">Últimos 30 días</option>
            <option value="90d">Últimos 90 días</option>
        </select>
    </div>

    <!-- Grid de Stats -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Total de Libros -->
        <div
            class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 hover:shadow-md transition-shadow duration-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Total de Libros</p>
                    <p class="text-3xl font-bold text-gray-900 mt-2">{{ $stats['total_books'] ?? 0 }}</p>
                </div>
                <div class="p-3 bg-blue-50 rounded-xl">
                    <i class="fas fa-book text-blue-600 text-xl"></i>
                </div>
            </div>
            <div class="mt-4 flex items-center text-sm text-green-600">
                <i class="fas fa-arrow-up mr-1"></i>
                <span>+12% desde el mes pasado</span>
            </div>
        </div>

        <!-- Total de Usuarios -->
        <div
            class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 hover:shadow-md transition-shadow duration-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Total de Usuarios</p>
                    <p class="text-3xl font-bold text-gray-900 mt-2">{{ $stats['total_users'] ?? 0 }}</p>
                </div>
                <div class="p-3 bg-green-50 rounded-xl">
                    <i class="fas fa-users text-green-600 text-xl"></i>
                </div>
            </div>
            <div class="mt-4">
                <div class="flex justify-between text-sm text-gray-600">
                    <span>Activos: {{ $stats['active_users'] ?? 0 }}</span>
                    <span class="text-orange-600">{{ $stats['users_with_temp_passwords'] ?? 0 }} temp</span>
                </div>
            </div>
        </div>

        <!-- Descargas Totales -->
        <div
            class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 hover:shadow-md transition-shadow duration-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Descargas Totales</p>
                    <p class="text-3xl font-bold text-gray-900 mt-2">{{ $stats['total_downloads'] ?? 0 }}</p>
                </div>
                <div class="p-3 bg-purple-50 rounded-xl">
                    <i class="fas fa-download text-purple-600 text-xl"></i>
                </div>
            </div>
            <div class="mt-4 flex items-center text-sm text-blue-600">
                <i class="fas fa-download mr-1"></i>
                <span>{{ $stats['today_downloads'] ?? 0 }} hoy</span>
            </div>
        </div>

        <!-- Libros Destacados -->
        <div
            class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 hover:shadow-md transition-shadow duration-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Libros Destacados</p>
                    <p class="text-3xl font-bold text-gray-900 mt-2">{{ $stats['featured_books'] ?? 0 }}</p>
                </div>
                <div class="p-3 bg-orange-50 rounded-xl">
                    <i class="fas fa-star text-orange-600 text-xl"></i>
                </div>
            </div>
            <div class="mt-4 flex items-center text-sm text-gray-600">
                <i class="fas fa-clock mr-1"></i>
                <span>Actualizado ahora</span>
            </div>
        </div>
    </div>

    <!-- Gráficos -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Gráfico de Descargas -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Descargas por Día</h3>
            <div class="h-80">
                <canvas id="downloadsChart"></canvas>
            </div>
        </div>

        <!-- Libros por Categoría -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Libros por Categoría</h3>
            <div class="h-80">
                <canvas id="categoriesChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Actividad de Usuarios -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Actividad de Usuarios</h3>
        <div class="h-80">
            <canvas id="userActivityChart"></canvas>
        </div>
    </div>
</div>

<script>
    function dashboardCharts() {
        return {
            charts: {},

            initCharts() {
                this.$nextTick(() => {
                    this.createCharts();
                });
            },

            createCharts() {
                // Verificar que Chart.js esté disponible
                if (typeof Chart === 'undefined') {
                    console.error('Chart.js no está disponible');
                    return;
                }

                // Destruir gráficos existentes
                Object.values(this.charts).forEach(chart => {
                    if (chart) chart.destroy();
                });

                // Crear gráficos
                this.charts.downloads = this.createDownloadsChart();
                this.charts.categories = this.createCategoriesChart();
                this.charts.userActivity = this.createUserActivityChart();
            },

            createDownloadsChart() {
                const ctx = document.getElementById('downloadsChart');
                if (!ctx) return null;

                return new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: @json($stats['downloads_chart']['labels'] ?? []),
                        datasets: [{
                            label: 'Descargas',
                            data: @json($stats['downloads_chart']['data'] ?? []),
                            borderColor: '#3B82F6',
                            backgroundColor: 'rgba(59, 130, 246, 0.1)',
                            borderWidth: 3,
                            fill: true,
                            tension: 0.4
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                display: false
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true
                            },
                            x: {
                                grid: {
                                    display: false
                                }
                            }
                        }
                    }
                });
            },

            createCategoriesChart() {
                const ctx = document.getElementById('categoriesChart');
                if (!ctx) return null;

                return new Chart(ctx, {
                    type: 'doughnut',
                    data: {
                        labels: @json($stats['books_by_category']['labels'] ?? []),
                        datasets: [{
                            data: @json($stats['books_by_category']['data'] ?? []),
                            backgroundColor: ['#3B82F6', '#10B981', '#F59E0B', '#EF4444', '#8B5CF6',
                                '#06B6D4'
                            ],
                            borderWidth: 2,
                            borderColor: '#fff'
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                position: 'right'
                            }
                        }
                    }
                });
            },

            createUserActivityChart() {
                const ctx = document.getElementById('userActivityChart');
                if (!ctx) return null;

                const userData = @json($stats['user_activity']['data'] ?? []);

                return new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: @json($stats['user_activity']['labels'] ?? []),
                        datasets: [{
                                label: 'Descargas',
                                data: userData.map(d => d.downloads),
                                backgroundColor: '#10B981'
                            },
                            {
                                label: 'Registros',
                                data: userData.map(d => d.registrations),
                                backgroundColor: '#3B82F6'
                            }
                        ]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        scales: {
                            x: {
                                grid: {
                                    display: false
                                }
                            },
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                });
            }
        }
    }

    // Escuchar eventos de Livewire para actualizar gráficos
    document.addEventListener('livewire:init', () => {
        Livewire.on('stats-updated', () => {
            const dashboard = document.querySelector('[x-data="dashboardCharts()"]');
            if (dashboard && dashboard.__x) {
                dashboard.__x.$data.createCharts();
            }
        });
    });
</script>
