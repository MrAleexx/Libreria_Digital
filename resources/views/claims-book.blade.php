@extends('layouts.app')

@section('titulo', 'Libro Reclamaciones')

@section('contenido')
    <div class="flex items-center justify-center my-15 px-3">
        <div class="w-full max-w-md">
            <h1 class="text-center text-2xl font-bold">Libro de Reclamaciones</h1>
            <p class="text-sm text-gray-600 text-center mb-6 mt-1.5">
                Por favor, ingresa un correo electrónico válido para que podamos contactarte.
            </p>
            <form class="w-full mt-4" action="{{ route('claims.store') }}" method="POST">
                @csrf
                @if (session('mensaje'))
                    <p id="message" class="bg-green-500 text-white mb-3 rounded-lg text-sm p-2 text-center">
                        {{ session('mensaje') }}</p>
                    <script>
                        setTimeout(() => {
                            const message = document.getElementById('message');
                            if (message) {
                                message.remove();
                            }
                        }, 3000);
                    </script>
                @endif
                <div class="grid grid-cols-1 md:grid-cols-2 md:gap-4">
                    <div class="mb-3">
                        <label for="name" class="block mb-2 font-medium text-sm">
                            Nombre
                        </label>
                        <input id="name" name="name" type="text" placeholder="Juan Jorge"
                            class="w-full text-sm border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-orange-500 @error('name') border-red-500 @enderror" />
                        @error('name')
                            <p class="text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="dni" class="block mb-2 font-medium text-sm">
                            Número de DNI
                        </label>
                        <input id="dni" name="dni" type="tel" placeholder="60606060"
                            class="w-full text-sm border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-orange-500 @error('dni') border-red-500 @enderror" />
                        @error('dni')
                            <p class="text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="mb-3">
                    <label for="email" class="block mb-2 font-medium text-sm">
                        Correo electrónico
                    </label>
                    <input id="email" name="email" type="text" placeholder="correo@correo.com"
                        class="w-full text-sm border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-orange-500 @error('email') border-red-500 @enderror" />
                    @error('email')
                        <p class="text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="tipo_reclamo" class="block mb-2 font-medium text-sm">
                        Tipo de Reclamo
                    </label>
                    <select id="tipo_reclamo" name="tipo_reclamo"
                        class="cursor-pointer w-full p-2 border rounded-lg text-sm">
                        <option value="">Seleccione una opción</option>
                        <option value="problema_descarga">Problema con la descarga</option>
                        <option value="cobro_indebido">Cobro indebido</option>
                        <option value="acceso_cuenta">Problema de acceso</option>
                        <option value="otro">Otro</option>
                    </select>
                    @error('tipo_reclamo')
                        <p class="text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="subject" class="block mb-2 font-medium text-sm">
                        Asunto
                    </label>
                    <input id="subject" name="subject" type="text" placeholder="Reclamo de ..."
                        class="w-full text-sm border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-orange-500 @error('subject') border-red-500 @enderror" />
                    @error('subject')
                        <p class="text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="description" class="block mb-2 font-medium text-sm">
                        Descripción
                    </label>
                    <textarea name="description" id="description"
                        class="w-full h-32 text-sm border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-orange-500 @error('description') border-red-500 @enderror"></textarea>
                    @error('description')
                        <p class="text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <button type="submit"
                    class="mt-3 w-full bg-orange-500 text-white py-2 rounded-lg hover:bg-orange-600 transition-colors duration-300 cursor-pointer">
                    Enviar Reclamo
                </button>
            </form>
        </div>
    </div>
@endsection
