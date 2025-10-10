{{-- resources/views/admin/books/partials/form-sections/status.blade.php --}}
<div class="bg-white rounded-lg border border-gray-200 p-6">
    <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
        <i class="fas fa-toggle-on text-purple-500 mr-2"></i>
        Estados y Visibilidad
    </h3>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <label
            class="flex items-center p-3 bg-white border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors duration-200">
            <input type="checkbox" name="is_new" value="1"
                class="rounded border-gray-300 text-purple-600 focus:ring-purple-500"
                {{ old('is_new', $book->is_new ?? false) ? 'checked' : '' }}>
            <span class="ml-3 text-sm text-gray-700 flex items-center">
                <i class="fas fa-star mr-2 text-yellow-500"></i>
                Marcar como Nuevo
            </span>
        </label>

        <label
            class="flex items-center p-3 bg-white border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors duration-200">
            <input type="checkbox" name="active" value="1"
                class="rounded border-gray-300 text-purple-600 focus:ring-purple-500"
                {{ old('active', $book->active ?? true) ? 'checked' : '' }}>
            <span class="ml-3 text-sm text-gray-700 flex items-center">
                <i class="fas fa-eye mr-2 text-green-500"></i>
                Visible en Biblioteca
            </span>
        </label>

        <label
            class="flex items-center p-3 bg-white border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors duration-200">
            <input type="checkbox" name="downloadable" value="1"
                class="rounded border-gray-300 text-purple-600 focus:ring-purple-500"
                {{ old('downloadable', $book->downloadable ?? true) ? 'checked' : '' }}>
            <span class="ml-3 text-sm text-gray-700 flex items-center">
                <i class="fas fa-download mr-2 text-blue-500"></i>
                Permitir Descargas
            </span>
        </label>
    </div>

    <div class="mt-4 text-xs text-gray-500 flex items-center">
        <i class="fas fa-info-circle text-purple-500 mr-2"></i>
        Los libros inactivos no serán visibles para los usuarios en la biblioteca
    </div>
</div>
