{{-- resources/views/admin/users/import.blade.php --}}
@extends('admin.layout')

@section('title', 'Importar Usuarios')
@section('subtitle', 'Importación masiva desde archivo Excel/CSV')

@section('content')
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <!-- Header -->
        <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
            <div>
                <h3 class="text-lg font-semibold">Importar Usuarios</h3>
                <p class="text-gray-600 text-sm">Agrega múltiples usuarios desde un archivo Excel o CSV</p>
            </div>
            <div class="flex space-x-2">
                <a href="{{ route('admin.users.index') }}"
                    class="bg-gray-300 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-400 transition-colors duration-200 flex items-center">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Volver a Usuarios
                </a>
            </div>
        </div>

        <!-- Alertas -->
        @if (session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mx-6 mt-4" role="alert">
                <div class="flex items-center">
                    <i class="fas fa-check-circle mr-2"></i>
                    <p class="font-semibold">{{ session('success') }}</p>
                </div>
            </div>
        @endif

        @if (session('error'))
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mx-6 mt-4" role="alert">
                <div class="flex items-center">
                    <i class="fas fa-exclamation-circle mr-2"></i>
                    <p class="font-semibold">{{ session('error') }}</p>
                </div>
            </div>
        @endif

        <div class="px-6 py-4">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Formulario de Importación -->
                <div class="lg:col-span-2">
                    <div class="card mb-6">
                        <div class="card-header">
                            <h3 class="card-title flex items-center">
                                <i class="fas fa-file-upload mr-2"></i>
                                Subir Archivo
                            </h3>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('admin.users.import') }}" method="POST" enctype="multipart/form-data"
                                id="importForm">
                                @csrf

                                <div class="mb-6">
                                    <label for="file" class="form-label">Seleccionar Archivo</label>
                                    <input type="file" name="file" id="file"
                                        class="form-control @error('file') is-invalid @enderror" accept=".csv,.xlsx,.xls"
                                        required>
                                    @error('file')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <div class="form-text">Formatos aceptados: CSV, XLSX, XLS (Máx. 10MB)</div>
                                </div>

                                <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6">
                                    <h4 class="font-semibold text-blue-800 mb-2 flex items-center">
                                        <i class="fas fa-info-circle mr-2"></i>
                                        Información Importante
                                    </h4>
                                    <ul class="text-sm text-blue-700 list-disc list-inside space-y-1">
                                        <li>Todos los usuarios se crearán con contraseñas temporales</li>
                                        <li>Las contraseñas temporales expiran en 7 días</li>
                                        <li>Los usuarios recibirán un email con sus credenciales</li>
                                        <li>El rol por defecto será "Usuario"</li>
                                        <li>El límite de descargas será de 5 libros por día</li>
                                    </ul>
                                </div>

                                <div class="flex items-center justify-between">
                                    <button type="submit" class="btn btn-primary" id="submitBtn">
                                        <i class="fas fa-upload mr-2"></i>
                                        Importar Usuarios
                                    </button>

                                    <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary">
                                        Cancelar
                                    </a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Información del Formato -->
                <div class="lg:col-span-1">
                    <div class="card sticky top-6">
                        <div class="card-header">
                            <h3 class="card-title flex items-center">
                                <i class="fas fa-table mr-2"></i>
                                Formato Requerido
                            </h3>
                        </div>
                        <div class="card-body">
                            <p class="text-gray-600 mb-4">El archivo debe contener las siguientes columnas (en cualquier
                                orden):</p>

                            <div class="space-y-3 mb-4">
                                <div class="flex items-center p-3 bg-gray-50 rounded-lg">
                                    <div
                                        class="w-8 h-8 bg-green-500 rounded-full flex items-center justify-center text-white text-sm font-semibold mr-3">
                                        1
                                    </div>
                                    <div>
                                        <span class="font-semibold text-gray-900">nombre</span>
                                        <span class="text-red-500 ml-1">*</span>
                                        <p class="text-xs text-gray-500">Nombre del usuario</p>
                                    </div>
                                </div>

                                <div class="flex items-center p-3 bg-gray-50 rounded-lg">
                                    <div
                                        class="w-8 h-8 bg-green-500 rounded-full flex items-center justify-center text-white text-sm font-semibold mr-3">
                                        2
                                    </div>
                                    <div>
                                        <span class="font-semibold text-gray-900">apellido</span>
                                        <span class="text-red-500 ml-1">*</span>
                                        <p class="text-xs text-gray-500">Apellido del usuario</p>
                                    </div>
                                </div>

                                <div class="flex items-center p-3 bg-gray-50 rounded-lg">
                                    <div
                                        class="w-8 h-8 bg-green-500 rounded-full flex items-center justify-center text-white text-sm font-semibold mr-3">
                                        3
                                    </div>
                                    <div>
                                        <span class="font-semibold text-gray-900">email</span>
                                        <span class="text-red-500 ml-1">*</span>
                                        <p class="text-xs text-gray-500">Correo electrónico único</p>
                                    </div>
                                </div>

                                <div class="flex items-center p-3 bg-gray-50 rounded-lg">
                                    <div
                                        class="w-8 h-8 bg-green-500 rounded-full flex items-center justify-center text-white text-sm font-semibold mr-3">
                                        4
                                    </div>
                                    <div>
                                        <span class="font-semibold text-gray-900">dni</span>
                                        <span class="text-red-500 ml-1">*</span>
                                        <p class="text-xs text-gray-500">DNI (8 dígitos, único)</p>
                                    </div>
                                </div>

                                <div class="flex items-center p-3 bg-gray-50 rounded-lg">
                                    <div
                                        class="w-8 h-8 bg-green-500 rounded-full flex items-center justify-center text-white text-sm font-semibold mr-3">
                                        5
                                    </div>
                                    <div>
                                        <span class="font-semibold text-gray-900">telefono</span>
                                        <span class="text-red-500 ml-1">*</span>
                                        <p class="text-xs text-gray-500">Teléfono (9 dígitos, único)</p>
                                    </div>
                                </div>
                            </div>

                            <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                                <h4 class="font-semibold text-yellow-800 mb-2 flex items-center">
                                    <i class="fas fa-lightbulb mr-2"></i>
                                    Nombres Alternativos
                                </h4>
                                <p class="text-sm text-yellow-700">
                                    El sistema acepta nombres alternativos para las columnas:
                                </p>
                                <ul class="text-xs text-yellow-600 list-disc list-inside mt-2 space-y-1">
                                    <li><strong>nombre</strong>: name, nombres</li>
                                    <li><strong>apellido</strong>: apellidos, last_name, lastname</li>
                                    <li><strong>email</strong>: correo, mail</li>
                                    <li><strong>dni</strong>: documento, document</li>
                                    <li><strong>telefono</strong>: teléfono, phone, celular</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Ejemplo de Archivo -->
            <div class="card mt-6">
                <div class="card-header">
                    <h3 class="card-title flex items-center">
                        <i class="fas fa-file-excel mr-2"></i>
                        Ejemplo de Archivo
                    </h3>
                </div>
                <div class="card-body">
                    <div class="overflow-x-auto">
                        <table class="min-w-full bg-white border border-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-4 py-2 border-b text-left text-sm font-medium text-gray-700">nombre</th>
                                    <th class="px-4 py-2 border-b text-left text-sm font-medium text-gray-700">apellido</th>
                                    <th class="px-4 py-2 border-b text-left text-sm font-medium text-gray-700">email</th>
                                    <th class="px-4 py-2 border-b text-left text-sm font-medium text-gray-700">dni</th>
                                    <th class="px-4 py-2 border-b text-left text-sm font-medium text-gray-700">telefono
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="px-4 py-2 border-b text-sm text-gray-600">Juan</td>
                                    <td class="px-4 py-2 border-b text-sm text-gray-600">Pérez García</td>
                                    <td class="px-4 py-2 border-b text-sm text-gray-600">juan.perez@email.com</td>
                                    <td class="px-4 py-2 border-b text-sm text-gray-600">12345678</td>
                                    <td class="px-4 py-2 border-b text-sm text-gray-600">987654321</td>
                                </tr>
                                <tr>
                                    <td class="px-4 py-2 border-b text-sm text-gray-600">María</td>
                                    <td class="px-4 py-2 border-b text-sm text-gray-600">Gonzales López</td>
                                    <td class="px-4 py-2 border-b text-sm text-gray-600">maria.gonzales@email.com</td>
                                    <td class="px-4 py-2 border-b text-sm text-gray-600">87654321</td>
                                    <td class="px-4 py-2 border-b text-sm text-gray-600">987654322</td>
                                </tr>
                                <tr>
                                    <td class="px-4 py-2 border-b text-sm text-gray-600">Carlos</td>
                                    <td class="px-4 py-2 border-b text-sm text-gray-600">Rodríguez Silva</td>
                                    <td class="px-4 py-2 border-b text-sm text-gray-600">carlos.rodriguez@email.com</td>
                                    <td class="px-4 py-2 border-b text-sm text-gray-600">56781234</td>
                                    <td class="px-4 py-2 border-b text-sm text-gray-600">987654323</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4 flex justify-between items-center">
                        <p class="text-sm text-gray-600">
                            💡 <strong>Tip:</strong> Puedes copiar esta estructura y pegarla en Excel o Google Sheets
                        </p>
                        <button type="button" onclick="downloadTemplate()"
                            class="bg-green-500 text-white px-4 py-2 rounded-lg hover:bg-green-600 transition-colors duration-200 flex items-center">
                            <i class="fas fa-download mr-2"></i>
                            Descargar Plantilla
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        // Mostrar loading al enviar el formulario
        document.getElementById('importForm').addEventListener('submit', function() {
            const submitBtn = document.getElementById('submitBtn');
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Importando...';
        });

        // Descargar plantilla de ejemplo
        function downloadTemplate() {
            const csvContent = "nombre,apellido,email,dni,telefono\n" +
                "Juan,Pérez García,juan.perez@email.com,12345678,987654321\n" +
                "María,Gonzales López,maria.gonzales@email.com,87654321,987654322\n" +
                "Carlos,Rodríguez Silva,carlos.rodriguez@email.com,56781234,987654323";

            const blob = new Blob([csvContent], {
                type: 'text/csv;charset=utf-8;'
            });
            const link = document.createElement('a');
            const url = URL.createObjectURL(blob);

            link.setAttribute('href', url);
            link.setAttribute('download', 'plantilla_usuarios.csv');
            link.style.visibility = 'hidden';

            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
        }

        // Validación de archivo antes de enviar
        document.getElementById('file').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const fileSize = file.size / 1024 / 1024; // MB
                const fileName = file.name.toLowerCase();
                const allowedExtensions = ['.csv', '.xlsx', '.xls'];
                const hasValidExtension = allowedExtensions.some(ext => fileName.endsWith(ext));

                if (!hasValidExtension) {
                    alert('Error: Solo se permiten archivos CSV, XLSX o XLS.');
                    e.target.value = '';
                    return;
                }

                if (fileSize > 10) {
                    alert('Error: El archivo no puede ser mayor a 10MB.');
                    e.target.value = '';
                    return;
                }
            }
        });
    </script>
@endpush

@push('styles')
    <style>
        .card {
            @apply bg-white border border-gray-200 rounded-lg;
        }

        .card-header {
            @apply px-6 py-4 border-b border-gray-200;
        }

        .card-title {
            @apply text-lg font-semibold text-gray-900;
        }

        .card-body {
            @apply p-6;
        }

        .form-label {
            @apply block text-sm font-medium text-gray-700 mb-2;
        }

        .form-control {
            @apply w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-orange-500;
        }

        .form-control.is-invalid {
            @apply border-red-500 focus:ring-red-500 focus:border-red-500;
        }

        .invalid-feedback {
            @apply text-red-500 text-sm mt-1;
        }

        .form-text {
            @apply text-sm text-gray-500 mt-1;
        }

        .btn {
            @apply px-4 py-2 rounded-lg font-medium transition-colors duration-200;
        }

        .btn-primary {
            @apply bg-orange-500 text-white hover:bg-orange-600;
        }

        .btn-outline-secondary {
            @apply bg-gray-300 text-gray-700 hover:bg-gray-400;
        }
    </style>
@endpush
