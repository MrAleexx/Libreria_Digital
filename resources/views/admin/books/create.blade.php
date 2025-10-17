{{-- resources/views/admin/books/create.blade.php --}}
@extends('admin.layout')

@section('title', 'Crear Nuevo Libro')
@section('subtitle', 'Agregar un nuevo libro al catálogo')

@section('content')
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-semibold flex items-center">
                <i class="fas fa-plus-circle text-orange-500 mr-2"></i>
                Crear Nuevo Libro
            </h3>
        </div>

        <div class="px-6 py-4">
            @include('admin.books.partials.form-layout', [
                'action' => route('admin.books.store'),
                'method' => 'POST',
                'book' => null,
                'categories' => $categories,
                'selectedCategories' => [],
            ])

            <div class="mt-8">
                @livewire('book-contributors-manager', ['book' => null], key('contributors-create'))
            </div>

            <div class="mt-8">
                @livewire('book-contents-manager', ['book' => null], key('contents-create'))
            </div>
        </div>
    </div>
@endsection
