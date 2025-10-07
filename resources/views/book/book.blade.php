@extends('layouts.app')

@section('titulo', 'Mis Libros')

@section('contenido')
    <section class="my-10 container mx-auto px-3">
        <h2 class="text-center text-2xl font-bold mb-10 uppercase">Mis Libros Comprados</h2>

        @if (request()->has('success'))
            <x-success-message />
        @endif

        @if ($purchasedItems->count() > 0)
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-6" id="booksGrid">
                @foreach ($purchasedItems as $item)
                    <x-book-card :item="$item" />
                @endforeach
            </div>
        @else
            <x-empty-state />
        @endif
    </section>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Inicializar componentes
            if (document.getElementById('successMessage')) {
                new SuccessMessage();
            }

            if (document.getElementById('booksGrid')) {
                new BookCard();
            }
        });
    </script>
@endpush
