{{-- resources/views/admin/books/index.blade.php --}}
@extends('admin.layout')

@section('title', 'Gestión de Libros')
@section('subtitle', 'Administra el catálogo de la biblioteca')

@section('content')
    <!-- Mensajes de éxito/error -->
    @if (session('success'))
        <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative">
            <div class="flex items-center">
                <i class="fas fa-check-circle mr-2"></i>
                <span class="font-medium">Éxito:</span>
                <span class="ml-2">{{ session('success') }}</span>
            </div>
        </div>
    @endif

    @if (session('error'))
        <div class="mb-6 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative">
            <div class="flex items-center">
                <i class="fas fa-exclamation-circle mr-2"></i>
                <span class="font-medium">Error:</span>
                <span class="ml-2">{{ session('error') }}</span>
            </div>
        </div>
    @endif

    <!-- Debug Info (solo en desarrollo) -->
    @if (config('app.debug'))
        <div class="mb-4 bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded">
            <div class="flex items-center">
                <i class="fas fa-bug mr-2"></i>
                <span class="font-medium">Modo Debug:</span>
                <span class="ml-2">Revisa la consola del navegador y los logs de Laravel</span>
            </div>
        </div>
    @endif

    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
            <h3 class="text-lg font-semibold flex items-center">
                <i class="fas fa-book text-blue-500 mr-2"></i>
                Biblioteca Digital - Catálogo de Libros
                <span class="ml-2 text-sm text-gray-500">(Total: {{ $books->total() }})</span>
            </h3>
            <a href="{{ route('admin.books.create') }}"
                class="bg-gradient-to-r from-blue-500 to-blue-600 text-white px-5 py-2.5 rounded-xl hover:shadow-lg transition-all duration-200 flex items-center space-x-2 font-medium shadow-sm hover:from-blue-600 hover:to-blue-700">
                <i class="fas fa-plus mr-2"></i>
                Nuevo Libro
            </a>
        </div>

        <div class="p-6">
            @if ($books->count() > 0)
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Libro
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Información
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Estado
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Acciones
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($books as $book)
                                <tr class="hover:bg-gray-50 transition-colors duration-150" id="book-{{ $book->id }}">
                                    <td class="px-6 py-4">
                                        <div class="flex items-center">
                                            @if ($book->cover_image)
                                                <x-book-image :image="$book->cover_image" :title="$book->title"
                                                    class="h-12 w-12 rounded-lg object-cover" />
                                            @else
                                                <div
                                                    class="h-12 w-12 rounded-lg bg-gray-200 flex items-center justify-center">
                                                    <i class="fas fa-book text-gray-400 text-lg"></i>
                                                </div>
                                            @endif
                                            <div class="ml-4">
                                                <div class="text-sm font-medium text-gray-900 line-clamp-2">
                                                    {{ $book->title }}
                                                </div>
                                                <div class="text-xs text-gray-500 mt-1">
                                                    ID: {{ $book->id }} | ISBN: {{ $book->isbn }}
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="space-y-1">
                                            <div class="text-xs">
                                                <span class="font-medium">Autor:</span>
                                                {{ $book->main_author ?? 'Sin autor' }}
                                            </div>
                                            <div class="text-xs">
                                                <span class="font-medium">Editorial:</span>
                                                {{ $book->publisher->name ?? 'Sin editorial' }}
                                            </div>
                                            <div class="text-xs">
                                                <span class="font-medium">Año:</span>
                                                {{ $book->publication_year }}
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="space-y-2">
                                            <!-- Estado Activo/Inactivo -->
                                            @if ($book->is_active)
                                                <span
                                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                    <i class="fas fa-check-circle mr-1"></i>
                                                    Activo
                                                </span>
                                            @else
                                                <span
                                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                                    <i class="fas fa-times-circle mr-1"></i>
                                                    Inactivo
                                                </span>
                                            @endif

                                            <!-- Tipo de Acceso -->
                                            <span
                                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                                @if ($book->access_level === 'free') bg-green-100 text-green-800
                                                @elseif($book->access_level === 'premium') bg-yellow-100 text-yellow-800
                                                @else bg-purple-100 text-purple-800 @endif">
                                                <i
                                                    class="fas 
                                                    @if ($book->access_level === 'free') fa-unlock 
                                                    @elseif($book->access_level === 'premium') fa-crown 
                                                    @else fa-building @endif mr-1">
                                                </i>
                                                {{ ucfirst($book->access_level) }}
                                            </span>

                                            <!-- Estadísticas -->
                                            <div class="text-xs text-gray-600">
                                                <div class="flex items-center space-x-2">
                                                    <span><i class="fas fa-eye"></i> {{ $book->total_views }}</span>
                                                    <span><i class="fas fa-download"></i>
                                                        {{ $book->total_downloads }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex space-x-2">
                                            <!-- Ver -->
                                            <a href="{{ route('admin.books.show', $book) }}"
                                                class="text-blue-600 hover:text-blue-900 flex items-center p-2 rounded hover:bg-blue-50 transition-colors"
                                                title="Ver detalles">
                                                <i class="fas fa-eye"></i>
                                            </a>

                                            <!-- Editar -->
                                            <a href="{{ route('admin.books.edit', $book) }}"
                                                class="text-green-600 hover:text-green-900 flex items-center p-2 rounded hover:bg-green-50 transition-colors"
                                                title="Editar">
                                                <i class="fas fa-edit"></i>
                                            </a>

                                            <!-- Eliminar -->
                                            <form action="{{ route('admin.books.destroy', $book) }}" method="POST"
                                                class="inline delete-book-form" data-book-id="{{ $book->id }}"
                                                data-book-title="{{ $book->title }}">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="text-red-600 hover:text-red-900 flex items-center p-2 rounded hover:bg-red-50 transition-colors delete-book-btn"
                                                    title="Eliminar">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Paginación -->
                <div class="mt-6">
                    {{ $books->links() }}
                </div>
            @else
                <div class="text-center py-12">
                    <div class="mx-auto w-24 h-24 bg-purple-100 rounded-full flex items-center justify-center mb-4">
                        <i class="fas fa-book-open text-purple-500 text-3xl"></i>
                    </div>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">La biblioteca está vacía</h3>
                    <p class="text-gray-500 mb-6">Comienza agregando el primer libro a tu catálogo digital.</p>
                    <a href="{{ route('admin.books.create') }}"
                        class="inline-flex items-center px-6 py-3 bg-purple-500 text-white rounded-lg hover:bg-purple-600 transition-colors duration-200 font-medium">
                        <i class="fas fa-plus mr-2"></i>
                        Crear Primer Libro
                    </a>
                </div>
            @endif
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            console.log('=== SISTEMA DE ELIMINACIÓN DE LIBROS INICIADO ===');

            const deleteForms = document.querySelectorAll('.delete-book-form');

            deleteForms.forEach(form => {
                form.addEventListener('submit', function(e) {
                    e.preventDefault();

                    const bookId = this.getAttribute('data-book-id');
                    const bookTitle = this.getAttribute('data-book-title');

                    console.log(`Intentando eliminar libro: ID ${bookId}, Título: "${bookTitle}"`);

                    // SweetAlert2 para confirmación
                    if (typeof Swal !== 'undefined') {
                        Swal.fire({
                            title: '¿Estás seguro?',
                            html: `Vas a eliminar el libro: <strong>"${bookTitle}"</strong><br><br>
                          <span class="text-sm text-red-600">Esta acción no se puede deshacer.</span>`,
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#d33',
                            cancelButtonColor: '#3085d6',
                            confirmButtonText: 'Sí, eliminar',
                            cancelButtonText: 'Cancelar',
                            reverseButtons: true,
                            backdrop: true,
                            allowOutsideClick: false
                        }).then((result) => {
                            if (result.isConfirmed) {
                                console.log(`Confirmado: Eliminando libro ID ${bookId}`);
                                this.submit();
                            } else {
                                console.log('Eliminación cancelada por el usuario');
                            }
                        });
                    } else {
                        // Fallback a confirm nativo
                        if (confirm(`¿Estás seguro de eliminar el libro: "${bookTitle}"?`)) {
                            console.log(`Confirmado: Eliminando libro ID ${bookId}`);
                            this.submit();
                        } else {
                            console.log('Eliminación cancelada por el usuario');
                        }
                    }
                });
            });

            // Debug: Mostrar info de todos los formularios
            console.log(`Encontrados ${deleteForms.length} formularios de eliminación`);
            deleteForms.forEach((form, index) => {
                const bookId = form.getAttribute('data-book-id');
                const bookTitle = form.getAttribute('data-book-title');
                console.log(`Formulario ${index + 1}: Libro ID ${bookId} - "${bookTitle}"`);
            });
        });
    </script>
@endpush

@push('styles')
    <style>
        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
    </style>
@endpush
