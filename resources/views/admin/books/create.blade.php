{{-- resources/views/admin/books/create.blade.php --}}
@extends('admin.layout')

@section('title', 'Crear Nuevo Libro')

@section('content')
    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-yellow-50 border border-yellow-200 p-4 rounded-lg mb-6">
                <h4 class="font-bold text-yellow-800">DEBUG: Verificar datos del formulario</h4>
                <div class="mt-2 space-y-1 text-sm">
                    <div>Campos obligatorios:</div>
                    <div id="debug-fields" class="text-xs font-mono"></div>
                </div>
            </div>
            <!-- Navegación -->
            <div class="mb-6">
                <nav class="flex" aria-label="Breadcrumb">
                    <ol class="inline-flex items-center space-x-1 md:space-x-3">
                        <li class="inline-flex items-center">
                            <a href="{{ route('admin.books.index') }}"
                                class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600">
                                <i class="fas fa-book mr-2"></i>
                                Libros
                            </a>
                        </li>
                        <li aria-current="page">
                            <div class="flex items-center">
                                <i class="fas fa-chevron-right text-gray-400 mx-2"></i>
                                <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2">Nuevo Libro</span>
                            </div>
                        </li>
                    </ol>
                </nav>
            </div>

            <!-- Formulario -->
            <form action="{{ route('admin.books.store') }}" method="POST" enctype="multipart/form-data"
                x-data="{ activeTab: 'basic' }" id="book-form" novalidate>
                @csrf

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <!-- Header del formulario -->
                    <div class="p-6 bg-white border-b border-gray-200">
                        <div class="flex justify-between items-center">
                            <div>
                                <h3 class="text-lg font-medium text-gray-900">Información del Libro</h3>
                                <p class="text-sm text-gray-600">Completa la información básica del libro</p>
                            </div>
                            <div class="flex space-x-3">
                                <a href="{{ route('admin.books.index') }}"
                                    class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150">
                                    <i class="fas fa-arrow-left mr-2"></i>
                                    Cancelar
                                </a>
                                <button type="submit"
                                    class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                    <i class="fas fa-save mr-2"></i>
                                    Guardar Libro
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Navegación por pestañas CORREGIDA -->
                    <div class="border-b border-gray-200">
                        <nav class="flex -mb-px overflow-x-auto">
                            <button type="button" @click="activeTab = 'basic'"
                                :class="activeTab === 'basic' ? 'border-blue-500 text-blue-600' :
                                    'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                                class="whitespace-nowrap py-4 px-4 border-b-2 font-medium text-sm">
                                <i class="fas fa-info-circle mr-2"></i>
                                Información Básica
                            </button>
                            <button type="button" @click="activeTab = 'digital'"
                                :class="activeTab === 'digital' ? 'border-blue-500 text-blue-600' :
                                    'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                                class="whitespace-nowrap py-4 px-4 border-b-2 font-medium text-sm">
                                <i class="fas fa-file-pdf mr-2"></i>
                                Archivos & Digital
                            </button>
                            <button type="button" @click="activeTab = 'physical'"
                                :class="activeTab === 'physical' ? 'border-blue-500 text-blue-600' :
                                    'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                                class="whitespace-nowrap py-4 px-4 border-b-2 font-medium text-sm">
                                <i class="fas fa-book mr-2"></i>
                                Sistema Físico
                            </button>
                            <button type="button" @click="activeTab = 'metadata'"
                                :class="activeTab === 'metadata' ? 'border-blue-500 text-blue-600' :
                                    'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                                class="whitespace-nowrap py-4 px-4 border-b-2 font-medium text-sm">
                                <i class="fas fa-tags mr-2"></i>
                                Metadatos
                            </button>
                            <button type="button" @click="activeTab = 'contributors'"
                                :class="activeTab === 'contributors' ? 'border-blue-500 text-blue-600' :
                                    'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                                class="whitespace-nowrap py-4 px-4 border-b-2 font-medium text-sm">
                                <i class="fas fa-users mr-2"></i>
                                Contribuidores
                            </button>
                            <button type="button" @click="activeTab = 'content'"
                                :class="activeTab === 'content' ? 'border-blue-500 text-blue-600' :
                                    'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                                class="whitespace-nowrap py-4 px-4 border-b-2 font-medium text-sm">
                                <i class="fas fa-list-ol mr-2"></i>
                                Índice/Contenido
                            </button>
                        </nav>
                    </div>

                    <!-- Contenido de las pestañas -->
                    <div class="p-6">
                        <!-- Pestaña: Información Básica -->
                        <div x-show="activeTab === 'basic'" x-transition>
                            @include('admin.books.form.form-basic')
                        </div>

                        <!-- Pestaña: Archivos & Digital (UNIFICADA) -->
                        <div x-show="activeTab === 'digital'" x-transition style="display: none;">
                            @include('admin.books.form.form-digital')
                        </div>

                        <!-- Pestaña: Sistema Físico -->
                        <div x-show="activeTab === 'physical'" x-transition style="display: none;">
                            @include('admin.books.form.form-physical')
                        </div>

                        <!-- Pestaña: Metadatos -->
                        <div x-show="activeTab === 'metadata'" x-transition style="display: none;">
                            @include('admin.books.form.form-metadata')
                        </div>

                        <!-- Pestaña: Contribuidores -->
                        <div x-show="activeTab === 'contributors'" x-transition style="display: none;">
                            @include('admin.books.form.form-contributors')
                        </div>

                        <!-- Pestaña: Índice/Contenido -->
                        <div x-show="activeTab === 'content'" x-transition style="display: none;">
                            @include('admin.books.form.form-content')
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Verificar que todos los campos obligatorios estén presentes
            const requiredFields = [
                'title', 'isbn', 'publisher_id', 'language_code',
                'publication_year', 'pages', 'book_type', 'access_level', 'copyright_status'
            ];

            const debugInfo = requiredFields.map(field => {
                const element = document.querySelector(`[name="${field}"]`);
                return `${field}: ${element ? '✓' : '✗'}`;
            }).join(' | ');

            document.getElementById('debug-fields').textContent = debugInfo;

            // Debug del formulario al enviar
            document.querySelector('form').addEventListener('submit', function(e) {
                console.log('=== ENVIANDO FORMULARIO ===');
                const formData = new FormData(this);
                for (let [key, value] of formData.entries()) {
                    console.log(`${key}:`, value);
                }
            });
        });

        function toggleLicenseField(copyrightStatus) {
            const licenseField = document.getElementById('license_field');
            if (copyrightStatus === 'creative_commons') {
                licenseField.style.display = 'block';
            } else {
                licenseField.style.display = 'none';
                document.getElementById('license_type').value = '';
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            const copyrightStatus = document.getElementById('copyright_status');
            if (copyrightStatus) {
                toggleLicenseField(copyrightStatus.value);
            }
        });

        document.addEventListener('DOMContentLoaded', function() {
            const form = document.querySelector('form');

            form.addEventListener('submit', function(e) {
                // Verificación simple - si no hay preview de portada, prevenir envío
                const coverPreview = document.querySelector('img[alt="Vista previa de la portada"]');
                const coverInput = document.getElementById('coverImageInput');

                if (!coverPreview && (!coverInput || !coverInput.files.length)) {
                    e.preventDefault();
                    alert('⚠️ Debes seleccionar una portada para el libro antes de guardar.');
                    return false;
                }
            });
        });
    </script>
@endpush
