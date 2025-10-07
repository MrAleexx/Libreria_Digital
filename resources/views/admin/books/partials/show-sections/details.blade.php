<div class="grid grid-cols-1 md:grid-cols-3 gap-6">
    <!-- Imagen y Archivos -->
    <div class="md:col-span-1">
        @if ($book->image)
            <x-book-image :image="$book->image" :title="$book->title" class="w-full h-96 object-cover rounded-lg shadow mb-4" />
        @else
            <div class="w-full h-96 bg-gray-200 rounded-lg flex items-center justify-center mb-4">
                <i class="fas fa-book text-6xl text-gray-400"></i>
            </div>
        @endif

        <!-- Archivo PDF -->
        <div class="p-4 bg-gray-50 rounded-lg">
            <h4 class="text-sm font-medium text-gray-700 mb-2 flex items-center">
                <i class="fas fa-file-pdf text-red-500 mr-2"></i>
                Archivo Digital
            </h4>
            @if ($book->pdf_file)
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <i class="fas fa-file-pdf text-red-500 text-2xl mr-3"></i>
                        <div>
                            <p class="text-sm font-medium text-gray-900">PDF Disponible</p>
                            @if ($book->file_size)
                                <p class="text-xs text-gray-500">{{ $book->file_size }}</p>
                            @endif
                        </div>
                    </div>
                    <span class="px-2 py-1 text-xs bg-green-100 text-green-800 rounded-full flex items-center">
                        <i class="fas fa-check mr-1"></i>
                        Listo
                    </span>
                </div>
            @else
                <div class="text-center py-4">
                    <i class="fas fa-file-exclamation text-gray-400 text-xl mb-2"></i>
                    <p class="text-sm text-gray-500">No hay archivo PDF cargado</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Información Detallada -->
    <div class="md:col-span-2">
        <h2 class="text-2xl font-bold text-gray-900 mb-2">{{ $book->title }}</h2>
        <p class="text-lg text-gray-600 mb-6 flex items-center">
            <i class="fas fa-user text-gray-400 mr-2"></i>
            por {{ $book->getAllAuthorsAttribute() }}
        </p>

        <!-- Grid de Información -->
        @include('admin.books.partials.show-sections.info-grid', ['book' => $book])

        <!-- Descripción -->
        <div class="bg-gray-50 p-4 rounded-lg mb-6">
            <h4 class="text-sm font-medium text-gray-500 mb-2 flex items-center">
                <i class="fas fa-align-left text-gray-400 mr-2"></i>
                Descripción
            </h4>
            <p class="text-gray-700 leading-relaxed">{{ $book->description }}</p>
        </div>

        <!-- Información Adicional -->
        @include('admin.books.partials.show-sections.additional-info', ['book' => $book])
    </div>
</div>
