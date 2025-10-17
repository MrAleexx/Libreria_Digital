{{-- resources/views/admin/books/form/show-info.blade.php --}}
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <!-- Información Básica -->
    <div class="space-y-6">
        <div>
            <h3 class="text-lg font-medium text-gray-900 mb-4">Información Básica</h3>

            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Título</label>
                    <p class="mt-1 text-sm text-gray-900">{{ $book->title }}</p>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">ISBN</label>
                    <p class="mt-1 text-sm text-gray-900">{{ $book->isbn }}</p>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Editorial</label>
                    <p class="mt-1 text-sm text-gray-900">{{ $book->publisher->name ?? 'Sin editorial' }}</p>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Idioma</label>
                        <p class="mt-1 text-sm text-gray-900">{{ $book->language->native_name ?? 'Español' }}</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Año</label>
                        <p class="mt-1 text-sm text-gray-900">{{ $book->publication_year }}</p>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Páginas</label>
                        <p class="mt-1 text-sm text-gray-900">{{ $book->pages }}</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Tipo</label>
                        <p class="mt-1 text-sm text-gray-900">
                            @if ($book->book_type === 'digital')
                                <span
                                    class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                    Digital
                                </span>
                            @elseif($book->book_type === 'physical')
                                <span
                                    class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-orange-100 text-orange-800">
                                    Físico
                                </span>
                            @else
                                <span
                                    class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                                    Mixto
                                </span>
                            @endif
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Categorías -->
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Categorías</label>
            <div class="flex flex-wrap gap-2">
                @forelse($book->categories as $category)
                    <span
                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                        {{ $category->name }}
                    </span>
                @empty
                    <p class="text-sm text-gray-500">Sin categorías asignadas</p>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Información Digital -->
    <div class="space-y-6">
        <div>
            <h3 class="text-lg font-medium text-gray-900 mb-4">Configuración Digital</h3>

            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Nivel de Acceso</label>
                    <p class="mt-1 text-sm text-gray-900">
                        @if ($book->access_level === 'free')
                            <span
                                class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                Gratuito
                            </span>
                        @elseif($book->access_level === 'premium')
                            <span
                                class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                Premium
                            </span>
                        @else
                            <span
                                class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                Institucional
                            </span>
                        @endif
                    </p>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Copyright</label>
                    <p class="mt-1 text-sm text-gray-900">
                        @if ($book->copyright_status === 'copyrighted')
                            <span
                                class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                Con Copyright
                            </span>
                        @elseif($book->copyright_status === 'public_domain')
                            <span
                                class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                Dominio Público
                            </span>
                        @else
                            <span
                                class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                Creative Commons
                            </span>
                        @endif
                    </p>

                    @if ($book->license_type)
                        <p class="mt-1 text-sm text-gray-600">{{ $book->license_type }}</p>
                    @endif
                </div>

                <div class="grid grid-cols-3 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Estado</label>
                        <p class="mt-1">
                            @if ($book->is_active)
                                <span
                                    class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    Activo
                                </span>
                            @else
                                <span
                                    class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                    Inactivo
                                </span>
                            @endif
                        </p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Descargable</label>
                        <p class="mt-1">
                            @if ($book->downloadable)
                                <span
                                    class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    Sí
                                </span>
                            @else
                                <span
                                    class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                    No
                                </span>
                            @endif
                        </p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Destacado</label>
                        <p class="mt-1">
                            @if ($book->featured)
                                <span
                                    class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                    Sí
                                </span>
                            @else
                                <span
                                    class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                    No
                                </span>
                            @endif
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Archivos -->
        <div>
            <h3 class="text-lg font-medium text-gray-900 mb-4">Archivos</h3>

            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Portada</label>
                    @if ($book->cover_image)
                        <div class="mt-2 flex items-center space-x-3">
                            <img src="{{ Storage::url($book->cover_image) }}" alt="Portada"
                                class="h-16 w-12 object-cover rounded shadow">
                            <span class="text-sm text-green-600">✓ Portada cargada</span>
                        </div>
                    @else
                        <p class="mt-1 text-sm text-gray-500">Sin portada</p>
                    @endif
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Archivo PDF</label>
                    @if ($book->pdf_file)
                        <div class="mt-2 flex items-center space-x-3">
                            <i class="fas fa-file-pdf text-red-500 text-xl"></i>
                            <span class="text-sm text-green-600">✓ PDF cargado</span>
                        </div>
                    @else
                        <p class="mt-1 text-sm text-gray-500">Sin archivo PDF</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Descripción -->
@if ($book->details && $book->details->description)
    <div class="mt-6">
        <label class="block text-sm font-medium text-gray-700 mb-2">Descripción</label>
        <div class="prose prose-sm max-w-none">
            <p class="text-gray-900">{{ $book->details->description }}</p>
        </div>
    </div>
@endif
