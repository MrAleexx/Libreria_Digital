{{-- resources/views/admin/books/partials/form-sections/identifiers.blade.php --}}
<div class="bg-white rounded-lg border border-gray-200 p-6">
    <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
        <i class="fas fa-fingerprint text-green-500 mr-2"></i>
        Identificadores
    </h3>

    <div class="grid grid-cols-1 gap-4">
        {{-- SOLO ISBN - Depósito Legal movido a detalles opcionales --}}
        <div>
            <label for="isbn" class="block text-sm font-medium text-gray-700 mb-2 flex items-center">
                <i class="fas fa-barcode text-gray-400 mr-2 text-xs"></i>
                ISBN *
            </label>
            <input type="text" id="isbn" name="isbn" required
                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500"
                value="{{ old('isbn', $book->isbn ?? '') }}" placeholder="Ej: 978-1234567890">
            @error('isbn')
                <p class="text-red-500 text-sm mt-1 flex items-center">
                    <i class="fas fa-exclamation-circle mr-1"></i>
                    {{ $message }}
                </p>
            @enderror
        </div>
    </div>
</div>
