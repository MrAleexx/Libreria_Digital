{{-- resources/views/admin/books/partials/file-upload.blade.php --}}
<div x-data="fileUpload()">
    <!-- Archivos: Portada y PDF -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Portada -->
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">
                Portada del Libro <span class="text-red-600">*</span>
            </label>

            <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md"
                @drop.prevent="handleCoverDrop($event)" @dragover.prevent="coverDragOver = true"
                @dragleave.prevent="coverDragOver = false"
                :class="coverDragOver ? 'border-blue-500 bg-blue-50' : 'border-gray-300'">
                <div class="space-y-1 text-center w-full">
                    <!-- Vista previa -->
                    <template x-if="coverPreview">
                        <div class="mb-4">
                            <img :src="coverPreview" alt="Vista previa de la portada"
                                class="mx-auto h-32 w-auto object-contain rounded shadow">
                            <button type="button" @click="removeCoverImage"
                                class="mt-2 text-red-600 hover:text-red-800 text-sm transition-colors">
                                <i class="fas fa-trash mr-1"></i>Eliminar
                            </button>
                        </div>
                    </template>

                    <!-- Input de subida -->
                    <div x-show="!coverPreview" class="py-4">
                        <i class="fas fa-image text-gray-400 text-3xl mx-auto mb-3"></i>
                        <div class="flex text-sm text-gray-600 justify-center flex-col space-y-2">
                            <label
                                class="relative cursor-pointer bg-white rounded-md font-medium text-blue-600 hover:text-blue-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-blue-500 transition-colors">
                                <span class="px-3 py-1 border border-blue-600 rounded">Seleccionar imagen</span>
                                <input type="file" class="sr-only" accept="image/*" name="cover_image"
                                    @change="handleCoverImageSelect($event)" required>
                            </label>
                            <p class="text-xs text-gray-500">o arrastra una imagen aquí</p>
                        </div>
                        <p class="text-xs text-gray-400 mt-2">PNG, JPG, GIF, WEBP - Máx. 2MB</p>
                    </div>

                    <!-- Información del archivo -->
                    <div x-show="coverFile" class="mt-2 p-2 bg-green-50 rounded">
                        <p class="text-xs text-green-700" x-text="coverFile.name"></p>
                        <p class="text-xs text-green-600" x-text="coverFile.sizeFormatted"></p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Archivo PDF -->
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">
                Archivo PDF del Libro
            </label>

            <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md"
                @drop.prevent="handlePdfDrop($event)" @dragover.prevent="pdfDragOver = true"
                @dragleave.prevent="pdfDragOver = false"
                :class="pdfDragOver ? 'border-blue-500 bg-blue-50' : 'border-gray-300'">
                <div class="space-y-1 text-center w-full">
                    <!-- Vista previa -->
                    <template x-if="pdfFile">
                        <div class="mb-4 p-4 bg-green-50 border border-green-200 rounded-lg">
                            <i class="fas fa-file-pdf text-green-500 text-3xl mb-2"></i>
                            <div class="mt-2 space-y-1">
                                <p class="text-sm font-medium text-gray-700 truncate" x-text="pdfFile.name"></p>
                                <p class="text-xs text-gray-600" x-text="pdfFile.sizeFormatted"></p>
                            </div>
                            <button type="button" @click="removePdfFile"
                                class="mt-3 text-red-600 hover:text-red-800 text-sm transition-colors">
                                <i class="fas fa-trash mr-1"></i>Eliminar
                            </button>
                        </div>
                    </template>

                    <!-- Input de subida -->
                    <div x-show="!pdfFile" class="py-4">
                        <i class="fas fa-file-pdf text-gray-400 text-3xl mx-auto mb-3"></i>
                        <div class="flex text-sm text-gray-600 justify-center flex-col space-y-2">
                            <label
                                class="relative cursor-pointer bg-white rounded-md font-medium text-blue-600 hover:text-blue-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-blue-500 transition-colors">
                                <span class="px-3 py-1 border border-blue-600 rounded">Seleccionar PDF</span>
                                <input type="file" class="sr-only" accept=".pdf" name="pdf_file"
                                    @change="handlePdfFileSelect($event)">
                            </label>
                            <p class="text-xs text-gray-500">o arrastra un PDF aquí</p>
                        </div>
                        <p class="text-xs text-gray-400 mt-2">PDF - Máx. 10MB</p>
                    </div>
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
</div>

@push('scripts')
    <script>
        function fileUpload() {
            return {
                coverPreview: '',
                coverFile: null,
                coverDragOver: false,
                pdfFile: null,
                pdfDragOver: false,
                hasCoverImage: false,

                init() {
                    // Verificar si hay archivos existentes (para edición)
                    const existingCoverInput = document.querySelector('input[name="cover_image"][type="hidden"]');
                    if (existingCoverInput && existingCoverInput.value) {
                        this.hasCoverImage = true;
                    }
                },

                handleCoverImageSelect(event) {
                    const file = event.target.files[0];
                    if (file) {
                        this.processCoverFile(file);
                    }
                },

                handleCoverDrop(event) {
                    this.coverDragOver = false;
                    const file = event.dataTransfer.files[0];
                    if (file && file.type.startsWith('image/')) {
                        this.processCoverFile(file);

                        // Actualizar el input file
                        const input = event.target.querySelector('input[type="file"]');
                        const dataTransfer = new DataTransfer();
                        dataTransfer.items.add(file);
                        input.files = dataTransfer.files;
                    }
                },

                handlePdfFileSelect(event) {
                    const file = event.target.files[0];
                    if (file) {
                        this.processPdfFile(file);
                    }
                },

                handlePdfDrop(event) {
                    this.pdfDragOver = false;
                    const file = event.dataTransfer.files[0];
                    if (file && file.type === 'application/pdf') {
                        this.processPdfFile(file);

                        // Actualizar el input file
                        const input = event.target.querySelector('input[type="file"]');
                        const dataTransfer = new DataTransfer();
                        dataTransfer.items.add(file);
                        input.files = dataTransfer.files;
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
                },

                removeCoverImage() {
                    this.coverPreview = '';
                    this.coverFile = null;
                    this.hasCoverImage = false;

                    // Limpiar input file
                    const input = document.querySelector('input[name="cover_image"]');
                    input.value = '';
                },

                removePdfFile() {
                    this.pdfFile = null;

                    // Limpiar input file
                    const input = document.querySelector('input[name="pdf_file"]');
                    input.value = '';
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

        // Validación del formulario
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.querySelector('form');

            form.addEventListener('submit', function(e) {
                const coverInput = document.querySelector('input[name="cover_image"]');
                const hasCoverImage = coverInput && coverInput.files.length > 0;

                if (!hasCoverImage) {
                    e.preventDefault();
                    alert('⚠️ Debes seleccionar una portada para el libro antes de guardar.');
                    return false;
                }
            });
        });
    </script>
@endpush
