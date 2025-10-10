{{-- resources/views/admin/categories/create.blade.php --}}
@extends('admin.layout')

@section('title', 'Crear Nueva Categoría')
@section('subtitle', 'Agregar una nueva categoría al sistema')

@section('content')
    <div class="space-y-6">
        <!-- Header -->
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-3">
                <div class="bg-gradient-to-r from-blue-500 to-blue-600 p-3 rounded-2xl shadow-sm">
                    <i class="fas fa-plus-circle text-white text-xl"></i>
                </div>
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">Crear Nueva Categoría</h1>
                    <p class="text-gray-600">Agrega una nueva categoría para organizar tu catálogo</p>
                </div>
            </div>
            <a href="{{ route('admin.categories.index') }}"
                class="flex items-center space-x-2 px-4 py-2.5 text-gray-600 border border-gray-300 rounded-xl hover:bg-gray-50 transition-colors duration-200 font-medium">
                <i class="fas fa-arrow-left"></i>
                <span>Volver al listado</span>
            </a>
        </div>

        <!-- Formulario -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            @include('admin.categories.partials.form', [
                'category' => null,
                'parentCategories' => $parentCategories,
                'method' => 'POST',
                'action' => route('admin.categories.store'),
                'submitText' => 'Crear Categoría',
                'showDelete' => false,
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
