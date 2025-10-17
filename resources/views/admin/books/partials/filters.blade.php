{{-- resources/views/admin/books/partials/filters.blade.php --}}
<div>
    <!-- Campos ocultos para el formulario principal -->
    <input type="hidden" name="cover_image" value="{{ $cover_image_path }}">
    <input type="hidden" name="pdf_file" value="{{ $pdf_file_path }}">

    <!-- Archivos: Portada y PDF -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Portada -->
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">
                Portada del Libro
            </label>

            <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md transition-colors duration-200"
                x-data="{ isDragging: false }" @dragenter="isDragging = true" @dragleave="isDragging = false"
                @drop="isDragging = false" :class="isDragging ? 'border-blue-500 bg-blue-50' : 'border-gray-300'"
                wire:ignore>

                <div class="space-y-1 text-center w-full">
                    <!-- Vista previa de imagen existente -->
                    @if ($existingCoverImage)
                        <div class="mb-4">
                            <img src="{{ Storage::url($existingCoverImage) }}" alt="Portada actual"
                                class="mx-auto h-32 w-auto object-cover rounded shadow">
                            <p class="text-xs text-gray-500 mt-2">Portada actual</p>
                            <button type="button" wire:click="removeCoverImage"
                                class="mt-1 text-red-600 hover:text-red-800 text-sm transition-colors">
                                <i class="fas fa-trash mr-1"></i>Eliminar
                            </button>
                        </div>
                    @endif

                    <!-- Vista previa de nueva imagen -->
                    @if ($coverPreview)
                        <div class="mb-4">
                            <img src="{{ $coverPreview }}" alt="Vista previa"
                                class="mx-auto max-h-32 w-auto object-contain rounded shadow">
                            <p class="text-xs text-gray-500 mt-2">Vista previa - Lista para guardar</p>
                            <button type="button" wire:click="removeCoverImage"
                                class="mt-1 text-red-600 hover:text-red-800 text-sm transition-colors">
                                <i class="fas fa-trash mr-1"></i>Eliminar
                            </button>
                        </div>
                    @endif

                    <!-- Estados -->
                    <div wire:loading wire:target="coverImage" class="text-blue-600 py-4">
                        <i class="fas fa-spinner fa-spin text-xl mb-2"></i>
                        <p class="text-sm">Procesando imagen...</p>
                    </div>

                    <div wire:loading.remove wire:target="coverImage">
                        @if (!$coverImage && !$existingCoverImage && !$coverPreview)
                            <div class="py-4">
                                <i class="fas fa-image text-gray-400 text-3xl mx-auto mb-3"></i>
                                <div class="flex text-sm text-gray-600 justify-center flex-col space-y-2">
                                    <label
                                        class="relative cursor-pointer bg-white rounded-md font-medium text-blue-600 hover:text-blue-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-blue-500 transition-colors">
                                        <span class="px-3 py-1 border border-blue-600 rounded">Seleccionar imagen</span>
                                        <input type="file" class="sr-only" accept="image/*" wire:model="coverImage">
                                    </label>
                                    <p class="text-xs text-gray-500">o arrastra una imagen aquí</p>
                                </div>
                                <p class="text-xs text-gray-400 mt-2">PNG, JPG, GIF, WEBP - Máx. 2MB</p>
                            </div>
                        @endif
                    </div>

                    @error('coverImage')
                        <div class="p-3 bg-red-50 border border-red-200 rounded-lg">
                            <p class="text-sm text-red-600 flex items-center">
                                <i class="fas fa-exclamation-triangle mr-2"></i>
                                {{ $message }}
                            </p>
                        </div>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Archivo PDF -->
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">
                Archivo PDF del Libro
            </label>

            <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md transition-colors duration-200"
                x-data="{ isDragging: false }" @dragenter="isDragging = true" @dragleave="isDragging = false"
                @drop="isDragging = false" :class="isDragging ? 'border-blue-500 bg-blue-50' : 'border-gray-300'"
                wire:ignore>

                <div class="space-y-1 text-center w-full">
                    <!-- PDF existente -->
                    @if ($existingPdfFile)
                        <div class="mb-4 p-3 bg-gray-50 rounded-lg">
                            <i class="fas fa-file-pdf text-red-500 text-3xl mb-2"></i>
                            <p class="text-sm font-medium text-gray-700 truncate">{{ basename($existingPdfFile) }}</p>
                            <p class="text-xs text-gray-500">PDF actual</p>
                            <button type="button" wire:click="removePdfFile"
                                class="mt-2 text-red-600 hover:text-red-800 text-sm transition-colors">
                                <i class="fas fa-trash mr-1"></i>Eliminar
                            </button>
                        </div>
                    @endif

                    <!-- Vista previa de nuevo PDF -->
                    @if ($pdfInfo)
                        <div class="mb-4 p-4 bg-green-50 border border-green-200 rounded-lg">
                            <i class="fas fa-file-pdf text-green-500 text-3xl mb-2"></i>
                            <div class="mt-2 space-y-1">
                                <p class="text-sm font-medium text-gray-700 truncate">{{ $pdfInfo['name'] }}</p>
                                <p class="text-xs text-gray-600">{{ $pdfInfo['size'] }}</p>
                                <p class="text-xs text-green-600 font-medium">✓ Listo para guardar</p>
                            </div>
                            <button type="button" wire:click="removePdfFile"
                                class="mt-3 text-red-600 hover:text-red-800 text-sm transition-colors">
                                <i class="fas fa-trash mr-1"></i>Eliminar
                            </button>
                        </div>
                    @endif

                    <!-- Estados -->
                    <div wire:loading wire:target="pdfFile" class="text-blue-600 py-4">
                        <i class="fas fa-spinner fa-spin text-xl mb-2"></i>
                        <p class="text-sm">Procesando PDF...</p>
                    </div>

                    <div wire:loading.remove wire:target="pdfFile">
                        @if (!$pdfFile && !$existingPdfFile && !$pdfInfo)
                            <div class="py-4">
                                <i class="fas fa-file-pdf text-gray-400 text-3xl mx-auto mb-3"></i>
                                <div class="flex text-sm text-gray-600 justify-center flex-col space-y-2">
                                    <label
                                        class="relative cursor-pointer bg-white rounded-md font-medium text-blue-600 hover:text-blue-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-blue-500 transition-colors">
                                        <span class="px-3 py-1 border border-blue-600 rounded">Seleccionar PDF</span>
                                        <input type="file" class="sr-only" accept=".pdf" wire:model="pdfFile">
                                    </label>
                                    <p class="text-xs text-gray-500">o arrastra un PDF aquí</p>
                                </div>
                                <p class="text-xs text-gray-400 mt-2">PDF - Máx. 10MB</p>
                            </div>
                        @endif
                    </div>

                    @error('pdfFile')
                        <div class="p-3 bg-red-50 border border-red-200 rounded-lg">
                            <p class="text-sm text-red-600 flex items-center">
                                <i class="fas fa-exclamation-triangle mr-2"></i>
                                {{ $message }}
                            </p>
                        </div>
                    @enderror
                </div>
            </div>
        </div>
    </div>

    <!-- Resumen de archivos listos -->
    @if ($cover_image_path || $pdf_file_path)
        <div class="mt-6 p-4 bg-blue-50 border border-blue-200 rounded-lg">
            <h4 class="text-sm font-medium text-blue-800 mb-3 flex items-center">
                <i class="fas fa-check-circle text-blue-600 mr-2"></i>
                Archivos preparados para guardar
            </h4>
            <div class="space-y-2 text-sm">
                @if ($cover_image_path)
                    <div class="flex items-center justify-between p-2 bg-white rounded">
                        <div class="flex items-center">
                            <i class="fas fa-image text-green-500 mr-2"></i>
                            <span class="text-gray-700">Portada: {{ basename($cover_image_path) }}</span>
                        </div>
                        <span class="text-xs text-green-600 font-medium">✓ Lista</span>
                    </div>
                @endif
                @if ($pdf_file_path)
                    <div class="flex items-center justify-between p-2 bg-white rounded">
                        <div class="flex items-center">
                            <i class="fas fa-file-pdf text-green-500 mr-2"></i>
                            <span class="text-gray-700">PDF: {{ basename($pdf_file_path) }}</span>
                        </div>
                        <span class="text-xs text-green-600 font-medium">✓ Listo</span>
                    </div>
                @endif
            </div>
        </div>
    @endif
</div>
