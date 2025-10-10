{{-- resources/views/admin/categories/partials/form.blade.php --}}
@php
    $category = $category ?? null;
    $parentCategories = $parentCategories ?? [];
    $method = $method ?? 'POST';
    $action = $action ?? '';
    $submitText = $submitText ?? 'Crear Categoría';
    $showDelete = $showDelete ?? false;
@endphp

<form action="{{ $action }}" method="POST">
    @csrf
    @method($method)

    <div class="p-8">
        <div class="grid grid-cols-1 xl:grid-cols-3 gap-8">
            <!-- Información Básica - Ocupa 2/3 del ancho -->
            <div class="xl:col-span-2 space-y-6">
                <div class="bg-gradient-to-br from-blue-50 to-blue-100/50 rounded-2xl p-6 border border-blue-200">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                        <i class="fas fa-info-circle text-blue-600 mr-2"></i>
                        Información Básica
                    </h3>

                    <div class="space-y-5">
                        <!-- Nombre -->
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-2 flex items-center">
                                <i class="fas fa-tag text-gray-400 mr-2"></i>
                                Nombre de la Categoría *
                            </label>
                            <input type="text" id="name" name="name" required
                                value="{{ old('name', $category->name ?? '') }}"
                                class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-colors placeholder-gray-400 shadow-sm"
                                placeholder="Ej: Ciencia Ficción">
                            @error('name')
                                <p class="text-red-600 text-sm mt-2 flex items-center">
                                    <i class="fas fa-exclamation-circle mr-1.5"></i>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- Slug -->
                        <div>
                            <label for="slug"
                                class="block text-sm font-medium text-gray-700 mb-2 flex items-center">
                                <i class="fas fa-link text-gray-400 mr-2"></i>
                                Slug (URL)
                            </label>
                            <input type="text" id="slug" name="slug"
                                value="{{ old('slug', $category->slug ?? '') }}"
                                class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-colors placeholder-gray-400 shadow-sm"
                                placeholder="Ej: ciencia-ficcion">
                            <p class="text-xs text-gray-500 mt-2 flex items-center">
                                <i class="fas fa-info-circle mr-1.5 text-blue-500"></i>
                                Dejar en blanco para generar automáticamente desde el nombre
                            </p>
                            @error('slug')
                                <p class="text-red-600 text-sm mt-2 flex items-center">
                                    <i class="fas fa-exclamation-circle mr-1.5"></i>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- Categoría Padre -->
                        <div>
                            <label for="parent_id"
                                class="block text-sm font-medium text-gray-700 mb-2 flex items-center">
                                <i class="fas fa-sitemap text-gray-400 mr-2"></i>
                                Categoría Padre
                            </label>
                            <select id="parent_id" name="parent_id"
                                class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-colors bg-white shadow-sm">
                                <option value="">Sin categoría padre (categoría principal)</option>
                                @foreach ($parentCategories as $parent)
                                    <option value="{{ $parent->id }}"
                                        {{ old('parent_id', $category->parent_id ?? '') == $parent->id && $parent->id !== ($category->id ?? null) ? 'selected' : '' }}
                                        {{ isset($category) && $parent->id === $category->id ? 'disabled' : '' }}
                                        class="{{ isset($category) && $parent->id === $category->id ? 'text-gray-400 bg-gray-100' : '' }}">
                                        {{ $parent->name }}
                                        @if (isset($category) && $parent->id === $category->id)
                                            (actual)
                                        @endif
                                    </option>
                                @endforeach
                            </select>
                            @error('parent_id')
                                <p class="text-red-600 text-sm mt-2 flex items-center">
                                    <i class="fas fa-exclamation-circle mr-1.5"></i>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- Descripción -->
                        <div>
                            <label for="description"
                                class="block text-sm font-medium text-gray-700 mb-2 flex items-center">
                                <i class="fas fa-align-left text-gray-400 mr-2"></i>
                                Descripción
                            </label>
                            <textarea id="description" name="description" rows="4"
                                class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-colors placeholder-gray-400 resize-none shadow-sm"
                                placeholder="Describe brevemente esta categoría...">{{ old('description', $category->description ?? '') }}</textarea>
                            @error('description')
                                <p class="text-red-600 text-sm mt-2 flex items-center">
                                    <i class="fas fa-exclamation-circle mr-1.5"></i>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <!-- Configuración Adicional - Ocupa 1/3 del ancho -->
            <div class="space-y-6">
                <div class="bg-gradient-to-br from-gray-50 to-gray-100/50 rounded-2xl p-6 border border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                        <i class="fas fa-cog text-gray-600 mr-2"></i>
                        Configuración
                    </h3>

                    <div class="space-y-5">
                        <!-- Orden y Estado -->
                        <div class="space-y-4">
                            <div>
                                <label for="sort_order"
                                    class="block text-sm font-medium text-gray-700 mb-2 flex items-center">
                                    <i class="fas fa-sort-numeric-down text-gray-400 mr-2"></i>
                                    Orden
                                </label>
                                <input type="number" id="sort_order" name="sort_order" min="0"
                                    value="{{ old('sort_order', $category->sort_order ?? 0) }}"
                                    class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-colors shadow-sm">
                                @error('sort_order')
                                    <p class="text-red-600 text-sm mt-2 flex items-center">
                                        <i class="fas fa-exclamation-circle mr-1.5"></i>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <div class="flex items-center">
                                <div
                                    class="flex items-center h-12 bg-white px-4 py-3 border border-gray-200 rounded-xl shadow-sm w-full justify-between">
                                    <div class="flex items-center">
                                        <input type="checkbox" id="is_active" name="is_active" value="1"
                                            {{ old('is_active', $category->is_active ?? true) ? 'checked' : '' }}
                                            class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500/20">
                                        <label for="is_active" class="ml-3 text-sm text-gray-700 font-medium">
                                            Categoría activa
                                        </label>
                                    </div>
                                    <div class="flex items-center space-x-1">
                                        <div class="w-2 h-2 rounded-full {{ old('is_active', $category->is_active ?? true) ? 'bg-green-500' : 'bg-gray-400' }}"
                                            id="status-indicator"></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Meta Información -->
                        <div class="pt-4 border-t border-gray-200">
                            <h4 class="text-sm font-medium text-gray-700 mb-3 flex items-center">
                                <i class="fas fa-search text-gray-400 mr-2"></i>
                                SEO (Opcional)
                            </h4>
                            <div class="space-y-4">
                                <div>
                                    <label for="meta_title" class="block text-xs font-medium text-gray-600 mb-2">
                                        Título Meta
                                    </label>
                                    <input type="text" id="meta_title" name="meta_title"
                                        value="{{ old('meta_title', $category->meta_title ?? '') }}"
                                        class="w-full px-3 py-2 text-sm border border-gray-200 rounded-lg focus:outline-none focus:ring-1 focus:ring-blue-500/20 focus:border-blue-500 transition-colors placeholder-gray-400"
                                        placeholder="Título para SEO...">
                                </div>
                                <div>
                                    <label for="meta_description" class="block text-xs font-medium text-gray-600 mb-2">
                                        Descripción Meta
                                    </label>
                                    <textarea id="meta_description" name="meta_description" rows="3"
                                        class="w-full px-3 py-2 text-sm border border-gray-200 rounded-lg focus:outline-none focus:ring-1 focus:ring-blue-500/20 focus:border-blue-500 transition-colors placeholder-gray-400 resize-none"
                                        placeholder="Descripción para SEO...">{{ old('meta_description', $category->meta_description ?? '') }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Botones de Acción -->
        <div
            class="flex flex-col sm:flex-row justify-between items-center space-y-4 sm:space-y-0 pt-8 mt-8 border-t border-gray-100">
            <div class="flex items-center text-sm text-gray-500">
                <i class="fas fa-lightbulb text-blue-500 mr-2"></i>
                <span>Los campos marcados con * son obligatorios</span>
            </div>
            <div class="flex space-x-3">
                <a href="{{ route('admin.categories.index') }}"
                    class="px-6 py-3 border border-gray-300 text-gray-700 rounded-xl hover:bg-gray-50 transition-all duration-200 flex items-center space-x-2 font-medium shadow-sm hover:shadow">
                    <i class="fas fa-arrow-left"></i>
                    <span>{{ isset($category) ? 'Volver' : 'Cancelar' }}</span>
                </a>

                @if ($showDelete && isset($category))
                    <button type="button"
                        onclick="if(confirm('¿Estás seguro de que quieres eliminar esta categoría?')) { document.getElementById('delete-form').submit(); }"
                        class="px-6 py-3 bg-gradient-to-r from-red-500 to-red-600 text-white rounded-xl hover:shadow-lg transition-all duration-200 flex items-center space-x-2 font-medium shadow-sm hover:from-red-600 hover:to-red-700">
                        <i class="fas fa-trash"></i>
                        <span>Eliminar</span>
                    </button>
                @endif

                <button type="submit"
                    class="px-8 py-3 bg-gradient-to-r from-blue-500 to-blue-600 text-white rounded-xl hover:shadow-lg transition-all duration-200 flex items-center space-x-2 font-medium shadow-sm hover:from-blue-600 hover:to-blue-700">
                    <i class="fas fa-save"></i>
                    <span>{{ $submitText }}</span>
                </button>
            </div>
        </div>
    </div>
</form>

@if ($showDelete && isset($category))
    <!-- Formulario de Eliminación (Hidden) -->
    <form id="delete-form" action="{{ route('admin.categories.destroy', $category) }}" method="POST"
        class="hidden">
        @csrf
        @method('DELETE')
    </form>
@endif
