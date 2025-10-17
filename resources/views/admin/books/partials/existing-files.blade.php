{{-- resources/views/admin/books/partials/existing-files.blade.php --}}
@props(['book' => null])

<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    <!-- Portada Existente -->
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-2">
            Portada del Libro <span class="text-red-600">*</span>
        </label>

        <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md">
            <div class="space-y-1 text-center w-full">
                @if ($book && $book->cover_image)
                    <!-- Portada existente -->
                    <div class="mb-4">
                        <img src="{{ asset('storage/' . $book->cover_image) }}" alt="Portada actual"
                            class="mx-auto h-32 w-auto object-contain rounded shadow">
                        <p class="text-xs text-gray-500 mt-2">Portada actual</p>
                        <div class="mt-2 space-y-2">
                            <label
                                class="relative cursor-pointer bg-white rounded-md font-medium text-blue-600 hover:text-blue-500 transition-colors text-sm">
                                <span class="px-3 py-1 border border-blue-600 rounded">Cambiar imagen</span>
                                <input type="file" class="sr-only" accept="image/*" name="cover_image"
                                    @change="handleCoverImageSelect($event)">
                            </label>
                            <button type="button" onclick="confirmDeleteCover()"
                                class="text-red-600 hover:text-red-800 text-sm transition-colors">
                                <i class="fas fa-trash mr-1"></i>Eliminar
                            </button>
                        </div>
                    </div>
                @else
                    <!-- Sin portada - permitir subir -->
                    <div class="py-4">
                        <i class="fas fa-image text-gray-400 text-3xl mx-auto mb-3"></i>
                        <div class="flex text-sm text-gray-600 justify-center flex-col space-y-2">
                            <label
                                class="relative cursor-pointer bg-white rounded-md font-medium text-blue-600 hover:text-blue-500 transition-colors">
                                <span class="px-3 py-1 border border-blue-600 rounded">Seleccionar imagen</span>
                                <input type="file" class="sr-only" accept="image/*" name="cover_image"
                                    @change="handleCoverImageSelect($event)" required>
                            </label>
                            <p class="text-xs text-gray-500">o arrastra una imagen aquí</p>
                        </div>
                        <p class="text-xs text-gray-400 mt-2">PNG, JPG, GIF, WEBP - Máx. 2MB</p>
                    </div>
                @endif

                <!-- Vista previa de nueva imagen -->
                <template x-if="coverPreview">
                    <div class="mb-4">
                        <img :src="coverPreview" alt="Nueva portada"
                            class="mx-auto h-32 w-auto object-contain rounded shadow">
                        <p class="text-xs text-green-600 mt-2">Nueva portada seleccionada</p>
                        <button type="button" @click="removeCoverPreview()"
                            class="mt-1 text-red-600 hover:text-red-800 text-sm transition-colors">
                            <i class="fas fa-times mr-1"></i>Cancelar
                        </button>
                    </div>
                </template>
            </div>
        </div>
    </div>

    <!-- PDF Existente -->
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-2">
            Archivo PDF del Libro
        </label>

        <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md">
            <div class="space-y-1 text-center w-full">
                @if ($book && $book->pdf_file)
                    <!-- PDF existente -->
                    <div class="mb-4 p-4 bg-gray-50 rounded-lg">
                        <i class="fas fa-file-pdf text-red-500 text-3xl mb-2"></i>
                        <p class="text-sm font-medium text-gray-700 truncate">
                            {{ basename($book->pdf_file) }}
                        </p>
                        <p class="text-xs text-gray-500">PDF actual</p>
                        <div class="mt-3 space-y-2">
                            <label
                                class="relative cursor-pointer bg-white rounded-md font-medium text-blue-600 hover:text-blue-500 transition-colors text-sm">
                                <span class="px-3 py-1 border border-blue-600 rounded">Cambiar PDF</span>
                                <input type="file" class="sr-only" accept=".pdf" name="pdf_file"
                                    @change="handlePdfFileSelect($event)">
                            </label>
                            <button type="button" onclick="confirmDeletePdf()"
                                class="text-red-600 hover:text-red-800 text-sm transition-colors">
                                <i class="fas fa-trash mr-1"></i>Eliminar
                            </button>
                        </div>
                    </div>
                @else
                    <!-- Sin PDF - permitir subir -->
                    <div class="py-4">
                        <i class="fas fa-file-pdf text-gray-400 text-3xl mx-auto mb-3"></i>
                        <div class="flex text-sm text-gray-600 justify-center flex-col space-y-2">
                            <label
                                class="relative cursor-pointer bg-white rounded-md font-medium text-blue-600 hover:text-blue-500 transition-colors">
                                <span class="px-3 py-1 border border-blue-600 rounded">Seleccionar PDF</span>
                                <input type="file" class="sr-only" accept=".pdf" name="pdf_file"
                                    @change="handlePdfFileSelect($event)">
                            </label>
                            <p class="text-xs text-gray-500">o arrastra un PDF aquí</p>
                        </div>
                        <p class="text-xs text-gray-400 mt-2">PDF - Máx. 10MB</p>
                    </div>
                @endif

                <!-- Vista previa de nuevo PDF -->
                <template x-if="pdfFile">
                    <div class="mb-4 p-4 bg-green-50 border border-green-200 rounded-lg">
                        <i class="fas fa-file-pdf text-green-500 text-3xl mb-2"></i>
                        <div class="mt-2 space-y-1">
                            <p class="text-sm font-medium text-gray-700 truncate" x-text="pdfFile.name"></p>
                            <p class="text-xs text-gray-600" x-text="pdfFile.sizeFormatted"></p>
                            <p class="text-xs text-green-600 font-medium">✓ Nuevo PDF seleccionado</p>
                        </div>
                        <button type="button" @click="removePdfPreview()"
                            class="mt-3 text-red-600 hover:text-red-800 text-sm transition-colors">
                            <i class="fas fa-times mr-1"></i>Cancelar
                        </button>
                    </div>
                </template>
            </div>
        </div>
    </div>
</div>

<!-- Estado de validación -->
<div class="mt-4 p-3 rounded-lg border"
    :class="hasCoverImage ? 'bg-green-50 border-green-200' : 'bg-yellow-50 border-yellow-200'">
    <p class="text-sm flex items-center" :class="hasCoverImage ? 'text-green-700' : 'text-yellow-700'">
        <i class="fas mr-2" :class="hasCoverImage ? 'fa-check-circle' : 'fa-exclamation-triangle'"></i>
        <span
            x-text="hasCoverImage ? '✅ Portada lista para guardar' : '⚠️ Debes seleccionar una portada para el libro'"></span>
    </p>
</div>

<!-- Campos ocultos para eliminar archivos -->
@if ($book)
    <input type="hidden" name="delete_cover" id="delete_cover" value="0">
    <input type="hidden" name="delete_pdf" id="delete_pdf" value="0">
@endif

@push('scripts')
    <script>
        function fileUpload() {
            return {
                coverPreview: '',
                coverFile: null,
                pdfFile: null,
                hasCoverImage: {{ $book && $book->cover_image ? 'true' : 'false' }},

                init() {
                    // Si hay portada existente, marcar como válida
                    if (this.hasCoverImage) {
                        console.log('Portada existente detectada');
                    }
                },

                handleCoverImageSelect(event) {
                    const file = event.target.files[0];
                    if (file) {
                        this.processCoverFile(file);
                    }
                },

                handlePdfFileSelect(event) {
                    const file = event.target.files[0];
                    if (file) {
                        this.processPdfFile(file);
                    }
                },

                processCoverFile(file) {
                    // Validar tamaño (2MB)
                    if (file.size > 2 * 1024 * 1024) {
                        alert('La imagen es demasiado grande. Máximo 2MB permitido.');
                        return;
                    }

                    // Validar tipo
                    const validTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
                    if (!validTypes.includes(file.type)) {
                        alert('Formato de imagen no válido. Use JPEG, PNG, GIF o WEBP.');
                        return;
                    }

                    this.coverFile = {
                        name: file.name,
                        size: file.size,
                        sizeFormatted: this.formatFileSize(file.size),
                        type: file.type
                    };

                    // Crear vista previa
                    const reader = new FileReader();
                    reader.onload = (e) => {
                        this.coverPreview = e.target.result;
                        this.hasCoverImage = true;

                        // Si había portada existente, marcar para no eliminar
                        if (document.getElementById('delete_cover')) {
                            document.getElementById('delete_cover').value = '0';
                        }
                    };
                    reader.readAsDataURL(file);
                },

                processPdfFile(file) {
                    // Validar tamaño (10MB)
                    if (file.size > 10 * 1024 * 1024) {
                        alert('El PDF es demasiado grande. Máximo 10MB permitido.');
                        return;
                    }

                    // Validar tipo
                    if (file.type !== 'application/pdf') {
                        alert('Solo se permiten archivos PDF.');
                        return;
                    }

                    this.pdfFile = {
                        name: file.name,
                        size: file.size,
                        sizeFormatted: this.formatFileSize(file.size),
                        type: file.type
                    };

                    // Si había PDF existente, marcar para no eliminar
                    if (document.getElementById('delete_pdf')) {
                        document.getElementById('delete_pdf').value = '0';
                    }
                },

                removeCoverPreview() {
                    this.coverPreview = '';
                    this.coverFile = null;

                    // Limpiar input file
                    const input = document.querySelector('input[name="cover_image"]');
                    if (input) input.value = '';

                    // Si no hay portada existente, marcar como no válido
                    if (!{{ $book && $book->cover_image ? 'true' : 'false' }}) {
                        this.hasCoverImage = false;
                    }
                },

                removePdfPreview() {
                    this.pdfFile = null;

                    // Limpiar input file
                    const input = document.querySelector('input[name="pdf_file"]');
                    if (input) input.value = '';
                },

                formatFileSize(bytes) {
                    if (bytes >= 1073741824) {
                        return (bytes / 1073741824).toFixed(2) + ' GB';
                    } else if (bytes >= 1048576) {
                        return (bytes / 1048576).toFixed(2) + ' MB';
                    } else if (bytes >= 1024) {
                        return (bytes / 1024).toFixed(2) + ' KB';
                    } else {
                        return bytes + ' bytes';
                    }
                }
            }
        }

        function confirmDeleteCover() {
            if (confirm('¿Estás seguro de que quieres eliminar la portada actual?')) {
                document.getElementById('delete_cover').value = '1';
                // Ocultar la portada actual
                const coverContainer = document.querySelector('img[alt="Portada actual"]').closest('.mb-4');
                if (coverContainer) {
                    coverContainer.style.display = 'none';
                }
                // Mostrar el formulario de subida
                document.querySelector('[x-data]').__x.$data.hasCoverImage = false;
            }
        }

        function confirmDeletePdf() {
            if (confirm('¿Estás seguro de que quieres eliminar el PDF actual?')) {
                document.getElementById('delete_pdf').value = '1';
                // Ocultar el PDF actual
                const pdfContainer = document.querySelector('.bg-gray-50.rounded-lg');
                if (pdfContainer) {
                    pdfContainer.style.display = 'none';
                }
            }
        }

        // Validación del formulario para edición
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.querySelector('form');

            form.addEventListener('submit', function(e) {
                const hasExistingCover = {{ $book && $book->cover_image ? 'true' : 'false' }};
                const hasNewCover = document.querySelector('input[name="cover_image"]').files.length > 0;
                const deleteCover = document.getElementById('delete_cover') ? document.getElementById(
                    'delete_cover').value === '1' : false;

                // Validar que haya al menos una portada (existente o nueva)
                if (!hasExistingCover && !hasNewCover) {
                    e.preventDefault();
                    alert('⚠️ Debes seleccionar una portada para el libro antes de guardar.');
                    return false;
                }

                // Si se está eliminando la portada existente pero no se subió una nueva
                if (deleteCover && !hasNewCover) {
                    e.preventDefault();
                    alert(
                        '⚠️ Estás eliminando la portada actual pero no has seleccionado una nueva portada.'
                        );
                    return false;
                }
            });
        });
    </script>
@endpush
