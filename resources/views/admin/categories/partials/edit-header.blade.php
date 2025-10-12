{{-- resources/views/admin/categories/partials/edit-header.blade.php --}}
@props(['category'])

<!-- Información Rápida -->
<div class="grid grid-cols-2 md:grid-cols-4 gap-4 mt-4">
    <div class="bg-blue-50 rounded-xl p-3 border border-blue-200">
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
    <div class="bg-gray-50 rounded-xl p-3 border border-gray-200">
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
    <div class="bg-gray-50 rounded-xl p-3 border border-gray-200">
        <p class="text-xs text-gray-600 font-medium">Orden</p>
        <p class="text-sm font-semibold text-gray-900 mt-1">{{ $category->sort_order }}</p>
    </div>
    <div class="bg-gray-50 rounded-xl p-3 border border-gray-200">
        <p class="text-xs text-gray-600 font-medium">Libros</p>
        <p class="text-sm font-semibold text-gray-900 mt-1">{{ $category->books_count ?? 0 }}</p>
    </div>
</div>
