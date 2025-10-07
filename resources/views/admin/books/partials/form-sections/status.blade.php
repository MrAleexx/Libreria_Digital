{{-- resources/views/admin/books/partials/form-sections/status.blade.php --}}
<div class="bg-white rounded-lg border border-gray-200 p-6">
    <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
        <i class="fas fa-toggle-on text-indigo-500 mr-2"></i>
        Estados y Configuración
    </h3>

    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        <label class="flex items-center">
            <input type="checkbox" name="is_new" value="1"
                class="rounded border-gray-300 text-orange-600 focus:ring-orange-500"
                {{ old('is_new', $book->is_new ?? false) ? 'checked' : '' }}>
            <span class="ml-2 text-sm text-gray-700 flex items-center">
                <i class="fas fa-star mr-2 text-yellow-500"></i>
                ¿Es nuevo?
            </span>
        </label>

        <label class="flex items-center">
            <input type="checkbox" name="active" value="1"
                class="rounded border-gray-300 text-orange-600 focus:ring-orange-500"
                {{ old('active', $book->active ?? true) ? 'checked' : '' }}>
            <span class="ml-2 text-sm text-gray-700 flex items-center">
                <i class="fas fa-check-circle mr-2 text-green-500"></i>
                Activo
            </span>
        </label>

        <label class="flex items-center">
            <input type="checkbox" name="downloadable" value="1"
                class="rounded border-gray-300 text-orange-600 focus:ring-orange-500"
                {{ old('downloadable', $book->downloadable ?? true) ? 'checked' : '' }}>
            <span class="ml-2 text-sm text-gray-700 flex items-center">
                <i class="fas fa-download mr-2 text-blue-500"></i>
                Descargable
            </span>
        </label>

        <label class="flex items-center">
            <input type="checkbox" name="pre_order" value="1"
                class="rounded border-gray-300 text-orange-600 focus:ring-orange-500"
                {{ old('pre_order', $book->pre_order ?? false) ? 'checked' : '' }}>
            <span class="ml-2 text-sm text-gray-700 flex items-center">
                <i class="fas fa-clock mr-2 text-orange-500"></i>
                Pre-orden
            </span>
        </label>
    </div>
</div>
