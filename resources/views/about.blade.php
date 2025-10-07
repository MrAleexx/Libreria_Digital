@extends('layouts.app')

@section('titulo', 'Página Principal')

@section('contenido')
    <div class="flex items-center justify-center my-15 px-3">
        <div class="w-full max-w-3xl">
            <h2 class="text-center text-2xl font-bold mb-8 uppercase">Sobre Nosotros</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 items-center">
                <img src="https://i.pinimg.com/736x/e1/80/5b/e1805bed40df039b34c6a3b7c4a9f2b6.jpg" alt="about">
                <div class="text-center space-y-2">
                    <p>En <span class="text-orange-600 font-medium">BookMart</span> creemos que cada libro tiene el poder de
                        transformar. Por eso creamos una plataforma sencilla y accesible donde encontrarás libros
                        electrónicos para todos los gustos y momentos.</p>
                    <p>Nuestra misión es acercar la lectura a más personas, ofreciendo un espacio seguro, práctico y siempre
                        actualizado, para que disfrutes de tus historias favoritas en cualquier lugar.</p>
                </div>
            </div>
        </div>
    </div>
@endsection
