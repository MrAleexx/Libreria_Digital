{{-- resources/views/admin/books/partials/form-sections/basic-info.blade.php --}}
<div class="bg-white rounded-lg border border-gray-200 p-6">
    <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
        <i class="fas fa-info-circle text-blue-500 mr-2"></i>
        Información Básica
    </h3>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
            <label for="title" class="block text-sm font-medium text-gray-700 mb-2 flex items-center">
                <i class="fas fa-heading text-gray-400 mr-2 text-xs"></i>
                Título *
            </label>
            <input type="text" id="title" name="title" required
                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500"
                value="{{ old('title', $book->title ?? '') }}">
            @error('title')
                <p class="text-red-500 text-sm mt-1 flex items-center">
                    <i class="fas fa-exclamation-circle mr-1"></i>
                    {{ $message }}
                </p>
            @enderror
        </div>

        {{-- NUEVO: Selección de Categorías --}}
        <div>
            <label for="categories" class="block text-sm font-medium text-gray-700 mb-2 flex items-center">
                <i class="fas fa-folder text-gray-400 mr-2 text-xs"></i>
                Categorías
            </label>
            <select id="categories" name="categories[]" multiple
                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500"
                size="4">
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}"
                        {{ in_array($category->id, old('categories', $book ? $book->categories->pluck('id')->toArray() : [])) ? 'selected' : '' }}>
                        {{ $category->name }}
                        @if ($category->parent)
                            ({{ $category->parent->name }})
                        @endif
                    </option>
                @endforeach
            </select>
            <p class="text-xs text-gray-500 mt-1 flex items-center">
                <i class="fas fa-info-circle mr-1"></i>
                Mantén presionado Ctrl (Cmd en Mac) para seleccionar múltiples categorías
            </p>
            @error('categories')
                <p class="text-red-500 text-sm mt-1 flex items-center">
                    <i class="fas fa-exclamation-circle mr-1"></i>
                    {{ $message }}
                </p>
            @enderror
        </div>
    </div>

    {{-- DESCRIPCIÓN MOVIDA AQUÍ - Ahora viene de book_details --}}
    <div class="mt-4">
        <label for="description" class="block text-sm font-medium text-gray-700 mb-2 flex items-center">
            <i class="fas fa-align-left text-gray-400 mr-2 text-xs"></i>
            Descripción
        </label>
        <textarea id="description" name="description" rows="4"
            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500">{{ old('description', $book->description ?? '') }}</textarea>
        @error('description')
            <p class="text-red-500 text-sm mt-1 flex items-center">
                <i class="fas fa-exclamation-circle mr-1"></i>
                {{ $message }}
            </p>
        @enderror
    </div>
</div>
