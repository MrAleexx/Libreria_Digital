{{-- resources/views/admin/books/index.blade.php --}}
@extends('admin.layout')

@section('title', 'Gestión de Libros')

@section('content')
    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Header con estadísticas y botones -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="flex justify-between items-center mb-6">
                        <div>
                            <h3 class="text-lg font-medium text-gray-900">Catálogo de Libros</h3>
                            <p class="text-sm text-gray-600">Gestiona todos los libros digitales y físicos</p>
                        </div>
                        <a href="{{ route('admin.books.create') }}"
                            class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            <i class="fas fa-plus mr-2"></i>
                            Nuevo Libro
                        </a>
                    </div>

                    <!-- Filtros rápidos -->
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-4">
                        <div class="bg-blue-50 p-4 rounded-lg">
                            <div class="text-blue-600 font-semibold">{{ $books->total() }}</div>
                            <div class="text-sm text-blue-800">Total Libros</div>
                        </div>
                        <div class="bg-green-50 p-4 rounded-lg">
                            <div class="text-green-600 font-semibold">{{ $books->where('book_type', 'digital')->count() }}
                            </div>
                            <div class="text-sm text-green-800">Digitales</div>
                        </div>
                        <div class="bg-orange-50 p-4 rounded-lg">
                            <div class="text-orange-600 font-semibold">{{ $books->where('book_type', 'physical')->count() }}
                            </div>
                            <div class="text-sm text-orange-800">Físicos</div>
                        </div>
                        <div class="bg-purple-50 p-4 rounded-lg">
                            <div class="text-purple-600 font-semibold">{{ $books->where('book_type', 'both')->count() }}
                            </div>
                            <div class="text-sm text-purple-800">Mixtos</div>
                        </div>
                    </div>
                </div>
            </div>


            <!-- Lista de libros -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Libro
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Tipo
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Estado
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Estadísticas
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Acciones
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($books as $book)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 h-10 w-10">
                                                <img class="h-10 w-10 rounded object-cover"
                                                    src="{{ $book->cover_image ? Storage::url($book->cover_image) : '/images/default-book.png' }}"
                                                    alt="{{ $book->title }}">
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-medium text-gray-900">
                                                    {{ Str::limit($book->title, 50) }}
                                                </div>
                                                <div class="text-sm text-gray-500">
                                                    {{ $book->isbn }}
                                                </div>
                                                <div class="text-xs text-gray-400">
                                                    {{ $book->publisher->name ?? 'Sin editorial' }}
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if ($book->book_type === 'digital')
                                            <span
                                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                Digital
                                            </span>
                                        @elseif($book->book_type === 'physical')
                                            <span
                                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-orange-100 text-orange-800">
                                                Físico
                                            </span>
                                        @else
                                            <span
                                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                                                Mixto
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="space-y-1">
                                            @if ($book->is_active)
                                                <span
                                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                    Activo
                                                </span>
                                            @else
                                                <span
                                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                                    Inactivo
                                                </span>
                                            @endif
                                            @if ($book->featured)
                                                <span
                                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                    Destacado
                                                </span>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        <div class="space-y-1">
                                            <div class="flex items-center">
                                                <i class="fas fa-download text-gray-400 mr-1"></i>
                                                <span>{{ $book->total_downloads }} descargas</span>
                                            </div>
                                            <div class="flex items-center">
                                                <i class="fas fa-eye text-gray-400 mr-1"></i>
                                                <span>{{ $book->total_views }} vistas</span>
                                            </div>
                                            @if (in_array($book->book_type, ['physical', 'both']))
                                                <div class="flex items-center">
                                                    <i class="fas fa-book text-gray-400 mr-1"></i>
                                                    <span>{{ $book->available_physical_copies }}/{{ $book->total_physical_copies }}
                                                        disp.</span>
                                                </div>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <div class="flex space-x-2">
                                            <a href="{{ route('admin.books.show', $book) }}"
                                                class="text-blue-600 hover:text-blue-900" title="Ver detalles">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('admin.books.edit', $book) }}"
                                                class="text-green-600 hover:text-green-900" title="Editar">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('admin.books.destroy', $book) }}" method="POST"
                                                class="inline"
                                                onsubmit="return confirm('¿Estás seguro de eliminar este libro?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900"
                                                    title="Eliminar">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-4 text-center text-gray-500">
                                        <div class="flex flex-col items-center justify-center py-8">
                                            <i class="fas fa-book-open text-4xl text-gray-300 mb-4"></i>
                                            <p class="text-lg font-medium text-gray-600">No se encontraron libros</p>
                                            <p class="text-sm text-gray-500 mt-2">Comienza agregando tu primer libro al
                                                catálogo</p>
                                            <a href="{{ route('admin.books.create') }}"
                                                class="mt-4 inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700">
                                                <i class="fas fa-plus mr-2"></i>
                                                Crear Primer Libro
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Paginación -->
                @if ($books->hasPages())
                    <div class="px-6 py-4 border-t border-gray-200">
                        {{ $books->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
