{{-- resources/views/admin/users/create.blade.php --}}
@extends('admin.layout')

@section('title', 'Crear Usuario')
@section('subtitle', 'Agregar nuevo usuario al sistema')

@section('content')
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-semibold">Crear Nuevo Usuario</h3>
        </div>

        <div class="px-6 py-4">
            <form action="{{ route('admin.users.store') }}" method="POST">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <!-- Información Personal -->
                    <div>
                        <h4 class="text-lg font-semibold mb-4 text-gray-800 border-b pb-2">Información Personal</h4>

                        <div class="mb-4">
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Nombres *</label>
                            <input type="text" id="name" name="name" required
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500"
                                value="{{ old('name') }}" placeholder="Ingresa los nombres">
                            @error('name')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="last_name" class="block text-sm font-medium text-gray-700 mb-2">Apellidos *</label>
                            <input type="text" id="last_name" name="last_name" required
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500"
                                value="{{ old('last_name') }}" placeholder="Ingresa los apellidos">
                            @error('last_name')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="dni" class="block text-sm font-medium text-gray-700 mb-2">DNI *</label>
                            <input type="text" id="dni" name="dni" required maxlength="8"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500"
                                value="{{ old('dni') }}" placeholder="8 dígitos">
                            @error('dni')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">Teléfono *</label>
                            <input type="tel" id="phone" name="phone" required maxlength="9"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500"
                                value="{{ old('phone') }}" placeholder="9 dígitos">
                            @error('phone')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Información de Cuenta -->
                    <div>
                        <h4 class="text-lg font-semibold mb-4 text-gray-800 border-b pb-2">Información de Cuenta</h4>

                        <div class="mb-4">
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email *</label>
                            <input type="email" id="email" name="email" required
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500"
                                value="{{ old('email') }}" placeholder="correo@ejemplo.com">
                            @error('email')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="institutional_email" class="block text-sm font-medium text-gray-700 mb-2">Email
                                Institucional</label>
                            <input type="email" id="institutional_email" name="institutional_email"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500"
                                value="{{ old('institutional_email') }}" placeholder="opcional">
                            @error('institutional_email')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="role" class="block text-sm font-medium text-gray-700 mb-2">Rol *</label>
                            <select id="role" name="role" required
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500">
                                <option value="user" {{ old('role') == 'user' ? 'selected' : '' }}>Usuario</option>
                                <option value="moderator" {{ old('role') == 'moderator' ? 'selected' : '' }}>Moderador
                                </option>
                                <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Administrador
                                </option>
                            </select>
                            @error('role')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <div class="flex items-center">
                                <input type="checkbox" id="send_credentials" name="send_credentials" value="1"
                                    class="rounded border-gray-300 text-orange-500 focus:ring-orange-500"
                                    {{ old('send_credentials') ? 'checked' : '' }}>
                                <label for="send_credentials" class="ml-2 text-sm text-gray-700">
                                    Enviar credenciales por email
                                </label>
                            </div>
                            <p class="text-xs text-gray-500 mt-1">
                                Se generará una contraseña temporal y se enviará al usuario
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Información Adicional -->
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6">
                    <h4 class="font-semibold text-blue-800 mb-2">📝 Información Importante</h4>
                    <ul class="text-sm text-blue-700 list-disc list-inside space-y-1">
                        <li>Se generará automáticamente una contraseña temporal</li>
                        <li>La contraseña temporal expirará en 7 días</li>
                        <li>El usuario deberá cambiar su contraseña en el primer acceso</li>
                        <li>El límite de descargas es de 5 libros por día</li>
                    </ul>
                </div>

                <div class="flex justify-end space-x-4">
                    <a href="{{ route('admin.users.index') }}"
                        class="bg-gray-300 text-gray-700 px-6 py-2 rounded-lg hover:bg-gray-400 transition-colors duration-200">
                        Cancelar
                    </a>
                    <button type="submit"
                        class="bg-orange-500 text-white px-6 py-2 rounded-lg hover:bg-orange-600 transition-colors duration-200 flex items-center">
                        <i class="fas fa-user-plus mr-2"></i>
                        Crear Usuario
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
