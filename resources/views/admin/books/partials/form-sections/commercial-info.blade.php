{{-- resources/views/admin/books/partials/form-sections/commercial-info.blade.php --}}
<style>
    .price-field:disabled {
        background-color: #f9fafb;
        color: #6b7280;
        cursor: not-allowed;
    }

    .free-info-transition {
        transition: all 0.3s ease-in-out;
    }

    #free-badge {
        transition: all 0.2s ease-in-out;
    }
</style>

<div class="bg-white rounded-lg border border-gray-200 p-6">
    <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
        <i class="fas fa-shopping-cart text-green-500 mr-2"></i>
        Información Comercial
    </h3>

    <div class="space-y-6">
        <!-- Precio y Libro Gratuito -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Campo de Precio -->
            <div>
                <label for="price" class="block text-sm font-medium text-gray-700 mb-2 flex items-center">
                    <i class="fas fa-tag text-gray-400 mr-2 text-xs"></i>
                    Precio (S/) *
                    <span id="free-badge" class="hidden ml-2 bg-green-100 text-green-800 text-xs px-2 py-1 rounded-full">
                        Gratuito
                    </span>
                </label>
                <input type="number" id="price" name="price" step="0.01" min="0" required
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 price-field"
                    value="{{ old('price', $book->price ?? '') }}"
                    {{ old('is_free', $book->is_free ?? false) ? 'disabled' : '' }}>

                <!-- Campo hidden para enviar el precio cuando esté deshabilitado -->
                <input type="hidden" id="price_hidden" name="price" value="{{ old('price', $book->price ?? '') }}">

                @error('price')
                    <p class="text-red-500 text-sm mt-1 flex items-center">
                        <i class="fas fa-exclamation-circle mr-1"></i>
                        {{ $message }}
                    </p>
                @enderror
            </div>

            <!-- Opción de Libro Gratuito -->
            <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg border border-gray-200">
                <div>
                    <label for="is_free" class="block text-sm font-medium text-gray-700 mb-1 flex items-center">
                        <i class="fas fa-gift text-green-500 mr-2"></i>
                        Libro Gratuito
                    </label>
                    <p class="text-xs text-gray-600">
                        Los usuarios podrán obtenerlo sin pago
                    </p>
                </div>
                <label class="relative inline-flex items-center cursor-pointer">
                    <input type="checkbox" id="is_free" name="is_free" value="1" class="sr-only peer free-toggle"
                        {{ old('is_free', $book->is_free ?? false) ? 'checked' : '' }}>
                    <div
                        class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-green-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-green-600">
                    </div>
                </label>
            </div>
        </div>

        <!-- Información sobre libros gratuitos -->
        <div id="free-info" class="free-info-transition hidden bg-green-50 border border-green-200 rounded-lg p-4">
            <div class="flex items-start">
                <i class="fas fa-info-circle text-green-500 mt-0.5 mr-3"></i>
                <div class="text-sm text-green-800">
                    <strong class="block mb-1">Características de los libros gratuitos:</strong>
                    <ul class="space-y-1">
                        <li>• Acceso inmediato sin proceso de pago</li>
                        <li>• Los usuarios pueden obtener 1 unidad por pedido</li>
                        <li>• No requieren comprobante de pago</li>
                        <li>• Disponibles automáticamente en la biblioteca del usuario</li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Otros campos comerciales -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label for="reading_age" class="block text-sm font-medium text-gray-700 mb-2 flex items-center">
                    <i class="fas fa-user-friends text-gray-400 mr-2 text-xs"></i>
                    Edad de Lectura
                </label>
                <input type="text" id="reading_age" name="reading_age"
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500"
                    value="{{ old('reading_age', $book->reading_age ?? '') }}" placeholder="De 14 a 18 años">
            </div>

            <div>
                <label for="publication_url" class="block text-sm font-medium text-gray-700 mb-2 flex items-center">
                    <i class="fas fa-link text-gray-400 mr-2 text-xs"></i>
                    URL de Publicación
                </label>
                <input type="url" id="publication_url" name="publication_url"
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500"
                    value="{{ old('publication_url', $book->publication_url ?? '') }}" placeholder="https://a.co/d/...">
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const freeToggle = document.getElementById('is_free');
            const priceField = document.getElementById('price');
            const priceHidden = document.getElementById('price_hidden');
            const freeInfo = document.getElementById('free-info');
            const freeBadge = document.getElementById('free-badge');

            function toggleFreeBookState() {
                if (freeToggle.checked) {
                    // Libro gratuito
                    priceField.disabled = true;
                    priceField.value = '0';
                    priceHidden.value = '0'; // Actualizar el campo hidden también
                    priceField.classList.add('bg-gray-100', 'text-gray-500', 'cursor-not-allowed');
                    freeInfo.classList.remove('hidden');
                    freeBadge.classList.remove('hidden');

                    // Actualizar el label del precio
                    const priceLabel = document.querySelector('label[for="price"]');
                    if (priceLabel) {
                        priceLabel.classList.add('text-green-700');
                    }
                } else {
                    // Libro de pago
                    priceField.disabled = false;
                    priceHidden.value = priceField.value; // Sincronizar con el campo visible
                    priceField.classList.remove('bg-gray-100', 'text-gray-500', 'cursor-not-allowed');
                    freeInfo.classList.add('hidden');
                    freeBadge.classList.add('hidden');

                    // Restaurar el label del precio
                    const priceLabel = document.querySelector('label[for="price"]');
                    if (priceLabel) {
                        priceLabel.classList.remove('text-green-700');
                    }
                }
            }

            // Inicializar estado
            toggleFreeBookState();

            // Escuchar cambios en el toggle
            freeToggle.addEventListener('change', toggleFreeBookState);

            // Sincronizar el campo hidden con el campo visible cuando cambie
            priceField.addEventListener('input', function() {
                priceHidden.value = this.value;

                if (freeToggle.checked && this.value !== '0') {
                    freeToggle.checked = false;
                    toggleFreeBookState();
                }
            });

            // Prevenir que el usuario modifique el precio cuando está deshabilitado
            priceField.addEventListener('keydown', function(e) {
                if (priceField.disabled) {
                    e.preventDefault();
                    return false;
                }
            });
        });
    </script>
@endpush
