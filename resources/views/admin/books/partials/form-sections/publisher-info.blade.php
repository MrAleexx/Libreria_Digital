{{-- resources/views/admin/books/partials/form-sections/publisher-info.blade.php --}}
<div class="bg-white rounded-lg border border-gray-200 p-6">
    <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
        <i class="fas fa-building text-purple-500 mr-2"></i>
        Información Editorial
    </h3>

    <div class="grid grid-cols-1 gap-4">
        <div>
            <label for="publisher" class="block text-sm font-medium text-gray-700 mb-2 flex items-center">
                <i class="fas fa-university text-gray-400 mr-2 text-xs"></i>
                Editorial *
            </label>
            <input type="text" id="publisher" name="publisher" required
                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500"
                value="{{ old('publisher', $book->publisher ?? '') }}"> 
            @error('publisher')
                {{-- ← CORREGIDO: publisher --}}
                <p class="text-red-500 text-sm mt-1 flex items-center">
                    <i class="fas fa-exclamation-circle mr-1"></i>
                    {{ $message }}
                </p>
            @enderror
        </div>

        <div>
            <label for="publisher_address" class="block text-sm font-medium text-gray-700 mb-2 flex items-center">
                <i class="fas fa-map-marker-alt text-gray-400 mr-2 text-xs"></i>
                Dirección Editorial
            </label>
            <textarea id="publisher_address" name="publisher_address" rows="2"
                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500">{{ old('publisher_address', $book->publisher_address ?? '') }}</textarea>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label for="publisher_email" class="block text-sm font-medium text-gray-700 mb-2 flex items-center">
                    <i class="fas fa-envelope text-gray-400 mr-2 text-xs"></i>
                    Email Editorial
                </label>
                <input type="email" id="publisher_email" name="publisher_email"
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500"
                    value="{{ old('publisher_email', $book->publisher_email ?? '') }}">
            </div>

            <div>
                <label for="publisher_city" class="block text-sm font-medium text-gray-700 mb-2 flex items-center">
                    <i class="fas fa-city text-gray-400 mr-2 text-xs"></i>
                    Ciudad
                </label>
                <input type="text" id="publisher_city" name="publisher_city"
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500"
                    value="{{ old('publisher_city', $book->publisher_city ?? '') }}">
            </div>
        </div>
    </div>
</div>
