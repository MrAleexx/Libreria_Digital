@extends('layouts.app')

@section('titulo', 'Actualizar datos')

@section('contenido')
<div class="flex items-center justify-center my-15 px-3">
    <div class="grid grid-cols-1 gap-8 w-full max-w-5xl">
        <div class="w-full max-w-md mx-auto">
            <h1 class="text-center text-2xl font-bold mb-1">Actualiza tu información</h1>
            <p class="text-sm text-gray-600 text-center mb-6">
                Ingresa los datos que desees actualizar para mantener tu perfil al día.
            </p>

            <form class="w-full" action="{{ route('user.update', Auth::user()->id) }}" method="POST">
                @csrf
                @method('PUT')
                @if (session('mensaje'))
                    <p id="message" class="bg-green-500 text-white mb-3 rounded-lg text-sm p-2 text-center">{{ session('mensaje') }}</p>
                    <script>
                        setTimeout(() => {
                            const message = document.getElementById('message');
                            if (message) {
                                message.remove();
                            }
                        }, 3000);
                    </script>
                @endif
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="name" class="block mb-2 font-medium text-sm">
                            Nombres
                        </label>
                        <input 
                            id="name" 
                            name="name" 
                            type="text" 
                            placeholder="Pedro Cesar"
                            value="{{ auth()->user()->name }}"
                            class="w-full text-sm border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-orange-500 @error('name') border-red-500 @enderror"
                        />
                        @error('name')
                            <p class="text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="last_name" class="block mb-2 font-medium text-sm">
                            Apellidos
                        </label>
                        <input 
                            id="last_name" 
                            name="last_name" 
                            type="text" 
                            placeholder="San Julio"
                            value="{{ auth()->user()->last_name }}"
                            class="w-full text-sm border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-orange-500 @error('last_name') border-red-500 @enderror"
                        />
                        @error('last_name')
                            <p class="text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                    <div>
                        <label for="dni" class="block mb-2 font-medium text-sm">
                            DNI
                        </label>
                        <input 
                            id="dni" 
                            name="dni" 
                            type="text" 
                            placeholder="60606060"
                            value="{{ auth()->user()->dni }}"
                            class="w-full text-sm border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-orange-500 @error('dni') border-red-500 @enderror"
                        />
                        @error('dni')
                            <p class="text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="phone" class="block mb-2 font-medium text-sm">
                            Teléfono
                        </label>
                        <input 
                            id="phone" 
                            name="phone" 
                            type="tel" 
                            placeholder="987654321"
                            value="{{ auth()->user()->phone }}"
                            class="w-full text-sm border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-orange-500 @error('phone') border-red-500 @enderror"
                        />
                        @error('phone')
                            <p class="text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="mt-4">
                    <label for="email" class="block mb-2 font-medium text-sm">
                        Correo electrónico
                    </label>
                    <input 
                        id="email" 
                        name="email" 
                        type="email" 
                        placeholder="correo@correo.com"
                        value="{{ auth()->user()->email }}"
                        class="w-full text-sm border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-orange-500 @error('email') border-red-500 @enderror"
                    />
                    @error('email')
                        <p class="text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <button 
                    type="submit" 
                    class="cursor-pointer mt-6 text-sm font-medium shadow w-full bg-orange-500 text-white py-2.5 rounded-lg hover:bg-orange-600 transition-colors duration-300"
                >
                    Guardar cambios
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
