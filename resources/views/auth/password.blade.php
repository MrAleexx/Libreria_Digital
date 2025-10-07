@extends('layouts.app')

@section('titulo', 'Iniciar Sesión')

@section('contenido')
    <div class="flex items-center justify-center my-15 px-3">
        <div class="w-full max-w-md">
            <h1 class="text-center text-2xl font-bold mb-2">Olvidaste tu contraseña?</h1>
            <p class="text-sm text-gray-600 text-center mb-6">Por favor, ingrese su dirección de correo electrónico para
                recibir el código de verificación.</p>

            <form class="w-full" action="{{ route('password.store') }}" method="POST">
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

                <div class="flex flex-col md:flex-row">
                    <button type="submit"
                        class="text-sm font-medium shadow mt-3 w-full bg-orange-500 text-white py-2.5 rounded-lg hover:bg-orange-600 transition-colors duration-300 cursor-pointer">
                        Enviar Código
                    </button>

                    <a href="{{ route('login') }}"
                        class="text-sm ml-0 md:ml-4 font-medium shadow-2xl text-center mt-3 w-full bg-gray-300 py-2.5 rounded-lg hover:bg-gray-400 transition-colors duration-300 cursor-pointer">
                        Cancelar
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection
