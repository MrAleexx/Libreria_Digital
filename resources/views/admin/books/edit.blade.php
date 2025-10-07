@extends('admin.layout')

@section('title', 'Editar Libro')
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
            ])

            <!-- Gestión de Contribuidores -->
            <div class="mt-8" wire:ignore>
                @livewire('book-contributors-manager', ['book' => $book], key('contributors-' . $book->id))
            </div>

            <!-- Gestión de Contenido -->
            <div class="mt-8" wire:ignore>
                @livewire('book-contents-manager', ['book' => $book], key('contents-' . $book->id))
            </div>
        </div>
    </div>
@endsection
