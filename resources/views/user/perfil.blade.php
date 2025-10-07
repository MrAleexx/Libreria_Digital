@extends('layouts.app')

@section('titulo', 'Tu cuenta')

@section('contenido')
    <div class="flex flex-col items-center justify-center mt-15 px-3">
        <div class="w-full max-w-md">
            <h1 class="text-center text-2xl font-bold mb-6">Bienvenido, {{ Auth::user()->name }}</h1>
        </div>
        <div class="w-full max-w-4xl">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="block bg-white shadow-lg rounded-2xl p-6 hover:shadow-xl transition">
                    <div class="flex items-center mb-4">
                        <div class="bg-orange-100 p-3 rounded-full">
                            <svg xmlns="http://www.w3.org/2000/svg" 
                                class="h-6 w-6 text-orange-500" 
                                viewBox="0 0 24 24" fill="currentColor">
                                <path d="M12 2a5 5 0 1 1 -5 5l.005 -.217a5 5 0 0 1 4.995 -4.783z"/>
                                <path d="M14 14a5 5 0 0 1 5 5v1a2 2 0 0 1 -2 2h-10a2 2 0 0 1 -2 -2v-1a5 5 0 0 1 5 -5h4z"/>
                            </svg>
                        </div>
                        <h2 class="ml-3 text-xl font-semibold text-gray-800">Mi perfil</h2>
                    </div>
                    <p class="text-gray-600 mb-4">Consulta y edita tus datos básicos, cambia tu contraseña y mantén tu perfil siempre actualizado.</p>
                    <a href="{{ route('user.index') }}" class="inline-block px-4 py-2 text-sm font-medium text-white bg-orange-500 rounded-lg hover:bg-orange-600 transition">
                        Ver mi información
                    </a>
                </div>
                
                <div class="block bg-white shadow-lg rounded-2xl p-6 hover:shadow-xl transition">
                    <div class="flex items-center mb-4">
                        <div class="bg-orange-100 p-3 rounded-full">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="#F7941D"  class="icon icon-tabler icons-tabler-filled icon-tabler-book">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                <path d="M21.5 5.134a1 1 0 0 1 .493 .748l.007 .118v13a1 1 0 0 1 -1.5 .866a8 8 0 0 0 -7.5 -.266v-15.174a10 10 0 0 1 8.5 .708m-10.5 -.707l.001 15.174a8 8 0 0 0 -7.234 .117l-.327 .18l-.103 .044l-.049 .016l-.11 .026l-.061 .01l-.117 .006h-.042l-.11 -.012l-.077 -.014l-.108 -.032l-.126 -.056l-.095 -.056l-.089 -.067l-.06 -.056l-.073 -.082l-.064 -.089l-.022 -.036l-.032 -.06l-.044 -.103l-.016 -.049l-.026 -.11l-.01 -.061l-.004 -.049l-.002 -13.068a1 1 0 0 1 .5 -.866a10 10 0 0 1 8.5 -.707" />
                            </svg>
                        </div>
                        <h2 class="ml-3 text-xl font-semibold text-gray-800">Mis libros</h2>
                    </div>
                    <p class="text-gray-600 mb-4">Revisa tu biblioteca digital personal y descarga en cualquier momento los libros que ya compraste.</p>
                    <a href="{{ route('book.index') }}" class="inline-block px-4 py-2 text-sm font-medium text-white bg-orange-500 rounded-lg hover:bg-orange-600 transition">
                        Ver mis libros
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection