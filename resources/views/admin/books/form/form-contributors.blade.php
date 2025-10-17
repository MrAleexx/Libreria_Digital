<!-- resources/views/admin/books/form/form-contributors.blade.php -->
<div>
    <!-- Header con información -->
    <div class="mb-6">
        <h4 class="text-lg font-medium text-gray-900 mb-2">Autores y Contribuidores</h4>
        <p class="text-sm text-gray-600">
            Agrega todos los autores, editores, traductores y otros colaboradores del libro.
            El orden determina la secuencia en que aparecerán en los créditos.
        </p>
    </div>

    <!-- Livewire Component para gestión de contribuidores -->
    @livewire('book-contributors-manager', ['book' => $book ?? null])

    <!-- Información sobre tipos de contribuidores -->
    <div class="mt-6 bg-gray-50 p-4 rounded-lg">
        <h5 class="text-sm font-medium text-gray-900 mb-3">Tipos de Contribuidores</h5>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm text-gray-600">
            <div class="flex items-start">
                <i class="fas fa-user-edit text-blue-500 mt-1 mr-2"></i>
                <div>
                    <strong>Autor:</strong> Persona que escribe el contenido principal
                </div>
            </div>
            <div class="flex items-start">
                <i class="fas fa-edit text-green-500 mt-1 mr-2"></i>
                <div>
                    <strong>Editor:</strong> Persona que prepara el material para publicación
                </div>
            </div>
            <div class="flex items-start">
                <i class="fas fa-language text-purple-500 mt-1 mr-2"></i>
                <div>
                    <strong>Traductor:</strong> Persona que traduce el contenido
                </div>
            </div>
            <div class="flex items-start">
                <i class="fas fa-palette text-orange-500 mt-1 mr-2"></i>
                <div>
                    <strong>Ilustrador:</strong> Persona que crea imágenes o gráficos
                </div>
            </div>
        </div>
    </div>
</div>
