{{-- resources/views/admin/books/partials/form-sections/status.blade.php --}}
<div class="bg-white rounded-lg border border-gray-200 p-6">
    <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
        <i class="fas fa-toggle-on text-purple-500 mr-2"></i>
        Estados y Visibilidad
    </h3>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        {{-- ELIMINADO: is_new - ya no existe, usar featured --}}

        <label
            class="flex items-center p-3 bg-white border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors duration-200">
            <input type="checkbox" name="is_active" value="1"
                class="rounded border-gray-300 text-purple-600 focus:ring-purple-500"
                {{ old('is_active', $book->is_active ?? true) ? 'checked' : '' }}>
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

        {{-- NUEVO: Tipo de Libro --}}
        <div>
            <label for="book_type" class="block text-sm font-medium text-gray-700 mb-2 flex items-center">
                <i class="fas fa-book text-gray-400 mr-2 text-xs"></i>
                Tipo de Libro *
            </label>
            <select id="book_type" name="book_type" required
                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500">
                <option value="digital"
                    {{ old('book_type', $book->book_type ?? 'digital') == 'digital' ? 'selected' : '' }}>
                    Solo Digital
                </option>
                <option value="physical" {{ old('book_type', $book->book_type ?? '') == 'physical' ? 'selected' : '' }}>
                    Solo Físico
                </option>
                <option value="both" {{ old('book_type', $book->book_type ?? '') == 'both' ? 'selected' : '' }}>
                    Digital y Físico
                </option>
            </select>
        </div>
    </div>

    <div class="mt-4 text-xs text-gray-500 flex items-center">
        <i class="fas fa-info-circle text-purple-500 mr-2"></i>
        Los libros inactivos no serán visibles para los usuarios en la biblioteca
    </div>
</div>
