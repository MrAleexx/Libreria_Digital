@extends('layouts.app')

@section('titulo', 'Iniciar Sesión')

@section('contenido')
    <div class="flex items-center justify-center my-15 px-3">
        <div class="w-full max-w-md">
            <h1 class="text-center text-2xl font-bold mb-1">Recupera tu Cuenta</h1>
            <p class="text-sm text-gray-600 text-center mb-6">Por favor, ingresa tu nueva contraseña.</p>

            <form class="w-full" action="" method="POST">
                @csrf
                <input type="hidden" name="token" value="{{ $token }}">
                <input type="hidden" name="email" value="{{ $email }}">

                <div class="mb-3">
                    <label for="password" class="block mb-2 font-medium text-sm">
                        Contraseña
                    </label>
                    <input id="password" name="password" type="password" placeholder="******"
                        class="w-full text-sm border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-orange-500 @error('email') border-red-500 @enderror" />
                    @error('password')
                        <p class="text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="password_confirmation" class="block mb-2 font-medium text-sm">
                        Confirmar Contraseña
                    </label>
                    <input id="password_confirmation" name="password_confirmation" type="password" placeholder="******"
                        class="w-full text-sm border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-orange-500" />
                </div>

                <button type="submit"
                    class="text-sm font-medium shadow mt-3 w-full bg-orange-500 text-white py-2.5 rounded-lg hover:bg-orange-600 transition-colors duration-300 cursor-pointer">
                    Actualizar Contraseña
                </button>
            </form>
        </div>
    </div>
@endsection
