{{-- resources/views/admin/categories/index.blade.php --}}
@extends('admin.layout')

@section('title', 'Gestión de Categorías')
@section('subtitle', 'Organiza los libros por categorías')

@section('content')
    <div class="space-y-6">
        <!-- Header con Estadísticas Mejoradas -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
            @php
                $totalCategories = $categories->total();
                $activeCategories = $categories->where('is_active', true)->count();
                $mainCategories = $categories->whereNull('parent_id')->count();
                $subCategories = $categories->whereNotNull('parent_id')->count();

                // Calcular porcentaje de categorías activas de forma segura
                $activePercentage = $totalCategories > 0 ? round(($activeCategories / $totalCategories) * 100) : 0;
            @endphp

            <div
                class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-2xl p-5 border border-blue-200 shadow-sm hover:shadow-md transition-shadow duration-300">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-600 text-sm font-medium mb-1">Total Categorías</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $totalCategories }}</p>
                        <p class="text-xs text-gray-500 mt-1">En todo el sistema</p>
                    </div>
                    <div class="bg-blue-100 p-3 rounded-xl">
                        <i class="fas fa-folder-tree text-blue-600 text-lg"></i>
                    </div>
                </div>
            </div>

            <div
                class="bg-gradient-to-br from-green-50 to-green-100 rounded-2xl p-5 border border-green-200 shadow-sm hover:shadow-md transition-shadow duration-300">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-600 text-sm font-medium mb-1">Categorías Activas</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $activeCategories }}</p>
                        <p class="text-xs text-green-600 mt-1">
                            {{ $activePercentage }}% del total
                        </p>
                    </div>
                    <div class="bg-green-100 p-3 rounded-xl">
                        <i class="fas fa-check-circle text-green-600 text-lg"></i>
                    </div>
                </div>
            </div>

            <div
                class="bg-gradient-to-br from-purple-50 to-purple-100 rounded-2xl p-5 border border-purple-200 shadow-sm hover:shadow-md transition-shadow duration-300">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-600 text-sm font-medium mb-1">Categorías Principales</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $mainCategories }}</p>
                        <p class="text-xs text-purple-600 mt-1">Nivel raíz</p>
                    </div>
                    <div class="bg-purple-100 p-3 rounded-xl">
                        <i class="fas fa-layer-group text-purple-600 text-lg"></i>
                    </div>
                </div>
            </div>

            <div
                class="bg-gradient-to-br from-orange-50 to-orange-100 rounded-2xl p-5 border border-orange-200 shadow-sm hover:shadow-md transition-shadow duration-300">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-600 text-sm font-medium mb-1">Subcategorías</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $subCategories }}</p>
                        <p class="text-xs text-orange-600 mt-1">Nivel secundario</p>
                    </div>
                    <div class="bg-orange-100 p-3 rounded-xl">
                        <i class="fas fa-sitemap text-orange-600 text-lg"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Panel Principal Mejorado -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <!-- Header del Panel con Tabs -->
            <div class="border-b border-gray-100">
                <div class="px-6 py-4 bg-gradient-to-r from-gray-50 to-white">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                        <div class="flex items-center space-x-3">
                            <div class="bg-gradient-to-r from-blue-500 to-blue-600 p-2 rounded-xl shadow-sm">
                                <i class="fas fa-folder-tree text-white text-lg"></i>
                            </div>
                            <div>
                                <h2 class="text-xl font-semibold text-gray-800">Gestión de Categorías</h2>
                                <p class="text-gray-600 text-sm">Organiza y gestiona la estructura de tu catálogo</p>
                            </div>
                        </div>
                        <div class="flex items-center space-x-3 mt-3 sm:mt-0">
                            @if ($totalCategories > 0)
                                <button
                                    class="flex items-center space-x-2 px-4 py-2.5 text-gray-600 border border-gray-300 rounded-xl hover:bg-gray-50 transition-colors duration-200 font-medium">
                                    <i class="fas fa-download"></i>
                                    <span>Exportar</span>
                                </button>
                            @endif
                            <a href="{{ route('admin.categories.create') }}"
                                class="bg-gradient-to-r from-blue-500 to-blue-600 text-white px-5 py-2.5 rounded-xl hover:shadow-lg transition-all duration-200 flex items-center space-x-2 font-medium shadow-sm hover:from-blue-600 hover:to-blue-700">
                                <i class="fas fa-plus"></i>
                                <span>Nueva Categoría</span>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Tabs de Navegación -->
                <div class="px-6 border-b border-gray-100">
                    <div class="flex space-x-8 -mb-px">
                        <button
                            class="py-3 px-1 border-b-2 border-blue-500 text-blue-600 font-medium text-sm transition-colors duration-200">
                            <i class="fas fa-list mr-2"></i>
                            Todas las Categorías
                        </button>
                    </div>
                </div>
            </div>

            <!-- Filtros y Búsqueda Mejorados -->
            @if ($totalCategories > 0)
                <div class="px-6 py-4 bg-gray-50/50 border-b border-gray-100">
                    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
                        <div class="flex flex-col sm:flex-row gap-4 flex-1">
                            <div class="flex-1 relative max-w-md">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-search text-gray-400"></i>
                                </div>
                                <input type="text" id="search-categories" placeholder="Buscar categorías por nombre..."
                                    class="pl-10 w-full px-4 py-2.5 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-colors bg-white shadow-sm">
                            </div>
                            <div class="flex gap-3">
                                <select id="filter-status"
                                    class="px-4 py-2.5 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-colors bg-white shadow-sm min-w-40">
                                    <option value="">Todos los estados</option>
                                    <option value="active">Activas</option>
                                    <option value="inactive">Inactivas</option>
                                </select>
                                <select id="filter-parent"
                                    class="px-4 py-2.5 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-colors bg-white shadow-sm min-w-44">
                                    <option value="">Todas las jerarquías</option>
                                    <option value="parent">Solo principales</option>
                                    <option value="child">Solo subcategorías</option>
                                </select>
                            </div>
                        </div>
                        <div class="flex items-center space-x-2 text-sm text-gray-500">
                            <i class="fas fa-info-circle text-blue-500"></i>
                            <span>Usa ⇅ para reordenar arrastrando</span>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Lista de Categorías Mejorada -->
            <div class="divide-y divide-gray-100" id="categories-container">
                @if ($totalCategories > 0)
                    @foreach ($categories as $category)
                        <div class="p-6 hover:bg-gray-50/80 transition-all duration-200 category-item group"
                            data-status="{{ $category->is_active ? 'active' : 'inactive' }}"
                            data-parent="{{ $category->parent_id ? 'child' : 'parent' }}" draggable="true">
                            <div class="flex flex-col xl:flex-row xl:items-start xl:justify-between gap-4">
                                <!-- Información Principal -->
                                <div class="flex-1">
                                    <div class="flex items-start space-x-4">
                                        <!-- Icono con Estado -->
                                        <div class="flex-shrink-0 relative">
                                            <div
                                                class="w-14 h-14 rounded-xl bg-gradient-to-br from-blue-50 to-blue-100 border border-blue-200 flex items-center justify-center group-hover:shadow-sm transition-shadow duration-200">
                                                @if ($category->parent_id)
                                                    <i class="fas fa-folder text-blue-500 text-lg"></i>
                                                @else
                                                    <i class="fas fa-folder-open text-blue-600 text-lg"></i>
                                                @endif
                                            </div>
                                            @if (!$category->is_active)
                                                <div
                                                    class="absolute -top-1 -right-1 w-5 h-5 bg-gray-400 rounded-full border-2 border-white flex items-center justify-center">
                                                    <i class="fas fa-ban text-white text-xs"></i>
                                                </div>
                                            @endif
                                        </div>

                                        <!-- Contenido -->
                                        <div class="flex-1 min-w-0">
                                            <div
                                                class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-2 mb-3">
                                                <div class="flex items-center space-x-3">
                                                    <h3
                                                        class="text-lg font-semibold text-gray-900 truncate flex items-center space-x-2">
                                                        <span>{{ $category->name }}</span>
                                                        @if ($category->parent_id)
                                                            <span
                                                                class="px-2 py-1 text-xs font-medium bg-purple-100 text-purple-700 rounded-lg border border-purple-200">
                                                                Subcategoría
                                                            </span>
                                                        @else
                                                            <span
                                                                class="px-2 py-1 text-xs font-medium bg-green-100 text-green-700 rounded-lg border border-green-200">
                                                                Principal
                                                            </span>
                                                        @endif
                                                    </h3>
                                                </div>
                                                <div class="flex items-center space-x-2">
                                                    <span
                                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                                        <i class="fas fa-sort-numeric-down mr-1"></i>
                                                        {{ $category->sort_order }}
                                                    </span>
                                                </div>
                                            </div>

                                            @if ($category->description)
                                                <p class="text-gray-600 text-sm leading-relaxed mb-4 line-clamp-2">
                                                    {{ $category->description }}
                                                </p>
                                            @endif

                                            <!-- Metadatos -->
                                            <div class="flex flex-wrap items-center gap-4 text-sm text-gray-500">
                                                <span
                                                    class="flex items-center space-x-2 bg-gray-50 px-3 py-1.5 rounded-lg border border-gray-200">
                                                    <i class="fas fa-books text-gray-400"></i>
                                                    <span
                                                        class="font-medium text-gray-700">{{ $category->books_count ?? 0 }}</span>
                                                    <span class="text-gray-600">libros</span>
                                                </span>

                                                @if ($category->parent)
                                                    <span
                                                        class="flex items-center space-x-2 bg-blue-50 px-3 py-1.5 rounded-lg border border-blue-200">
                                                        <i class="fas fa-level-up-alt text-blue-400"></i>
                                                        <span class="text-blue-700">{{ $category->parent->name }}</span>
                                                    </span>
                                                @endif

                                                <span
                                                    class="flex items-center space-x-2 bg-gray-50 px-3 py-1.5 rounded-lg border border-gray-200">
                                                    <i class="fas fa-calendar text-gray-400"></i>
                                                    <span>{{ $category->created_at->format('d/m/Y') }}</span>
                                                </span>

                                                <span
                                                    class="flex items-center space-x-2 bg-gray-50 px-3 py-1.5 rounded-lg border border-gray-200">
                                                    <i class="fas fa-link text-gray-400"></i>
                                                    <span
                                                        class="font-mono text-xs text-gray-600">/{{ $category->slug }}</span>
                                                </span>
                                            </div>

                                            <!-- Subcategorías -->
                                            @if ($category->children && $category->children->count() > 0)
                                                <div class="mt-4 ml-2 pl-6 border-l-2 border-gray-200">
                                                    <div class="flex items-center space-x-2 mb-3">
                                                        <i class="fas fa-sitemap text-gray-400 text-sm"></i>
                                                        <span class="text-sm font-medium text-gray-700">
                                                            {{ $category->children->count() }} subcategorías
                                                        </span>
                                                    </div>
                                                    <div class="flex flex-wrap gap-2">
                                                        @foreach ($category->children as $child)
                                                            <span
                                                                class="inline-flex items-center px-3 py-1.5 bg-white text-gray-700 rounded-lg text-sm border border-gray-300 hover:bg-gray-50 hover:border-gray-400 transition-colors shadow-sm">
                                                                <i class="fas fa-folder text-gray-400 mr-2 text-xs"></i>
                                                                {{ $child->name }}
                                                                @if (!$child->is_active)
                                                                    <i class="fas fa-ban text-gray-300 ml-1.5 text-xs"></i>
                                                                @endif
                                                            </span>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <!-- Acciones Mejoradas -->
                                <div
                                    class="flex items-center justify-center space-x-2 xl:flex-col xl:space-x-0 xl:space-y-2 xl:min-w-32">
                                    <a href="{{ route('admin.categories.edit', $category) }}"
                                        class="flex items-center justify-center space-x-2 px-4 py-2.5 bg-white text-gray-700 rounded-xl border border-gray-300 hover:bg-gray-50 hover:border-gray-400 transition-all duration-200 text-sm font-medium shadow-sm hover:shadow group/btn xl:space-x-0 xl:p-3">
                                        <i class="fas fa-edit text-gray-500 group-hover/btn:text-blue-600"></i>
                                        <span class="xl:hidden">Editar</span>
                                    </a>

                                    <form action="{{ route('admin.categories.destroy', $category) }}" method="POST"
                                        onsubmit="return confirm('¿Estás seguro de eliminar esta categoría? Esta acción no se puede deshacer.')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="flex items-center justify-center space-x-2 px-4 py-2.5 bg-white text-red-600 rounded-xl border border-red-200 hover:bg-red-50 hover:border-red-300 transition-all duration-200 text-sm font-medium shadow-sm hover:shadow group/btn xl:space-x-0 xl:p-3">
                                            <i class="fas fa-trash text-red-500 group-hover/btn:text-red-700"></i>
                                            <span class="xl:hidden">Eliminar</span>
                                        </button>
                                    </form>
                                </div>

                            </div>
                        </div>
                    @endforeach
                @else
                    <!-- Estado Vacío Mejorado -->
                    <div class="text-center py-16">
                        <div
                            class="w-32 h-32 mx-auto mb-6 bg-gradient-to-br from-gray-50 to-gray-100 rounded-2xl border border-gray-200 flex items-center justify-center shadow-sm">
                            <i class="fas fa-folder-open text-gray-300 text-4xl"></i>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-900 mb-3">No hay categorías creadas</h3>
                        <p class="text-gray-600 mb-8 max-w-md mx-auto leading-relaxed">
                            Organiza tu catálogo creando categorías principales y subcategorías para una mejor experiencia
                            de navegación.
                        </p>
                        <div class="flex flex-col sm:flex-row gap-4 justify-center">
                            <a href="{{ route('admin.categories.create') }}"
                                class="inline-flex items-center space-x-3 bg-gradient-to-r from-blue-500 to-blue-600 text-white px-8 py-3.5 rounded-xl hover:shadow-lg transition-all duration-200 font-medium shadow-sm hover:from-blue-600 hover:to-blue-700">
                                <i class="fas fa-plus"></i>
                                <span>Crear Primera Categoría</span>
                            </a>
                            <button
                                class="inline-flex items-center space-x-3 bg-white text-gray-700 px-8 py-3.5 rounded-xl border border-gray-300 hover:bg-gray-50 transition-all duration-200 font-medium shadow-sm">
                                <i class="fas fa-question-circle"></i>
                                <span>Ver Tutorial</span>
                            </button>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Paginación Mejorada -->
            @if ($categories->hasPages())
                <div class="px-6 py-4 border-t border-gray-100 bg-gray-50/50">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                        <p class="text-sm text-gray-600">
                            Mostrando <span class="font-semibold text-gray-900">{{ $categories->firstItem() }}</span> -
                            <span class="font-semibold text-gray-900">{{ $categories->lastItem() }}</span> de
                            <span class="font-semibold text-gray-900">{{ $categories->total() }}</span> categorías
                        </p>
                        <div class="flex items-center space-x-2">
                            {{ $categories->links('vendor.pagination.tailwind') }}
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>

    @push('styles')
        <style>
            .line-clamp-2 {
                display: -webkit-box;
                -webkit-line-clamp: 2;
                -webkit-box-orient: vertical;
                overflow: hidden;
            }

            .category-item {
                cursor: move;
            }

            .category-item:hover {
                transform: translateY(-1px);
            }

            .category-item.dragging {
                opacity: 0.5;
                background: #f3f4f6;
            }
        </style>
    @endpush

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const searchInput = document.getElementById('search-categories');
                const statusFilter = document.getElementById('filter-status');
                const parentFilter = document.getElementById('filter-parent');
                const categoryItems = document.querySelectorAll('.category-item');

                // Solo inicializar filtros si hay categorías
                if (categoryItems.length > 0 && searchInput && statusFilter && parentFilter) {
                    function filterCategories() {
                        const searchTerm = searchInput.value.toLowerCase();
                        const statusValue = statusFilter.value;
                        const parentValue = parentFilter.value;

                        categoryItems.forEach(item => {
                            const categoryName = item.querySelector('h3').textContent.toLowerCase();
                            const categoryStatus = item.dataset.status;
                            const categoryParent = item.dataset.parent;

                            const matchesSearch = categoryName.includes(searchTerm);
                            const matchesStatus = !statusValue || categoryStatus === statusValue;
                            const matchesParent = !parentValue || categoryParent === parentValue;

                            if (matchesSearch && matchesStatus && matchesParent) {
                                item.style.display = 'block';
                                item.style.opacity = '1';
                            } else {
                                item.style.display = 'none';
                                item.style.opacity = '0';
                            }
                        });
                    }

                    // Funcionalidad de Drag & Drop (placeholder)
                    categoryItems.forEach(item => {
                        item.addEventListener('dragstart', (e) => {
                            e.target.classList.add('dragging');
                        });

                        item.addEventListener('dragend', (e) => {
                            e.target.classList.remove('dragging');
                        });
                    });

                    searchInput.addEventListener('input', filterCategories);
                    statusFilter.addEventListener('change', filterCategories);
                    parentFilter.addEventListener('change', filterCategories);

                    // Efectos de hover mejorados
                    categoryItems.forEach(item => {
                        item.addEventListener('mouseenter', function() {
                            this.style.transform = 'translateY(-2px)';
                        });

                        item.addEventListener('mouseleave', function() {
                            this.style.transform = 'translateY(0)';
                        });
                    });
                }
            });
        </script>
    @endpush
@endsection
