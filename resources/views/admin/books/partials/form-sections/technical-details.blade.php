{{-- resources/views/admin/books/partials/form-sections/technical-details.blade.php --}}
<div class="bg-white rounded-lg border border-gray-200 p-6">
    <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
        <i class="fas fa-cogs text-yellow-500 mr-2"></i>
        Detalles Técnicos
    </h3>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
        <!-- Idioma -->
        <div>
            <label for="language_code" class="block text-sm font-medium text-gray-700 mb-2 flex items-center">
                <i class="fas fa-language text-gray-400 mr-2 text-xs"></i>
                Idioma *
            </label>
            <select id="language_code" name="language_code" required
                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500">
                <option value="">Seleccionar</option>
                @foreach ($languages as $language)
                    <option value="{{ $language->code }}"
                        {{ old('language_code', $book->language_code ?? '') == $language->code ? 'selected' : '' }}>
                        {{ $language->native_name }} ({{ $language->name }})
                    </option>
                @endforeach
            </select>
            @error('language_code')
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

        <!-- Año de Publicación -->
        <div>
            <label for="publication_year" class="block text-sm font-medium text-gray-700 mb-2 flex items-center">
                <i class="fas fa-calendar text-gray-400 mr-2 text-xs"></i>
                Año Publicación *
            </label>
            <input type="number" id="publication_year" name="publication_year" min="1900" max="{{ date('Y') }}"
                required
                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500"
                value="{{ old('publication_year', $book->publication_year ?? '') }}" placeholder="{{ date('Y') }}">
            @error('publication_year')
                <p class="text-red-500 text-sm mt-1 flex items-center">
                    <i class="fas fa-exclamation-circle mr-1"></i>
                    {{ $message }}
                </p>
            @enderror
        </div>
    </div>

    <!-- Publicación en Plataforma -->
    <div class="mt-4">
        <label for="published_at" class="block text-sm font-medium text-gray-700 mb-2 flex items-center">
            <i class="fas fa-clock text-gray-400 mr-2 text-xs"></i>
            Publicación en Plataforma
        </label>
        <input type="datetime-local" id="published_at" name="published_at"
            class="w-full max-w-xs px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500"
            value="{{ old('published_at', $book && $book->published_at ? $book->published_at->format('Y-m-d\TH:i') : '') }}">
    </div>
</div>
