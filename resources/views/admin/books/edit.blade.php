{{-- resources/views/admin/books/edit.blade.php --}}
@extends('admin.layout')

@section('title', 'Editar Libro: ' . Str::limit($book->title, 30))

@section('content')
    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
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
                        <li>
                            <div class="flex items-center">
                                <i class="fas fa-chevron-right text-gray-400 mx-2"></i>
                                <a href="{{ route('admin.books.show', $book) }}"
                                    class="ml-1 text-sm font-medium text-gray-700 hover:text-blue-600 md:ml-2">
                                    {{ Str::limit($book->title, 30) }}
                                </a>
                            </div>
                        </li>
                        <li aria-current="page">
                            <div class="flex items-center">
                                <i class="fas fa-chevron-right text-gray-400 mx-2"></i>
                                <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2">Editar</span>
                            </div>
                        </li>
                    </ol>
                </nav>
            </div>

            <!-- Alertas -->
            @if (session('success'))
                <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-lg">
                    <div class="flex items-center">
                        <i class="fas fa-check-circle text-green-500 mr-3"></i>
                        <span class="text-green-800">{{ session('success') }}</span>
                    </div>
                </div>
            @endif

            @if ($errors->any())
                <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-lg">
                    <div class="flex items-center mb-2">
                        <i class="fas fa-exclamation-circle text-red-500 mr-3"></i>
                        <span class="text-red-800 font-medium">Error en el formulario</span>
                    </div>
                    <ul class="text-red-700 text-sm list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Formulario -->
            <form action="{{ route('admin.books.update', $book) }}" method="POST" enctype="multipart/form-data"
                x-data="{ activeTab: 'basic' }" id="book-form">
                @csrf
                @method('PUT')

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <!-- Header del formulario -->
                    <div class="p-6 bg-white border-b border-gray-200">
                        <div class="flex justify-between items-center">
                            <div>
                                <h3 class="text-lg font-medium text-gray-900">Editando: {{ $book->title }}</h3>
                                <p class="text-sm text-gray-600">Actualiza la información del libro</p>
                            </div>
                            <div class="flex space-x-3">
                                <a href="{{ route('admin.books.show', $book) }}"
                                    class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150">
                                    <i class="fas fa-eye mr-2"></i>
                                    Ver
                                </a>
                                <a href="{{ route('admin.books.index') }}"
                                    class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150">
                                    <i class="fas fa-arrow-left mr-2"></i>
                                    Cancelar
                                </a>
                                <button type="submit"
                                    class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                    <i class="fas fa-save mr-2"></i>
                                    Actualizar Libro
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Navegación por pestañas -->
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
                            @include('admin.books.form.form-basic', [
                                'book' => $book,
                                'categories' => $categories,
                                'publishers' => $publishers,
                                'languages' => $languages,
                            ])
                        </div>

                        <!-- Pestaña: Archivos & Digital -->
                        <div x-show="activeTab === 'digital'" x-transition style="display: none;">
                            @include('admin.books.form.form-digital', ['book' => $book])
                        </div>

                        <!-- Pestaña: Sistema Físico -->
                        <div x-show="activeTab === 'physical'" x-transition style="display: none;">
                            @include('admin.books.form.form-physical', ['book' => $book])
                        </div>

                        <!-- Pestaña: Metadatos -->
                        <div x-show="activeTab === 'metadata'" x-transition style="display: none;">
                            @include('admin.books.form.form-metadata', ['book' => $book])
                        </div>

                        <!-- Pestaña: Contribuidores -->
                        <div x-show="activeTab === 'contributors'" x-transition style="display: none;">
                            @livewire('book-contributors-manager', ['bookId' => $book->id])
                        </div>

                        <!-- Pestaña: Índice/Contenido -->
                        <div x-show="activeTab === 'content'" x-transition style="display: none;">
                            @livewire('book-contents-manager', ['bookId' => $book->id])
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
            const form = document.getElementById('book-form');

            form.addEventListener('submit', function(e) {
                console.log('=== ENVIANDO FORMULARIO DE ACTUALIZACIÓN ===');

                // Verificar datos del formulario
                const formData = new FormData(form);
                console.log('📦 Datos del formulario:');
                for (let [key, value] of formData.entries()) {
                    console.log(`${key}:`, value);
                }

                // Verificar archivos
                const coverFile = document.querySelector('input[name="cover_image"]').files[0];
                const pdfFile = document.querySelector('input[name="pdf_file"]').files[0];
                console.log('📁 Archivos:', {
                    'cover_image': coverFile ? coverFile.name : 'No file',
                    'pdf_file': pdfFile ? pdfFile.name : 'No file'
                });

                // Verificar campos de eliminación
                const deleteCover = document.getElementById('delete_cover');
                const deletePdf = document.getElementById('delete_pdf');
                console.log('🗑️  Campos de eliminación:', {
                    'delete_cover': deleteCover ? deleteCover.value : 'No existe',
                    'delete_pdf': deletePdf ? deletePdf.value : 'No existe'
                });

                // Verificar validación HTML
                const requiredFields = form.querySelectorAll('[required]');
                let invalidFields = [];

                requiredFields.forEach(field => {
                    if (!field.value.trim()) {
                        invalidFields.push(field.name);
                    }
                });

                if (invalidFields.length > 0) {
                    console.error('❌ Campos requeridos vacíos:', invalidFields);
                } else {
                    console.log('✅ Todos los campos requeridos están llenos');
                }

                console.log('=== FIN DEBUG FORMULARIO ===');
            });
        });

        // Inicializar el estado del campo de licencia
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
            // Inicializar el campo de licencia según el estado actual
            const copyrightStatus = document.getElementById('copyright_status');
            if (copyrightStatus) {
                toggleLicenseField(copyrightStatus.value);

                // Agregar event listener para cambios
                copyrightStatus.addEventListener('change', function() {
                    toggleLicenseField(this.value);
                });
            }

            // Mostrar pestaña activa al cargar
            const urlParams = new URLSearchParams(window.location.search);
            const tab = urlParams.get('tab');
            if (tab && ['basic', 'digital', 'physical', 'metadata', 'contributors', 'content'].includes(tab)) {
                document.querySelector('[x-data]').__x.$data.activeTab = tab;
            }

            // Debug: Verificar que los campos tengan valores
            console.log('=== DEBUG EDIT FORM ===');
            const fieldsToCheck = ['title', 'isbn', 'publisher_id', 'language_code', 'publication_year', 'pages'];
            fieldsToCheck.forEach(field => {
                const element = document.querySelector(`[name="${field}"]`);
                console.log(`${field}:`, element ? element.value : 'NOT FOUND');
            });
        });
    </script>
@endpush
