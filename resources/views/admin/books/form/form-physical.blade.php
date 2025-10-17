<!-- resources/views/admin/books/form/form-physical.blade.php -->
<div class="space-y-6" x-data="physicalBookManager()" x-init="init()">
    <!-- Información sobre ejemplares físicos -->
    <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
        <div class="flex">
            <div class="flex-shrink-0">
                <i class="fas fa-book text-yellow-400 mt-1"></i>
            </div>
            <div class="ml-3">
                <h3 class="text-sm font-medium text-yellow-800">
                    Gestión de Ejemplares Físicos
                </h3>
                <div class="mt-2 text-sm text-yellow-700">
                    <p>Esta sección solo es relevante para libros de tipo <strong>Físico</strong> o
                        <strong>Mixto</strong>.
                        Los ejemplares físicos se gestionan desde el módulo de inventario después de crear el libro.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Contadores de ejemplares (solo lectura para libros existentes) -->
    <template x-if="bookId">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="bg-white p-4 rounded-lg border border-gray-200 text-center">
                <div class="text-2xl font-bold text-gray-900" x-text="totalCopies || 0"></div>
                <div class="text-sm text-gray-600">Total de Ejemplares</div>
            </div>
            <div class="bg-white p-4 rounded-lg border border-gray-200 text-center">
                <div class="text-2xl font-bold text-green-600" x-text="availableCopies || 0"></div>
                <div class="text-sm text-gray-600">Disponibles</div>
            </div>
            <div class="bg-white p-4 rounded-lg border border-gray-200 text-center">
                <div class="text-2xl font-bold text-blue-600" x-text="totalLoans || 0"></div>
                <div class="text-sm text-gray-600">Préstamos Totales</div>
            </div>
        </div>
    </template>

    <!-- Acciones rápidas para libros existentes -->
    <template x-if="bookId">
        <div class="bg-white p-4 rounded-lg border border-gray-200">
            <h4 class="text-sm font-medium text-gray-900 mb-3">Acciones Rápidas</h4>
            <div class="flex flex-wrap gap-3">
                <a :href="`/admin/physical-copies?book_id=${bookId}`"
                    class="inline-flex items-center px-3 py-2 border border-gray-300 shadow-sm text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    <i class="fas fa-boxes mr-2"></i>
                    Gestionar Ejemplares
                </a>
                <a :href="`/admin/loans/create?book_id=${bookId}`"
                    class="inline-flex items-center px-3 py-2 border border-gray-300 shadow-sm text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    <i class="fas fa-hand-holding mr-2"></i>
                    Nuevo Préstamo
                </a>
                <a :href="`/admin/reservations/create?book_id=${bookId}`"
                    class="inline-flex items-center px-3 py-2 border border-gray-300 shadow-sm text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    <i class="fas fa-calendar-check mr-2"></i>
                    Nueva Reserva
                </a>
            </div>
        </div>
    </template>

    <!-- Información de ubicación y depósito legal -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
            <label for="deposito_legal" class="block text-sm font-medium text-gray-700 mb-1">
                Depósito Legal
            </label>
            <input type="text" name="deposito_legal" id="deposito_legal"
                value="{{ old('deposito_legal', $book->details->deposito_legal ?? '') }}"
                class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500"
                placeholder="Número de depósito legal">
            @error('deposito_legal')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="edition" class="block text-sm font-medium text-gray-700 mb-1">
                Edición
            </label>
            <input type="text" name="edition" id="edition"
                value="{{ old('edition', $book->details->edition ?? '1ra') }}"
                class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500"
                placeholder="Ej: 1ra, 2da, 3ra...">
            @error('edition')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>
    </div>

    <!-- Restricciones y notas -->
    <div class="grid grid-cols-1 gap-6">
        <div>
            <label for="restrictions" class="block text-sm font-medium text-gray-700 mb-1">
                Restricciones de Préstamo
            </label>
            <textarea name="restrictions" id="restrictions" rows="3"
                class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500"
                placeholder="Especifica restricciones especiales para este libro...">{{ old('restrictions', $book->details->restrictions ?? '') }}</textarea>
            @error('restrictions')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="notes" class="block text-sm font-medium text-gray-700 mb-1">
                Notas Internas
            </label>
            <textarea name="notes" id="notes" rows="2"
                class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500"
                placeholder="Notas para el personal de la biblioteca...">{{ old('notes', $book->details->notes ?? '') }}</textarea>
            @error('notes')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>
    </div>

    <!-- Información para nuevos libros -->
    <template x-if="!bookId">
        <div class="bg-green-50 border border-green-200 rounded-lg p-4">
            <div class="flex">
                <div class="flex-shrink-0">
                    <i class="fas fa-lightbulb text-green-400 mt-1"></i>
                </div>
                <div class="ml-3">
                    <h3 class="text-sm font-medium text-green-800">
                        Próximos Pasos para Libros Físicos
                    </h3>
                    <div class="mt-2 text-sm text-green-700">
                        <p>Después de crear el libro, podrás:</p>
                        <ul class="list-disc list-inside mt-1 space-y-1">
                            <li>Agregar ejemplares físicos con códigos de barras</li>
                            <li>Establecer ubicaciones en la biblioteca</li>
                            <li>Gestionar préstamos y reservas</li>
                            <li>Controlar inventario y disponibilidad</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </template>
</div>

@push('scripts')
    <script>
        function physicalBookManager() {
            return {
                bookId: {{ $book->id ?? 'null' }},
                totalCopies: 0,
                availableCopies: 0,
                totalLoans: 0,

                init() {
                    if (this.bookId) {
                        this.loadPhysicalStats();
                    }
                },

                loadPhysicalStats() {
                    // Cargar estadísticas físicas del libro
                    fetch(`/admin/books/${this.bookId}/physical-stats`)
                        .then(response => response.json())
                        .then(data => {
                            this.totalCopies = data.total_copies;
                            this.availableCopies = data.available_copies;
                            this.totalLoans = data.total_loans;
                        })
                        .catch(error => {
                            console.error('Error loading physical stats:', error);
                        });
                }
            }
        }
    </script>
@endpush
