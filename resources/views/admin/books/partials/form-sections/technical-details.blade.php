{{-- resources/views/admin/books/partials/form-sections/technical-details.blade.php --}}
<div class="bg-white rounded-lg border border-gray-200 p-6">
    <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
        <i class="fas fa-cogs text-yellow-500 mr-2"></i>
        Detalles Técnicos
    </h3>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
        <!-- Idioma -->
        <div>
            <label for="language" class="block text-sm font-medium text-gray-700 mb-2 flex items-center">
                <i class="fas fa-language text-gray-400 mr-2 text-xs"></i>
                Idioma *
            </label>
            <select id="language" name="language" required
                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500">
                <option value="">Seleccionar</option>
                <option value="es" {{ old('language', $book->language ?? '') == 'es' ? 'selected' : '' }}>Español
                </option>
                <option value="en" {{ old('language', $book->language ?? '') == 'en' ? 'selected' : '' }}>English
                </option>
                <option value="fr" {{ old('language', $book->language ?? '') == 'fr' ? 'selected' : '' }}>Français
                </option>
                <option value="pt" {{ old('language', $book->language ?? '') == 'pt' ? 'selected' : '' }}>Português
                </option>
            </select>
            @error('language')
                <p class="text-red-500 text-sm mt-1 flex items-center">
                    <i class="fas fa-exclamation-circle mr-1"></i>
                    {{ $message }}
                </p>
            @enderror
        </div>

        <!-- Páginas -->
        <div>
            <label for="pages" class="block text-sm font-medium text-gray-700 mb-2 flex items-center">
                <i class="fas fa-file-text text-gray-400 mr-2 text-xs"></i>
                Páginas *
            </label>
            <input type="number" id="pages" name="pages" min="1" required
                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500"
                value="{{ old('pages', $book->pages ?? '') }}">
            @error('pages')
                <p class="text-red-500 text-sm mt-1 flex items-center">
                    <i class="fas fa-exclamation-circle mr-1"></i>
                    {{ $message }}
                </p>
            @enderror
        </div>

        <!-- Tamaño Archivo -->
        <div>
            <label for="file_size" class="block text-sm font-medium text-gray-700 mb-2 flex items-center">
                <i class="fas fa-weight text-gray-400 mr-2 text-xs"></i>
                Tamaño Archivo
            </label>
            <input type="text" id="file_size" name="file_size"
                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500"
                value="{{ old('file_size', $book->file_size ?? '') }}" placeholder="2.8 MB">
        </div>

        <!-- Formato -->
        <div>
            <label for="file_format" class="block text-sm font-medium text-gray-700 mb-2 flex items-center">
                <i class="fas fa-format text-gray-400 mr-2 text-xs"></i>
                Formato *
            </label>
            <select id="file_format" name="file_format" required
                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500">
                <option value="">Seleccionar</option>
                <option value="PDF" {{ old('file_format', $book->file_format ?? '') == 'PDF' ? 'selected' : '' }}>PDF
                </option>
                <option value="EPUB" {{ old('file_format', $book->file_format ?? '') == 'EPUB' ? 'selected' : '' }}>
                    EPUB</option>
                <option value="MOBI" {{ old('file_format', $book->file_format ?? '') == 'MOBI' ? 'selected' : '' }}>
                    MOBI</option>
            </select>
            @error('file_format')
                <p class="text-red-500 text-sm mt-1 flex items-center">
                    <i class="fas fa-exclamation-circle mr-1"></i>
                    {{ $message }}
                </p>
            @enderror
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-4">
        <!-- Fecha Publicación -->
        <div>
            <label for="publication" class="block text-sm font-medium text-gray-700 mb-2 flex items-center">
                <i class="fas fa-calendar-alt text-gray-400 mr-2 text-xs"></i>
                Fecha Publicación *
            </label>
            <input type="date" id="publication" name="publication" required
                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500"
                value="{{ old('publication', $book ? $book->publication->format('Y-m-d') : '') }}">
            @error('publication')
                <p class="text-red-500 text-sm mt-1 flex items-center">
                    <i class="fas fa-exclamation-circle mr-1"></i>
                    {{ $message }}
                </p>
            @enderror
        </div>

        <!-- Edición -->
        <div>
            <label for="edition" class="block text-sm font-medium text-gray-700 mb-2 flex items-center">
                <i class="fas fa-layer-group text-gray-400 mr-2 text-xs"></i>
                Edición *
            </label>
            <input type="text" id="edition" name="edition" required
                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500"
                value="{{ old('edition', $book->edition ?? '1er') }}" placeholder="1er">
            @error('edition')
                <p class="text-red-500 text-sm mt-1 flex items-center">
                    <i class="fas fa-exclamation-circle mr-1"></i>
                    {{ $message }}
                </p>
            @enderror
        </div>

        <!-- Publicación en Plataforma -->
        <div>
            <label for="published_at" class="block text-sm font-medium text-gray-700 mb-2 flex items-center">
                <i class="fas fa-clock text-gray-400 mr-2 text-xs"></i>
                Publicación en Plataforma
            </label>
            <input type="datetime-local" id="published_at" name="published_at"
                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500"
                value="{{ old('published_at', $book && $book->published_at ? $book->published_at->format('Y-m-d\TH:i') : '') }}">
        </div>
    </div>
</div>
