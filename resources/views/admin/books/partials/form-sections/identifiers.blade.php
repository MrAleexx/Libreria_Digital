{{-- resources/views/admin/books/partials/form-sections/identifiers.blade.php --}}
<div class="bg-white rounded-lg border border-gray-200 p-6">
    <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
        <i class="fas fa-fingerprint text-green-500 mr-2"></i>
        Identificadores
    </h3>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <div>
            <label for="isbn" class="block text-sm font-medium text-gray-700 mb-2 flex items-center">
                <i class="fas fa-barcode text-gray-400 mr-2 text-xs"></i>
                ISBN *
            </label>
            <input type="text" id="isbn" name="isbn" required
                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500"
                value="{{ old('isbn', $book->isbn ?? '') }}">
            @error('isbn')
                <p class="text-red-500 text-sm mt-1 flex items-center">
                    <i class="fas fa-exclamation-circle mr-1"></i>
                    {{ $message }}
                </p>
            @enderror
        </div>

        <div>
            <label for="isbn13" class="block text-sm font-medium text-gray-700 mb-2 flex items-center">
                <i class="fas fa-barcode text-gray-400 mr-2 text-xs"></i>
                ISBN-13
            </label>
            <input type="text" id="isbn13" name="isbn13"
                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500"
                value="{{ old('isbn13', $book->isbn13 ?? '') }}">
        </div>

        <div>
            <label for="deposito_legal" class="block text-sm font-medium text-gray-700 mb-2 flex items-center">
                <i class="fas fa-file-alt text-gray-400 mr-2 text-xs"></i>
                Depósito Legal
            </label>
            <input type="text" id="deposito_legal" name="deposito_legal"
                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500"
                value="{{ old('deposito_legal', $book->deposito_legal ?? '') }}">
        </div>
    </div>
</div>
