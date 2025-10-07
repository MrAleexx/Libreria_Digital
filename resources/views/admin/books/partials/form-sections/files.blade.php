{{-- resources/views/admin/books/partials/form-sections/files.blade.php --}}
<div class="bg-white rounded-lg border border-gray-200 p-6">
    <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
        <i class="fas fa-file-upload text-red-500 mr-2"></i>
        Archivos
    </h3>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Imagen -->
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2 flex items-center">
                <i class="fas fa-image text-gray-400 mr-2 text-xs"></i>
                {{ $book ? 'Imagen Actual' : 'Imagen de Portada *' }}


            @if ($book && $book->image)
                <div class="mb-3">
                    <x-book-image :image="$book->image" :title="$book->title" class="w-32 h-44 object-cover rounded-lg border" />
                </div>
            @endif

            <input type="file" id="image" name="image" {{ $book ? '' : 'required' }}
                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500"
                accept="image/*">
            @error('image')
                <p class="text-red-500 text-sm mt-1 flex items-center">
                    <i class="fas fa-exclamation-circle mr-1"></i>
                    {{ $message }}
                </p>
            @enderror
        </div>

        <!-- PDF -->
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2 flex items-center">
                <i class="fas fa-file-pdf text-gray-400 mr-2 text-xs"></i>
                {{ $book ? 'Archivo PDF Actual' : 'Archivo PDF *' }}


            @if ($book && $book->pdf_file)
                <div class="flex items-center mb-3 p-3 bg-gray-50 rounded-lg">
                    <i class="fas fa-file-pdf text-red-500 text-2xl mr-3"></i>
                    <div>
                        <p class="text-sm font-medium text-gray-900">PDF Disponible</p>
                        @if ($book->file_size)
                            <p class="text-xs text-gray-500">{{ $book->file_size }}</p>
                        @endif
                    </div>
                </div>
            @elseif($book)
                <div class="mb-3 p-3 bg-gray-100 rounded-lg text-center">
                    <i class="fas fa-file-exclamation text-gray-400 text-xl mb-2"></i>
                    <p class="text-sm text-gray-500">No hay PDF cargado</p>
                </div>
            @endif

            <input type="file" id="pdf_file" name="pdf_file" {{ $book ? '' : 'required' }}
                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500"
                accept=".pdf">
            <p class="text-xs text-gray-500 mt-1 flex items-center">
                <i class="fas fa-info-circle mr-1"></i>
                Formatos aceptados: PDF (máximo 10MB)
            </p>
            @error('pdf_file')
                <p class="text-red-500 text-sm mt-1 flex items-center">
                    <i class="fas fa-exclamation-circle mr-1"></i>
                    {{ $message }}
                </p>
            @enderror
        </div>
    </div>
</div>
