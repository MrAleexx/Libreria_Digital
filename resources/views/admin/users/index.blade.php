{{-- resources/views/admin/users/index.blade.php --}}
@extends('admin.layout')

@section('title', 'Gestión de Usuarios')
@section('subtitle', 'Lista de todos los usuarios')

@section('content')
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <!-- Header con Botones de Acción -->
        <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
            <div>
                <h3 class="text-lg font-semibold">Todos los Usuarios</h3>
                <p class="text-gray-600 text-sm">Gestiona los usuarios del sistema</p>
            </div>
            <div class="flex space-x-3">
                <a href="{{ route('admin.users.create') }}"
                    class="bg-green-500 text-white px-4 py-2 rounded-lg hover:bg-green-600 transition-colors duration-200 flex items-center">
                    <i class="fas fa-user-plus mr-2"></i>
                    Nuevo Usuario
                </a>
                <a href="{{ route('admin.users.import.form') }}"
                    class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 transition-colors duration-200 flex items-center">
                    <i class="fas fa-file-import mr-2"></i>
                    Importar
                </a>
            </div>
        </div>

        <!-- Alertas -->
        @if (session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mx-6 mt-4" role="alert">
                <p>{{ session('success') }}</p>
            </div>
        @endif

        @if (session('error'))
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mx-6 mt-4" role="alert">
                <p>{{ session('error') }}</p>
            </div>
        @endif

        @if (session('import_errors'))
            <div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4 mx-6 mt-4" role="alert">
                <h4 class="font-semibold mb-2">Errores en la Importación</h4>
                <ul class="list-disc list-inside text-sm">
                    @foreach (session('import_errors') as $error)
                        <li>
                            <strong>Fila {{ $error['row'] }}:</strong>
                            {{ implode(', ', $error['errors']) }}
                        </li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Contenido Principal -->
        <div class="px-6 py-4">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Usuario</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Contacto</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Rol</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Estado</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Descargas</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Creado por</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($users as $user)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div
                                            class="w-10 h-10 bg-orange-500 rounded-full flex items-center justify-center text-white font-semibold mr-3">
                                            {{ strtoupper(substr($user->name, 0, 1)) }}
                                        </div>
                                        <div>
                                            <div class="font-medium text-gray-900">{{ $user->name }}
                                                {{ $user->last_name }}</div>
                                            <div class="text-sm text-gray-500">DNI: {{ $user->dni }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ $user->email }}</div>
                                    <div class="text-sm text-gray-500">{{ $user->phone }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span
                                        class="px-2 py-1 text-xs font-semibold rounded-full
                                        {{ $user->role === 'admin'
                                            ? 'bg-purple-100 text-purple-800'
                                            : ($user->role === 'librarian'
                                                ? 'bg-blue-100 text-blue-800'
                                                : 'bg-green-100 text-green-800') }}">
                                        @if ($user->role === 'admin')
                                            Administrador
                                        @elseif($user->role === 'librarian')
                                            Bibliotecario
                                        @else
                                            Usuario
                                        @endif
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span
                                        class="px-2 py-1 text-xs font-semibold rounded-full
                                        {{ $user->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        {{ $user->is_active ? 'Activo' : 'Inactivo' }}
                                    </span>
                                    @if ($user->is_temp_password)
                                        <span
                                            class="ml-1 px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800"
                                            title="Contraseña temporal - Expira: {{ $user->temp_password_expires_at?->format('d/m/Y') }}">
                                            🔑 Temp
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm">
                                        <div class="flex items-center">
                                            <span class="text-gray-900 font-semibold">{{ $user->downloads_today }}/5</span>
                                            <span class="text-gray-500 text-xs ml-1">hoy</span>
                                        </div>
                                        <div class="text-gray-500 text-xs">
                                            Total: {{ $user->downloads_count ?? $user->downloads()->count() }}
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    @if ($user->creator)
                                        {{ $user->creator->name }}
                                        <div class="text-xs text-gray-400">
                                            {{ $user->created_at->format('d/m/Y') }}
                                        </div>
                                    @else
                                        <span class="text-gray-400">Sistema</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <div class="flex space-x-2">
                                        <a href="{{ route('admin.users.show', $user) }}"
                                            class="text-blue-600 hover:text-blue-900" title="Ver detalles">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.users.edit', $user) }}"
                                            class="text-green-600 hover:text-green-900" title="Editar">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="{{ route('admin.users.download-history', $user) }}"
                                            class="text-purple-600 hover:text-purple-900" title="Historial de descargas">
                                            <i class="fas fa-download"></i>
                                        </a>
                                        @if ($user->id !== auth()->id())
                                            <form action="{{ route('admin.users.toggle-status', $user) }}" method="POST"
                                                class="inline">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="text-orange-600 hover:text-orange-900"
                                                    title="{{ $user->is_active ? 'Desactivar' : 'Activar' }}">
                                                    <i
                                                        class="fas {{ $user->is_active ? 'fa-toggle-on' : 'fa-toggle-off' }}"></i>
                                                </button>
                                            </form>
                                            <form action="{{ route('admin.users.destroy', $user) }}" method="POST"
                                                class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900"
                                                    onclick="return confirm('¿Estás seguro de eliminar este usuario?')"
                                                    title="Eliminar">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-6 py-8 text-center text-gray-500">
                                    <i class="fas fa-users text-4xl text-gray-300 mb-2"></i>
                                    <p class="text-lg">No hay usuarios registrados</p>
                                    <p class="text-sm text-gray-400 mt-1">Comienza creando el primer usuario</p>
                                    <a href="{{ route('admin.users.create') }}"
                                        class="inline-block mt-3 bg-orange-500 text-white px-4 py-2 rounded-lg hover:bg-orange-600">
                                        <i class="fas fa-user-plus mr-2"></i>Crear Usuario
                                    </a>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if ($users->hasPages())
                <div class="px-6 py-4 border-t border-gray-200">
                    {{ $users->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection

@push('modals')
    @if (session('show_import_summary') && session('import_results'))
        <div id="importSummaryModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50"
            style="display: flex;">
            <div class="bg-white rounded-lg p-6 max-w-4xl w-full mx-4 max-h-[90vh] overflow-hidden flex flex-col">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-green-600">
                        <i class="fas fa-check-circle mr-2"></i>
                        Resumen de Importación
                    </h3>
                    <button onclick="closeImportModal()" class="text-gray-400 hover:text-gray-600">
                        <i class="fas fa-times"></i>
                    </button>
                </div>

                <div class="flex-1 overflow-y-auto">
                    <!-- Estadísticas -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                        <div class="bg-green-50 border border-green-200 rounded-lg p-4 text-center">
                            <div class="text-2xl font-bold text-green-600">
                                {{ session('import_results')['success_count'] }}</div>
                            <div class="text-sm text-green-700">Usuarios Creados</div>
                        </div>
                        <div class="bg-red-50 border border-red-200 rounded-lg p-4 text-center">
                            <div class="text-2xl font-bold text-red-600">{{ session('import_results')['error_count'] }}
                            </div>
                            <div class="text-sm text-red-700">Errores</div>
                        </div>
                        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 text-center">
                            <div class="text-2xl font-bold text-blue-600">
                                {{ count(session('import_results')['created_users']) }}</div>
                            <div class="text-sm text-blue-700">Con Contraseñas</div>
                        </div>
                    </div>

                    <!-- Lista de Usuarios Creados -->
                    <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 mb-4">
                        <h4 class="font-semibold text-yellow-800 mb-3 flex items-center">
                            <i class="fas fa-key mr-2"></i>
                            Contraseñas Temporales Generadas
                        </h4>
                        <p class="text-sm text-yellow-700 mb-3">
                            ⚠️ <strong>Descarga el reporte completo</strong> para tener acceso a todas las contraseñas.
                            Este listado solo muestra los primeros 5 usuarios.
                        </p>

                        <div class="overflow-x-auto">
                            <table class="min-w-full bg-white border border-yellow-200">
                                <thead>
                                    <tr class="bg-yellow-100">
                                        <th class="px-3 py-2 border-b text-left text-sm font-medium text-yellow-800">Nombre
                                        </th>
                                        <th class="px-3 py-2 border-b text-left text-sm font-medium text-yellow-800">Email
                                        </th>
                                        <th class="px-3 py-2 border-b text-left text-sm font-medium text-yellow-800">
                                            Contraseña</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach (array_slice(session('import_results')['created_users'], 0, 5) as $user)
                                        <tr>
                                            <td class="px-3 py-2 border-b text-sm text-gray-600">{{ $user['name'] }}</td>
                                            <td class="px-3 py-2 border-b text-sm text-gray-600">{{ $user['email'] }}</td>
                                            <td class="px-3 py-2 border-b text-sm">
                                                <code
                                                    class="bg-yellow-100 px-2 py-1 rounded border text-orange-600 font-mono">
                                                    {{ $user['temp_password'] }}
                                                </code>
                                            </td>
                                        </tr>
                                    @endforeach
                                    @if (count(session('import_results')['created_users']) > 5)
                                        <tr>
                                            <td colspan="3"
                                                class="px-3 py-2 border-b text-sm text-gray-500 text-center">
                                                ... y {{ count(session('import_results')['created_users']) - 5 }} usuarios
                                                más
                                            </td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Errores (si existen) -->
                    @if (session('import_results')['error_count'] > 0)
                        <div class="bg-red-50 border border-red-200 rounded-lg p-4">
                            <h4 class="font-semibold text-red-800 mb-2 flex items-center">
                                <i class="fas fa-exclamation-triangle mr-2"></i>
                                Errores Encontrados
                            </h4>
                            <p class="text-sm text-red-700 mb-2">
                                Se encontraron {{ session('import_results')['error_count'] }} errores durante la
                                importación.
                            </p>
                            <a href="{{ route('admin.users.import.form') }}"
                                class="text-blue-600 hover:text-blue-800 text-sm underline">
                                Ver detalles completos de errores
                            </a>
                        </div>
                    @endif
                </div>

                <div class="flex justify-between items-center pt-4 border-t border-gray-200">
                    <a href="{{ route('admin.users.import.download-report') }}"
                        class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600 transition-colors flex items-center">
                        <i class="fas fa-download mr-2"></i>
                        Descargar Reporte Completo
                    </a>

                    <div class="flex space-x-2">
                        <button onclick="closeImportModal()"
                            class="bg-gray-300 text-gray-700 px-4 py-2 rounded hover:bg-gray-400 transition-colors">
                            Cerrar
                        </button>
                        <a href="{{ route('admin.users.index') }}"
                            class="bg-orange-500 text-white px-4 py-2 rounded hover:bg-orange-600 transition-colors flex items-center">
                            <i class="fas fa-list mr-2"></i>
                            Ver Todos los Usuarios
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <script>
            function closeImportModal() {
                document.getElementById('importSummaryModal').style.display = 'none';
                // Limpiar la sesión
                fetch('{{ route('admin.users.clear-import-session') }}', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json'
                    }
                });
            }

            // Cerrar modal con ESC
            document.addEventListener('keydown', function(event) {
                if (event.key === 'Escape') {
                    closeImportModal();
                }
            });

            // Cerrar modal haciendo click fuera
            document.getElementById('importSummaryModal').addEventListener('click', function(event) {
                if (event.target === this) {
                    closeImportModal();
                }
            });
        </script>
    @endif
@endpush
