{{-- resources/views/admin/users/edit.blade.php --}}
@extends('admin.layout')

@section('title', 'Editar Usuario')
@section('subtitle', 'Modificar información del usuario')

@section('content')
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-semibold">Editar Usuario: {{ $user->name }}</h3>
        </div>

        <div class="px-6 py-4">
            <form action="{{ route('admin.users.update', $user) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <!-- Información Personal -->
                    <div>
                        <h4 class="text-lg font-semibold mb-4 text-gray-800 border-b pb-2">Información Personal</h4>

                        <div class="mb-4">
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Nombres *</label>
                            <input type="text" id="name" name="name" required
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500"
                                value="{{ old('name', $user->name) }}">
                            @error('name')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="last_name" class="block text-sm font-medium text-gray-700 mb-2">Apellidos *</label>
                            <input type="text" id="last_name" name="last_name" required
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500"
                                value="{{ old('last_name', $user->last_name) }}">
                            @error('last_name')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="dni" class="block text-sm font-medium text-gray-700 mb-2">DNI *</label>
                            <input type="text" id="dni" name="dni" required maxlength="8"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500"
                                value="{{ old('dni', $user->dni) }}">
                            @error('dni')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">Teléfono *</label>
                            <input type="tel" id="phone" name="phone" required maxlength="9"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500"
                                value="{{ old('phone', $user->phone) }}">
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
                                value="{{ old('email', $user->email) }}">
                            @error('email')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="institutional_email" class="block text-sm font-medium text-gray-700 mb-2">Email
                                Institucional</label>
                            <input type="email" id="institutional_email" name="institutional_email"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500"
                                value="{{ old('institutional_email', $user->institutional_email) }}"
                                placeholder="Opcional">
                            @error('institutional_email')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="role" class="block text-sm font-medium text-gray-700 mb-2">Rol *</label>
                            <select id="role" name="role" required
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500">
                                <option value="user" {{ old('role', $user->role) == 'user' ? 'selected' : '' }}>Usuario
                                    Normal</option>
                                <option value="librarian" {{ old('role', $user->role) == 'librarian' ? 'selected' : '' }}>
                                    Bibliotecario</option>
                                <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>
                                    Administrador</option>
                            </select>
                            @error('role')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <div class="flex items-center">
                                <input type="checkbox" id="is_active" name="is_active" value="1"
                                    class="rounded border-gray-300 text-orange-500 focus:ring-orange-500"
                                    {{ old('is_active', $user->is_active) ? 'checked' : '' }}>
                                <label for="is_active" class="ml-2 text-sm text-gray-700">
                                    Usuario activo
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Gestión de Contraseña -->
                <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 mb-6">
                    <h4 class="font-semibold text-yellow-800 mb-3 flex items-center">
                        <i class="fas fa-key mr-2"></i>
                        Gestión de Contraseña
                    </h4>

                    <div class="mb-4">
                        <div class="flex items-center mb-2">
                            <input type="checkbox" id="reset_temp_password" name="reset_temp_password" value="1"
                                class="rounded border-gray-300 text-orange-500 focus:ring-orange-500">
                            <label for="reset_temp_password" class="ml-2 text-sm text-yellow-700 font-medium">
                                Generar nueva contraseña temporal
                            </label>
                        </div>
                        <p class="text-xs text-yellow-600 ml-6">
                            El usuario recibirá una nueva contraseña temporal por email
                        </p>
                    </div>

                    <div class="space-y-3">
                        <div class="mb-4">
                            <label for="password" class="block text-sm font-medium text-yellow-700 mb-2">Nueva Contraseña
                                Permanente</label>
                            <input type="password" id="password" name="password"
                                class="w-full px-3 py-2 border border-yellow-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500"
                                placeholder="Dejar vacío para no cambiar">
                            @error('password')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="password_confirmation"
                                class="block text-sm font-medium text-yellow-700 mb-2">Confirmar Contraseña</label>
                            <input type="password" id="password_confirmation" name="password_confirmation"
                                class="w-full px-3 py-2 border border-yellow-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500"
                                placeholder="Confirmar nueva contraseña">
                        </div>
                    </div>
                </div>

                <div class="flex justify-end space-x-4">
                    <a href="{{ route('admin.users.show', $user) }}"
                        class="bg-gray-300 text-gray-700 px-6 py-2 rounded-lg hover:bg-gray-400 transition-colors duration-200">
                        Cancelar
                    </a>
                    <button type="submit"
                        class="bg-orange-500 text-white px-6 py-2 rounded-lg hover:bg-orange-600 transition-colors duration-200 flex items-center">
                        <i class="fas fa-save mr-2"></i>
                        Actualizar Usuario
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const resetTempPassword = document.getElementById('reset_temp_password');
            const passwordField = document.getElementById('password');
            const passwordConfirmField = document.getElementById('password_confirmation');

            resetTempPassword.addEventListener('change', function() {
                if (this.checked) {
                    passwordField.value = '';
                    passwordConfirmField.value = '';
                    passwordField.disabled = true;
                    passwordConfirmField.disabled = true;
                    passwordField.placeholder = 'Deshabilitado - Se usará contraseña temporal';
                    passwordConfirmField.placeholder = 'Deshabilitado - Se usará contraseña temporal';
                } else {
                    passwordField.disabled = false;
                    passwordConfirmField.disabled = false;
                    passwordField.placeholder = 'Dejar vacío para no cambiar';
                    passwordConfirmField.placeholder = 'Confirmar nueva contraseña';
                }
            });
        });
    </script>
@endpush
