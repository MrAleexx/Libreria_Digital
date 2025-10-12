{{-- resources/views/admin/categories/edit.blade.php --}}
@extends('admin.layout')

@section('title', 'Editar Categoría')
@section('subtitle', 'Modificar información de la categoría')

@section('content')
    <div class="space-y-6">
        <!-- Header -->
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-3">
                <div class="bg-gradient-to-r from-blue-500 to-blue-600 p-3 rounded-2xl shadow-sm">
                    <i class="fas fa-edit text-white text-xl"></i>
                </div>
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">Editar Categoría</h1>
                    <p class="text-gray-600">Modificando: <span
                            class="font-semibold text-blue-600">{{ $category->name }}</span></p>
                </div>
            </div>
            <a href="{{ route('admin.categories.index') }}"
                class="flex items-center space-x-2 px-4 py-2.5 text-gray-600 border border-gray-300 rounded-xl hover:bg-gray-50 transition-colors duration-200 font-medium">
                <i class="fas fa-arrow-left"></i>
                <span>Volver al listado</span>
            </a>
        </div>

        <!-- Información Rápida -->
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            <div class="bg-blue-50 rounded-xl p-4 border border-blue-200">
                <p class="text-xs text-blue-600 font-medium">Estado</p>
                <p class="text-sm font-semibold text-gray-900 flex items-center mt-1">
                    @if ($category->is_active)
                        <span class="w-2 h-2 bg-green-500 rounded-full mr-2"></span>
                        Activa
                    @else
                        <span class="w-2 h-2 bg-gray-400 rounded-full mr-2"></span>
                        Inactiva
                    @endif
                </p>
            </div>
            <div class="bg-gray-50 rounded-xl p-4 border border-gray-200">
                <p class="text-xs text-gray-600 font-medium">Tipo</p>
                <p class="text-sm font-semibold text-gray-900 flex items-center mt-1">
                    @if ($category->parent_id)
                        <i class="fas fa-folder text-purple-500 mr-2 text-xs"></i>
                        Subcategoría
                    @else
                        <i class="fas fa-folder-open text-green-500 mr-2 text-xs"></i>
                        Principal
                    @endif
                </p>
            </div>
            <div class="bg-gray-50 rounded-xl p-4 border border-gray-200">
                <p class="text-xs text-gray-600 font-medium">Orden</p>
                <p class="text-sm font-semibold text-gray-900 mt-1">{{ $category->sort_order }}</p>
            </div>
            <div class="bg-gray-50 rounded-xl p-4 border border-gray-200">
                <p class="text-xs text-gray-600 font-medium">Libros</p>
                <p class="text-sm font-semibold text-gray-900 mt-1">{{ $category->books_count ?? 0 }}</p>
            </div>
        </div>

        <!-- Formulario -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            @include('admin.categories.partials.form', [
                'category' => $category,
                'parentCategories' => $parentCategories,
                'method' => 'PUT',
                'action' => route('admin.categories.update', $category),
                'submitText' => 'Actualizar Categoría',
                'showDelete' => true,
            ])
        </div>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                initializeCategoryForm();
            });
        </script>
    @endpush
@endsection
