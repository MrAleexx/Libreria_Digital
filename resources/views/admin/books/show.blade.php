@extends('admin.layout')

@section('title', 'Detalles del Libro')
@section('subtitle', 'Información completa del libro')

@section('content')
    <div class="space-y-6">
        <!-- Información Principal -->
        <div class="bg-white rounded-lg shadow overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
                <h3 class="text-lg font-semibold flex items-center">
                    <i class="fas fa-book text-orange-500 mr-2"></i>
                    Detalles del Libro
                </h3>
                <div class="flex space-x-2">
                    <a href="{{ route('admin.books.edit', $book) }}"
                        class="bg-green-500 text-white px-4 py-2 rounded-lg hover:bg-green-600 transition-colors duration-200 flex items-center">
                        <i class="fas fa-edit mr-2"></i>
                        Editar
                    </a>
                    <a href="{{ route('admin.books.index') }}"
                        class="bg-gray-300 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-400 transition-colors duration-200 flex items-center">
                        <i class="fas fa-arrow-left mr-2"></i>
                        Volver
                    </a>
                </div>
            </div>

            <div class="px-6 py-4">
                @include('admin.books.partials.show-sections.details', ['book' => $book])
            </div>
        </div>

        <!-- Contribuidores -->
        @if ($book->contributors->count() > 0)
            <div class="bg-white rounded-lg shadow overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-semibold flex items-center">
                        <i class="fas fa-users text-blue-500 mr-2"></i>
                        Contribuidores
                    </h3>
                </div>
                <div class="px-6 py-4">
                    @include('admin.books.partials.show-sections.contributors-list', [
                        'contributors' => $book->contributors,
                    ])
                </div>
            </div>
        @endif

        <!-- Contenido/Índice -->
        @if ($book->contents->count() > 0)
            <div class="bg-white rounded-lg shadow overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-semibold flex items-center">
                        <i class="fas fa-list-ol text-green-500 mr-2"></i>
                        Índice del Libro
                    </h3>
                </div>
                <div class="px-6 py-4">
                    @include('admin.books.partials.show-sections.contents-list', [
                        'contents' => $book->contents,
                    ])
                </div>
            </div>
        @endif
    </div>
@endsection
