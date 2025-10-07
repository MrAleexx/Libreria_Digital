{{-- resource/views/admin/books/partials/show-sections/additional-info.blade.php --}}
<div class="space-y-4">
    <!-- Identificadores Adicionales -->
    @if ($book->isbn13 || $book->deposito_legal)
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            @if ($book->isbn13)
                <div class="bg-orange-50 p-4 rounded-lg">
                    <h4 class="text-sm font-medium text-orange-700 flex items-center">
                        <i class="fas fa-barcode text-orange-600 mr-2"></i>
                        ISBN-13
                    </h4>
                    <p class="text-sm font-semibold text-orange-900 mt-1">{{ $book->isbn13 }}</p>
                </div>
            @endif

            @if ($book->deposito_legal)
                <div class="bg-orange-50 p-4 rounded-lg">
                    <h4 class="text-sm font-medium text-orange-700 flex items-center">
                        <i class="fas fa-file-alt text-orange-600 mr-2"></i>
                        Depósito Legal
                    </h4>
                    <p class="text-sm font-semibold text-orange-900 mt-1">{{ $book->deposito_legal }}</p>
                </div>
            @endif
        </div>
    @endif

    <!-- Información Editorial -->
    @if ($book->publisher_address || $book->publisher_email)
        <div class="bg-gray-50 p-4 rounded-lg">
            <h4 class="text-sm font-medium text-gray-700 mb-3 flex items-center">
                <i class="fas fa-building text-gray-600 mr-2"></i>
                Información Editorial
            </h4>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                @if ($book->publisher_address)
                    <div>
                        <div class="text-gray-600 flex items-center">
                            <i class="fas fa-map-marker-alt mr-2"></i>
                            Dirección:
                        </div>
                        <div class="text-gray-900 mt-1">{{ $book->publisher_address }}</div>
                    </div>
                @endif

                @if ($book->publisher_email)
                    <div>
                        <div class="text-gray-600 flex items-center">
                            <i class="fas fa-envelope mr-2"></i>
                            Email:
                        </div>
                        <div class="text-gray-900 mt-1">{{ $book->publisher_email }}</div>
                    </div>
                @endif

                @if ($book->publisher_city)
                    <div>
                        <div class="text-gray-600 flex items-center">
                            <i class="fas fa-city mr-2"></i>
                            Ciudad:
                        </div>
                        <div class="text-gray-900 mt-1">{{ $book->publisher_city }}</div>
                    </div>
                @endif

                @if ($book->edition && $book->edition != '1er')
                    <div>
                        <div class="text-gray-600 flex items-center">
                            <i class="fas fa-layer-group mr-2"></i>
                            Edición:
                        </div>
                        <div class="text-gray-900 mt-1">{{ $book->edition }}</div>
                    </div>
                @endif
            </div>
        </div>
    @endif

    <!-- Estados del Libro -->
    <div class="grid grid-cols-2 md:grid-cols-5 gap-4">
        <div
            class="text-center p-3 rounded-lg {{ $book->active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }} flex flex-col items-center">
            <i class="fas {{ $book->active ? 'fa-check-circle' : 'fa-times-circle' }} mb-1"></i>
            <div class="text-sm font-medium">{{ $book->active ? 'Activo' : 'Inactivo' }}</div>
        </div>
        <div
            class="text-center p-3 rounded-lg {{ $book->downloadable ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }} flex flex-col items-center">
            <i class="fas {{ $book->downloadable ? 'fa-download' : 'fa-ban' }} mb-1"></i>
            <div class="text-sm font-medium">{{ $book->downloadable ? 'Descargable' : 'No Descargable' }}</div>
        </div>
        <div
            class="text-center p-3 rounded-lg {{ $book->pre_order ? 'bg-blue-100 text-blue-800' : 'bg-gray-100 text-gray-800' }} flex flex-col items-center">
            <i class="fas {{ $book->pre_order ? 'fa-clock' : 'fa-check' }} mb-1"></i>
            <div class="text-sm font-medium">{{ $book->pre_order ? 'Pre-orden' : 'Disponible' }}</div>
        </div>
        <div
            class="text-center p-3 rounded-lg {{ $book->is_free ? 'bg-green-100 text-green-800' : 'bg-purple-100 text-purple-800' }} flex flex-col items-center">
            <i class="fas {{ $book->is_free ? 'fa-gift' : 'fa-tag' }} mb-1"></i>
            <div class="text-sm font-medium">{{ $book->is_free ? 'Gratuito' : 'De Pago' }}</div>
        </div>
        <div class="text-center p-3 rounded-lg bg-purple-100 text-purple-800 flex flex-col items-center">
            <i class="fas fa-file-pdf mb-1"></i>
            <div class="text-sm font-medium">{{ $book->file_format ?? 'PDF' }}</div>
        </div>
    </div>

    <!-- Información Temporal -->
    <div class="bg-gray-50 p-4 rounded-lg">
        <h4 class="text-sm font-medium text-gray-500 mb-3 flex items-center">
            <i class="fas fa-info-circle text-gray-400 mr-2"></i>
            Información Adicional
        </h4>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-sm">
            <div>
                <div class="text-gray-600 flex items-center">
                    <i class="fas fa-plus-circle mr-2"></i>
                    Creado:
                </div>
                <div class="text-gray-900 mt-1">{{ $book->created_at->format('d/m/Y H:i') }}</div>
            </div>

            <div>
                <div class="text-gray-600 flex items-center">
                    <i class="fas fa-edit mr-2"></i>
                    Actualizado:
                </div>
                <div class="text-gray-900 mt-1">{{ $book->updated_at->format('d/m/Y H:i') }}</div>
            </div>

            @if ($book->published_at)
                <div>
                    <div class="text-gray-600 flex items-center">
                        <i class="fas fa-rocket mr-2"></i>
                        Publicado:
                    </div>
                    <div class="text-gray-900 mt-1">{{ $book->published_at->format('d/m/Y H:i') }}</div>
                </div>
            @endif

            @if ($book->reading_age)
                <div>
                    <div class="text-gray-600 flex items-center">
                        <i class="fas fa-user-friends mr-2"></i>
                        Edad Lectura:
                    </div>
                    <div class="text-gray-900 mt-1">{{ $book->reading_age }}</div>
                </div>
            @endif
        </div>

        @if ($book->publication_url)
            <div class="mt-3 pt-3 border-t border-gray-200">
                <div class="text-gray-600 text-sm flex items-center">
                    <i class="fas fa-link mr-2"></i>
                    URL de Publicación:
                </div>
                <a href="{{ $book->publication_url }}" target="_blank"
                    class="text-blue-600 hover:text-blue-800 text-sm break-all flex items-center mt-1">
                    <i class="fas fa-external-link-alt mr-1"></i>
                    {{ $book->publication_url }}
                </a>
            </div>
        @endif
    </div>
</div>
