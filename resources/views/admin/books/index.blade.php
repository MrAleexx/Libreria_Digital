{{-- resources/views/admin/books/index.blade.php --}}
@extends('admin.layout')

@section('title', 'Gestión de Libros')
@section('subtitle', 'Administra el catálogo de la biblioteca')

@section('content')
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
            <h3 class="text-lg font-semibold flex items-center">
                <i class="fas fa-book text-blue-500 mr-2"></i>
                Biblioteca Digital - Catálogo de Libros
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
                                    Categorías
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Acceso
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Estadísticas
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
                                <tr class="hover:bg-gray-50 transition-colors duration-150">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            @if ($book->image)
                                                {{-- Usa el componente book-image --}}
                                                <x-book-image :image="$book->image" :title="$book->title"
                                                    class="h-10 w-10 rounded-lg" defaultClass="h-10 w-10 rounded-lg" />
                                            @else
                                                <div
                                                    class="h-10 w-10 rounded-lg bg-gray-200 flex items-center justify-center">
                                                    <i class="fas fa-book text-gray-400"></i>
                                                </div>
                                            @endif
                                            <div class="ml-4">
                                                <div class="text-sm font-medium text-gray-900 line-clamp-1">
                                                    {{ $book->title }}
                                                </div>
                                                <div class="text-sm text-gray-500">
                                                    {{ $book->main_author }}
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex flex-wrap gap-1">
                                            @forelse($book->categories->take(2) as $category)
                                                <span
                                                    class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                    {{ $category->name }}
                                                </span>
                                            @empty
                                                <span class="text-gray-400 text-xs">Sin categorías</span>
                                            @endforelse
                                            @if ($book->categories->count() > 2)
                                                <span class="text-gray-500 text-xs">+{{ $book->categories->count() - 2 }}
                                                    más</span>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span
                                            class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium
                                            @if ($book->access_level === 'free') bg-green-100 text-green-800
                                            @elseif($book->access_level === 'premium') bg-yellow-100 text-yellow-800
                                            @else bg-purple-100 text-purple-800 @endif">
                                            <i
                                                class="fas
                                                @if ($book->access_level === 'free') fa-unlock mr-1
                                                @elseif($book->access_level === 'premium') fa-crown mr-1
                                                @else fa-building mr-1 @endif text-xs">
                                            </i>
                                            {{ ucfirst($book->access_level) }}
                                        </span>
                                        @if ($book->featured)
                                            <span
                                                class="ml-1 inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-orange-100 text-orange-800">
                                                <i class="fas fa-star mr-1 text-xs"></i>
                                                Destacado
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-xs text-gray-600 space-y-1">
                                            <div class="flex items-center">
                                                <i class="fas fa-eye text-blue-500 mr-1 text-xs"></i>
                                                <span>{{ $book->total_views }} vistas</span>
                                            </div>
                                            <div class="flex items-center">
                                                <i class="fas fa-download text-green-500 mr-1 text-xs"></i>
                                                <span>{{ $book->total_downloads }} descargas</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex flex-col space-y-1">
                                            @if ($book->active)
                                                <span
                                                    class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                    <i class="fas fa-check-circle mr-1 text-xs"></i>
                                                    Activo
                                                </span>
                                            @else
                                                <span
                                                    class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                                    <i class="fas fa-times-circle mr-1 text-xs"></i>
                                                    Inactivo
                                                </span>
                                            @endif

                                            @if ($book->is_new)
                                                <span
                                                    class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                                                    <i class="fas fa-star mr-1 text-xs"></i>
                                                    Nuevo
                                                </span>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <div class="flex space-x-2">
                                            <a href="{{ route('admin.books.show', $book) }}"
                                                class="text-blue-600 hover:text-blue-900 flex items-center"
                                                title="Ver detalles">
                                                <i class="fas fa-eye mr-1"></i>
                                            </a>
                                            <a href="{{ route('admin.books.edit', $book) }}"
                                                class="text-green-600 hover:text-green-900 flex items-center"
                                                title="Editar">
                                                <i class="fas fa-edit mr-1"></i>
                                            </a>
                                            <form action="{{ route('admin.books.destroy', $book) }}" method="POST"
                                                class="inline"
                                                onsubmit="return confirm('¿Estás seguro de eliminar este libro?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="text-red-600 hover:text-red-900 flex items-center"
                                                    title="Eliminar">
                                                    <i class="fas fa-trash mr-1"></i>
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

@push('styles')
    <style>
        .line-clamp-1 {
            display: -webkit-box;
            -webkit-line-clamp: 1;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
    </style>
@endpush
