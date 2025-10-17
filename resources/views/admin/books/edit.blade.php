{{-- resources/views/admin/books/edit.blade.php --}}
@extends('admin.layout')

@section('title', 'Editar Libro: ' . $book->title)
@section('subtitle', 'Modificar información del libro')

@section('content')
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-semibold flex items-center">
                <i class="fas fa-edit text-orange-500 mr-2"></i>
                Editar Libro: {{ $book->title }}
            </h3>
        </div>

        <div class="px-6 py-4">
            @include('admin.books.partials.form-layout', [
                'action' => route('admin.books.update', $book),
                'method' => 'PUT',
                'book' => $book,
                'categories' => $categories,
                'selectedCategories' => $book->categories->pluck('id')->toArray(),
            ])
        </div>
    </div>

    {{-- Componentes Livewire PARA EDICIÓN --}}
    <div class="mt-6 bg-white rounded-lg shadow overflow-hidden">
        @livewire('book-contributors-manager', ['book' => $book], key('contributors-' . $book->id))
    </div>

    <div class="mt-6 bg-white rounded-lg shadow overflow-hidden">
        @livewire('book-contents-manager', ['book' => $book], key('contents-' . $book->id))
    </div>
@endsection
