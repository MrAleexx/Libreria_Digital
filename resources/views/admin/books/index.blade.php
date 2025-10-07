@extends('admin.layout')

@section('title', 'Gestión de Libros')
@section('subtitle', 'Lista de todos los libros')

@section('content')
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
            <h3 class="text-lg font-semibold">Todos los Libros</h3>
            <a href="{{ route('admin.books.create') }}"
                class="bg-orange-500 text-white px-4 py-2 rounded-lg hover:bg-orange-600 transition-colors duration-200 flex items-center gap-2">
                <i class="fas fa-plus"></i>
                Nuevo Libro
            </a>
        </div>

        @if (session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mx-6 mt-4" role="alert">
                <p>{{ session('success') }}</p>
            </div>
        @endif

        <div class="px-6 py-4">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Título</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Autor
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Precio</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Estado</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($books as $book)
                            <tr class="hover:bg-gray-50 transition-colors duration-150">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                    #{{ $book->id }}</td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center">
                                        @if ($book->image)
                                            <x-book-image :image="$book->image" :title="$book->title"
                                                class="h-10 w-10 rounded-lg object-cover mr-3" />
                                        @else
                                            <div
                                                class="h-10 w-10 rounded-lg bg-gray-200 flex items-center justify-center mr-3">
                                                <i class="fas fa-book text-gray-400"></i>
                                            </div>
                                        @endif
                                        <div>
                                            <div class="font-medium text-gray-900 line-clamp-1">{{ $book->title }}</div>
                                            <div class="text-sm text-gray-500">{{ $book->publisher }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ $book->main_author ?? 'Sin autor' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    S/ {{ number_format($book->price, 2) }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if ($book->active)
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

                                    @if ($book->is_new)
                                        <span
                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 ml-1">
                                            <i class="fas fa-star mr-1"></i>
                                            Nuevo
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <div class="flex items-center space-x-3">
                                        <a href="{{ route('admin.books.show', $book) }}"
                                            class="text-blue-600 hover:text-blue-900 transition-colors duration-200 flex items-center gap-1"
                                            title="Ver detalles">
                                            <i class="fas fa-eye"></i>
                                            <span class="hidden sm:inline">Ver</span>
                                        </a>
                                        <a href="{{ route('admin.books.edit', $book) }}"
                                            class="text-green-600 hover:text-green-900 transition-colors duration-200 flex items-center gap-1"
                                            title="Editar libro">
                                            <i class="fas fa-edit"></i>
                                            <span class="hidden sm:inline">Editar</span>
                                        </a>
                                        <form action="{{ route('admin.books.destroy', $book) }}" method="POST"
                                            class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="text-red-600 hover:text-red-900 transition-colors duration-200 flex items-center gap-1"
                                                onclick="return confirm('¿Estás seguro de eliminar este libro?')"
                                                title="Eliminar libro">
                                                <i class="fas fa-trash"></i>
                                                <span class="hidden sm:inline">Eliminar</span>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-8 text-center">
                                    <div class="flex flex-col items-center justify-center text-gray-400">
                                        <i class="fas fa-book-open text-4xl mb-3"></i>
                                        <p class="text-lg font-medium text-gray-500">No hay libros registrados</p>
                                        <p class="text-sm text-gray-400 mt-1">Comienza agregando tu primer libro</p>
                                        <a href="{{ route('admin.books.create') }}"
                                            class="mt-4 bg-orange-500 text-white px-4 py-2 rounded-lg hover:bg-orange-600 transition-colors duration-200 flex items-center gap-2">
                                            <i class="fas fa-plus"></i>
                                            Crear primer libro
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if ($books->hasPages())
                <div class="px-6 py-4 border-t border-gray-200 bg-gray-50">
                    {{ $books->links() }}
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
