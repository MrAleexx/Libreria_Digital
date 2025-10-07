@extends('layouts.app')

@section('titulo', 'Página Principal')

@section('contenido')
    <section class="my-10">
        <h2 class="text-center text-2xl font-bold mb-10 uppercase">Nuestros Libros</h2>
        <x-book-list :books="$books" />
    </section>
@endsection
