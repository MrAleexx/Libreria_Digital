<div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
    <div class="bg-gray-50 p-4 rounded-lg">
        <h4 class="text-sm font-medium text-gray-500 flex items-center">
            <i class="fas fa-university text-gray-400 mr-2"></i>
            Editorial
        </h4>
        <p class="text-lg font-semibold mt-1">{{ $book->publisher }}</p>
    </div>

    <div class="bg-gray-50 p-4 rounded-lg">
        <h4 class="text-sm font-medium text-gray-500 flex items-center">
            <i class="fas fa-barcode text-gray-400 mr-2"></i>
            ISBN
        </h4>
        <p class="text-lg font-semibold mt-1">{{ $book->isbn }}</p>
    </div>

    <div class="bg-gray-50 p-4 rounded-lg">
        <h4 class="text-sm font-medium text-gray-500 flex items-center">
            <i class="fas fa-tag text-gray-400 mr-2"></i>
            Precio
        </h4>
        <p class="text-lg font-semibold text-green-600 mt-1">S/ {{ number_format($book->price, 2) }}</p>
    </div>

    <div class="bg-gray-50 p-4 rounded-lg">
        <h4 class="text-sm font-medium text-gray-500 flex items-center">
            <i class="fas fa-format text-gray-400 mr-2"></i>
            Formato Archivo
        </h4>
        <p class="text-lg font-semibold mt-1">{{ $book->file_format ?? 'PDF' }}</p>
    </div>

    <div class="bg-gray-50 p-4 rounded-lg">
        <h4 class="text-sm font-medium text-gray-500 flex items-center">
            <i class="fas fa-file-text text-gray-400 mr-2"></i>
            Páginas
        </h4>
        <p class="text-lg font-semibold mt-1">{{ $book->pages }}</p>
    </div>

    <div class="bg-gray-50 p-4 rounded-lg">
        <h4 class="text-sm font-medium text-gray-500 flex items-center">
            <i class="fas fa-language text-gray-400 mr-2"></i>
            Idioma
        </h4>
        <p class="text-lg font-semibold mt-1">
            @switch($book->language)
                @case('es')
                    Español
                @break

                @case('en')
                    English
                @break

                @case('fr')
                    Français
                @break

                @case('pt')
                    Português
                @break

                @default
                    {{ $book->language }}
            @endswitch
        </p>
    </div>

    <div class="bg-gray-50 p-4 rounded-lg">
        <h4 class="text-sm font-medium text-gray-500 flex items-center">
            <i class="fas fa-calendar-alt text-gray-400 mr-2"></i>
            Publicación
        </h4>
        <p class="text-lg font-semibold mt-1">{{ $book->publication->format('d/m/Y') }}</p>
    </div>

    <div class="bg-gray-50 p-4 rounded-lg">
        <h4 class="text-sm font-medium text-gray-500 flex items-center">
            <i class="fas fa-info-circle text-gray-400 mr-2"></i>
            Estado
        </h4>
        <p class="text-lg font-semibold mt-1">
            <span
                class="px-2 py-1 text-xs rounded-full
                {{ $book->is_new ? 'bg-green-100 text-green-800' : 'bg-blue-100 text-blue-800' }} flex items-center">
                <i class="fas {{ $book->is_new ? 'fa-star' : 'fa-book' }} mr-1"></i>
                {{ $book->is_new ? 'Nuevo' : 'Usado' }}
            </span>
        </p>
    </div>
</div>
