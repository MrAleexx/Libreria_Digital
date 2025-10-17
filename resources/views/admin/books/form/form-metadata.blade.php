<!-- resources/views/admin/books/form/form-metadata.blade.php -->
<div class="space-y-6">
    <!-- Header -->
    <div class="mb-2">
        <h4 class="text-lg font-medium text-gray-900 mb-2">Metadatos Adicionales</h4>
        <p class="text-sm text-gray-600">
            Información técnica y descriptiva adicional para mejorar la catalogación y búsqueda.
        </p>
    </div>

    <!-- Información técnica -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div>
            <label for="file_format" class="block text-sm font-medium text-gray-700 mb-1">
                Formato de Archivo
            </label>
            <select name="file_format" id="file_format"
                class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
                <option value="PDF"
                    {{ old('file_format', $book->details->file_format ?? 'PDF') == 'PDF' ? 'selected' : '' }}>PDF
                </option>
                <option value="EPUB"
                    {{ old('file_format', $book->details->file_format ?? '') == 'EPUB' ? 'selected' : '' }}>EPUB
                </option>
                <option value="MOBI"
                    {{ old('file_format', $book->details->file_format ?? '') == 'MOBI' ? 'selected' : '' }}>MOBI
                </option>
                <option value="AZW"
                    {{ old('file_format', $book->details->file_format ?? '') == 'AZW' ? 'selected' : '' }}>AZW</option>
            </select>
            @error('file_format')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="file_size" class="block text-sm font-medium text-gray-700 mb-1">
                Tamaño de Archivo
            </label>
            <input type="text" name="file_size" id="file_size"
                value="{{ old('file_size', $book->details->file_size ?? '') }}"
                class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500"
                placeholder="Ej: 2.5 MB, 150 KB">
            @error('file_size')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="reading_age" class="block text-sm font-medium text-gray-700 mb-1">
                Edad de Lectura
            </label>
            <input type="text" name="reading_age" id="reading_age"
                value="{{ old('reading_age', $book->details->reading_age ?? '') }}"
                class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500"
                placeholder="Ej: 12+, Adultos, Infantil">
            @error('reading_age')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>
    </div>

    <!-- Fecha de publicación -->
    <div>
        <label for="published_at" class="block text-sm font-medium text-gray-700 mb-1">
            Fecha de Publicación
        </label>
        <input type="date" name="published_at" id="published_at"
            value="{{ old('published_at', isset($book->published_at) ? $book->published_at->format('Y-m-d') : '') }}"
            class="w-full md:w-1/3 border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
        @error('published_at')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <!-- Campos de texto largos -->
    <div class="grid grid-cols-1 gap-6">
        <div>
            <label for="restrictions" class="block text-sm font-medium text-gray-700 mb-1">
                Restricciones y Limitaciones
            </label>
            <textarea name="restrictions" id="restrictions" rows="3"
                class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500"
                placeholder="Especifica restricciones de uso, distribución o acceso...">{{ old('restrictions', $book->details->restrictions ?? '') }}</textarea>
            @error('restrictions')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="notes" class="block text-sm font-medium text-gray-700 mb-1">
                Notas Internas
            </label>
            <textarea name="notes" id="notes" rows="2"
                class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500"
                placeholder="Notas para el personal administrativo...">{{ old('notes', $book->details->notes ?? '') }}</textarea>
            @error('notes')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>
    </div>

    <!-- Información de ayuda -->
    <div class="bg-gray-50 p-4 rounded-lg">
        <h5 class="text-sm font-medium text-gray-900 mb-2">¿Por qué son importantes los metadatos?</h5>
        <div class="text-sm text-gray-600 space-y-2">
            <p>Los metadatos mejoran:</p>
            <ul class="list-disc list-inside ml-4 space-y-1">
                <li><strong>Descubribilidad:</strong> Los usuarios encuentran más fácilmente el libro</li>
                <li><strong>Filtrado:</strong> Búsqueda por formato, tamaño, edad recomendada</li>
                <li><strong>Accesibilidad:</strong> Información sobre compatibilidad y requisitos</li>
                <li><strong>Gestión:</strong> Control interno y organización del catálogo</li>
            </ul>
        </div>
    </div>
</div>
