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
                                <option value="user" {{ old('role') == 'user' ? 'selected' : '' }}>Usuario Normal
                                </option>
                                <option value="librarian" {{ old('role') == 'librarian' ? 'selected' : '' }}>Bibliotecario
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

@push('modals')
    @if (session('show_password_modal') && session('temp_password'))
        <div id="passwordModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50"
            style="display: flex;">
            <div class="bg-white rounded-lg p-6 max-w-md w-full mx-4">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-green-600">
                        <i class="fas fa-check-circle mr-2"></i>
                        Usuario Creado Exitosamente
                    </h3>
                    <button onclick="closeModal()" class="text-gray-400 hover:text-gray-600">
                        <i class="fas fa-times"></i>
                    </button>
                </div>

                <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 mb-4">
                    <h4 class="font-semibold text-yellow-800 mb-2 flex items-center">
                        <i class="fas fa-key mr-2"></i>
                        Contraseña Temporal Generada
                    </h4>
                    <div class="flex items-center justify-between">
                        <code class="text-lg font-mono bg-yellow-100 px-3 py-2 rounded border flex-1 mr-2 text-center">
                            {{ session('temp_password') }}
                        </code>
                        <button onclick="copyPassword()"
                            class="bg-yellow-500 text-white px-3 py-2 rounded hover:bg-yellow-600 transition-colors flex items-center">
                            <i class="fas fa-copy mr-1"></i>
                            Copiar
                        </button>
                    </div>
                    <p class="text-sm text-yellow-700 mt-2">
                        ⚠️ <strong>Guarda esta contraseña ahora</strong>, no podrás verla nuevamente.
                    </p>
                </div>

                <div class="bg-blue-50 border border-blue-200 rounded-lg p-3 mb-4">
                    <p class="text-sm text-blue-700">
                        <strong>Información para el usuario:</strong><br>
                        • Email: {{ session('user_email') }}<br>
                        • Contraseña temporal: La mostrada arriba<br>
                        • Expira en: 7 días<br>
                        • Debe cambiar la contraseña en el primer acceso
                    </p>
                </div>

                <div class="flex justify-end space-x-3">
                    <button onclick="closeModal()"
                        class="bg-gray-300 text-gray-700 px-4 py-2 rounded hover:bg-gray-400 transition-colors">
                        Cerrar
                    </button>
                    <button onclick="copyAndClose()"
                        class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600 transition-colors flex items-center">
                        <i class="fas fa-copy mr-2"></i>
                        Copiar y Cerrar
                    </button>
                </div>
            </div>
        </div>

        <script>
            function closeModal() {
                document.getElementById('passwordModal').style.display = 'none';
                // Limpiar la sesión para que no reaparezca en recarga
                fetch('{{ route('admin.users.clear-temp-password') }}', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json'
                    }
                });
            }

            function copyPassword() {
                const password = '{{ session('temp_password') }}';
                navigator.clipboard.writeText(password).then(() => {
                    // Mostrar feedback visual
                    const btn = event.target;
                    const originalHTML = btn.innerHTML;
                    btn.innerHTML = '<i class="fas fa-check mr-1"></i>Copiada';
                    btn.classList.remove('bg-yellow-500', 'hover:bg-yellow-600');
                    btn.classList.add('bg-green-500', 'hover:bg-green-600');

                    setTimeout(() => {
                        btn.innerHTML = originalHTML;
                        btn.classList.remove('bg-green-500', 'hover:bg-green-600');
                        btn.classList.add('bg-yellow-500', 'hover:bg-yellow-600');
                    }, 2000);
                }).catch(err => {
                    console.error('Error al copiar: ', err);
                    // Fallback para navegadores antiguos
                    const tempInput = document.createElement('input');
                    tempInput.value = password;
                    document.body.appendChild(tempInput);
                    tempInput.select();
                    document.execCommand('copy');
                    document.body.removeChild(tempInput);

                    const btn = event.target;
                    const originalHTML = btn.innerHTML;
                    btn.innerHTML = '<i class="fas fa-check mr-1"></i>Copiada';
                    setTimeout(() => {
                        btn.innerHTML = originalHTML;
                    }, 2000);
                });
            }

            function copyAndClose() {
                copyPassword();
                setTimeout(closeModal, 1000);
            }

            // Cerrar modal con ESC
            document.addEventListener('keydown', function(event) {
                if (event.key === 'Escape') {
                    closeModal();
                }
            });

            // Cerrar modal haciendo click fuera
            document.getElementById('passwordModal').addEventListener('click', function(event) {
                if (event.target === this) {
                    closeModal();
                }
            });
        </script>
    @endif
@endpush
