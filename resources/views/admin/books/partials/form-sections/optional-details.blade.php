{{-- resources/views/admin/books/partials/form-sections/optional-details.blade.php --}}
<div class="bg-white rounded-lg border border-gray-200 p-6">
    <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
        <i class="fas fa-ellipsis-h text-gray-500 mr-2"></i>
        Detalles Opcionales
    </h3>

    <div class="space-y-4">
        <!-- Edición -->
        <div>
            <label for="edition" class="block text-sm font-medium text-gray-700 mb-2 flex items-center">
                <i class="fas fa-layer-group text-gray-400 mr-2 text-xs"></i>
                Edición
            </label>
            <input type="text" id="edition" name="edition"
                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500"
                value="{{ old('edition', $book->edition ?? '1ra') }}" placeholder="Ej: 1ra, 2da, 3ra edición">
            @error('edition')
                <p class="text-red-500 text-sm mt-1 flex items-center">
                    <i class="fas fa-exclamation-circle mr-1"></i>
                    {{ $message }}
                </p>
            @enderror
        </div>

        <!-- Formato y Tamaño de Archivo -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label for="file_format" class="block text-sm font-medium text-gray-700 mb-2 flex items-center">
                    <i class="fas fa-format text-gray-400 mr-2 text-xs"></i>
                    Formato de Archivo
                </label>
                <select id="file_format" name="file_format"
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500">
                    <option value="">Seleccionar formato</option>
                    <option value="PDF"
                        {{ old('file_format', $book->file_format ?? '') == 'PDF' ? 'selected' : '' }}>PDF</option>
                    <option value="EPUB"
                        {{ old('file_format', $book->file_format ?? '') == 'EPUB' ? 'selected' : '' }}>EPUB</option>
                    <option value="MOBI"
                        {{ old('file_format', $book->file_format ?? '') == 'MOBI' ? 'selected' : '' }}>MOBI</option>
                    <option value="AZW3"
                        {{ old('file_format', $book->file_format ?? '') == 'AZW3' ? 'selected' : '' }}>AZW3 (Kindle)
                    </option>
                </select>
                @error('file_format')
                    <p class="text-red-500 text-sm mt-1 flex items-center">
                        <i class="fas fa-exclamation-circle mr-1"></i>
                        {{ $message }}
                    </p>
                @enderror
            </div>

            <div>
                <label for="file_size" class="block text-sm font-medium text-gray-700 mb-2 flex items-center">
                    <i class="fas fa-weight text-gray-400 mr-2 text-xs"></i>
                    Tamaño de Archivo
                </label>
                <input type="text" id="file_size" name="file_size"
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500"
                    value="{{ old('file_size', $book->file_size ?? '') }}" placeholder="Ej: 2.8 MB, 15.3 MB">
                @error('file_size')
                    <p class="text-red-500 text-sm mt-1 flex items-center">
                        <i class="fas fa-exclamation-circle mr-1"></i>
                        {{ $message }}
                    </p>
                @enderror
            </div>
        </div>

        <!-- Edad de Lectura y Depósito Legal -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label for="reading_age" class="block text-sm font-medium text-gray-700 mb-2 flex items-center">
                    <i class="fas fa-user text-gray-400 mr-2 text-xs"></i>
                    Edad de Lectura Recomendada
                </label>
                <select id="reading_age" name="reading_age"
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500">
                    <option value="">Seleccionar edad</option>
                    <option value="0-3"
                        {{ old('reading_age', $book->reading_age ?? '') == '0-3' ? 'selected' : '' }}>0-3 años</option>
                    <option value="4-6"
                        {{ old('reading_age', $book->reading_age ?? '') == '4-6' ? 'selected' : '' }}>4-6 años</option>
                    <option value="7-9"
                        {{ old('reading_age', $book->reading_age ?? '') == '7-9' ? 'selected' : '' }}>7-9 años</option>
                    <option value="10-12"
                        {{ old('reading_age', $book->reading_age ?? '') == '10-12' ? 'selected' : '' }}>10-12 años
                    </option>
                    <option value="13-15"
                        {{ old('reading_age', $book->reading_age ?? '') == '13-15' ? 'selected' : '' }}>13-15 años
                    </option>
                    <option value="16-18"
                        {{ old('reading_age', $book->reading_age ?? '') == '16-18' ? 'selected' : '' }}>16-18 años
                    </option>
                    <option value="18+"
                        {{ old('reading_age', $book->reading_age ?? '') == '18+' ? 'selected' : '' }}>Adultos (18+)
                    </option>
                    <option value="all"
                        {{ old('reading_age', $book->reading_age ?? '') == 'all' ? 'selected' : '' }}>Todas las edades
                    </option>
                </select>
            </div>

            <div>
                <label for="deposito_legal" class="block text-sm font-medium text-gray-700 mb-2 flex items-center">
                    <i class="fas fa-file-certificate text-gray-400 mr-2 text-xs"></i>
                    Depósito Legal
                </label>
                <input type="text" id="deposito_legal" name="deposito_legal"
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500"
                    value="{{ old('deposito_legal', $book->deposito_legal ?? '') }}" placeholder="Ej: B 12345-2024">
                @error('deposito_legal')
                    <p class="text-red-500 text-sm mt-1 flex items-center">
                        <i class="fas fa-exclamation-circle mr-1"></i>
                        {{ $message }}
                    </p>
                @enderror
            </div>
        </div>

        <!-- Restricciones -->
        <div>
            <label for="restrictions" class="block text-sm font-medium text-gray-700 mb-2 flex items-center">
                <i class="fas fa-ban text-gray-400 mr-2 text-xs"></i>
                Restricciones de Uso
            </label>
            <textarea id="restrictions" name="restrictions" rows="3"
                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500"
                placeholder="Ej: No se permite la reproducción comercial, Solo para uso educativo">{{ old('restrictions', $book->restrictions ?? '') }}</textarea>
            @error('restrictions')
                <p class="text-red-500 text-sm mt-1 flex items-center">
                    <i class="fas fa-exclamation-circle mr-1"></i>
                    {{ $message }}
                </p>
            @enderror
        </div>

        <!-- Notas Internas -->
        <div>
            <label for="notes" class="block text-sm font-medium text-gray-700 mb-2 flex items-center">
                <i class="fas fa-sticky-note text-gray-400 mr-2 text-xs"></i>
                Notas Internas
            </label>
            <textarea id="notes" name="notes" rows="3"
                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500"
                placeholder="Notas para administradores y bibliotecarios">{{ old('notes', $book->notes ?? '') }}</textarea>
            @error('notes')
                <p class="text-red-500 text-sm mt-1 flex items-center">
                    <i class="fas fa-exclamation-circle mr-1"></i>
                    {{ $message }}
                </p>
            @enderror
        </div>
    </div>

    <div class="mt-4 p-3 bg-blue-50 rounded-lg border border-blue-200">
        <div class="flex items-start">
            <i class="fas fa-info-circle text-blue-500 mt-0.5 mr-2"></i>
            <div class="text-sm text-blue-700">
                <p class="font-medium">Información opcional</p>
                <p class="text-xs mt-1">Estos detalles no son obligatorios pero enriquecen la información del libro en
                    el catálogo.</p>
            </div>
        </div>
    </div>
</div>
