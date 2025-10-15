{{-- resources/views/admin/books/partials/form-sections/publisher-info.blade.php --}}
<div class="bg-white rounded-lg border border-gray-200 p-6">
    <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
        <i class="fas fa-building text-purple-500 mr-2"></i>
        Información Editorial
    </h3>

    <div class="grid grid-cols-1 gap-4">
        <div>
            <label for="publisher_id" class="block text-sm font-medium text-gray-700 mb-2 flex items-center">
                <i class="fas fa-university text-gray-400 mr-2 text-xs"></i>
                Editorial *
            </label>
            <select id="publisher_id" name="publisher_id" required
                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500">
                <option value="">Seleccionar Editorial</option>
                @foreach ($publishers as $publisher)
                    <option value="{{ $publisher->id }}"
                        {{ old('publisher_id', $book->publisher_id ?? '') == $publisher->id ? 'selected' : '' }}>
                        {{ $publisher->name }}
                        @if ($publisher->city)
                            ({{ $publisher->city }})
                        @endif
                    </option>
                @endforeach
            </select>
            @error('publisher_id')
                <p class="text-red-500 text-sm mt-1 flex items-center">
                    <i class="fas fa-exclamation-circle mr-1"></i>
                    {{ $message }}
                </p>
            @enderror
        </div>

        {{-- SOLUCIÓN SIMPLE: Botón para crear editorial rápida --}}
        <div class="mt-4 p-4 bg-blue-50 rounded-lg border border-blue-200">
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <i class="fas fa-info-circle text-blue-500 mr-2"></i>
                    <p class="text-sm text-blue-700">
                        ¿No encuentras la editorial?
                    </p>
                </div>
                <button type="button" onclick="showQuickPublisherForm()"
                    class="bg-blue-500 text-white px-3 py-1 rounded text-sm hover:bg-blue-600 transition-colors">
                    <i class="fas fa-plus mr-1"></i>Agregar Nueva
                </button>
            </div>
        </div>

        {{-- Formulario rápido para agregar editorial (oculto inicialmente) --}}
        <div id="quickPublisherForm" class="hidden mt-4 p-4 bg-gray-50 rounded-lg border border-gray-200">
            <h4 class="font-medium text-gray-700 mb-3">Agregar Nueva Editorial</h4>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                <div>
                    <label class="block text-xs font-medium text-gray-600 mb-1">Nombre *</label>
                    <input type="text" id="new_publisher_name"
                        class="w-full px-3 py-2 border border-gray-300 rounded text-sm"
                        placeholder="Ingresa el nombre de la editorial">
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-600 mb-1">País</label>
                    <select id="new_publisher_country" class="w-full px-3 py-2 border border-gray-300 rounded text-sm">
                        <option value="Perú">Perú</option>
                        <option value="Argentina">Argentina</option>
                        <option value="México">México</option>
                        <option value="España">España</option>
                        <option value="Colombia">Colombia</option>
                        <option value="Chile">Chile</option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-600 mb-1">Ciudad</label>
                    <input type="text" id="new_publisher_city"
                        class="w-full px-3 py-2 border border-gray-300 rounded text-sm"
                        placeholder="Ej: Lima, Buenos Aires">
                </div>
                <div class="flex items-end space-x-2">
                    <button type="button" onclick="addNewPublisher()" id="addPublisherBtn"
                        class="bg-green-500 text-white px-4 py-2 rounded text-sm hover:bg-green-600 transition-colors flex items-center">
                        <i class="fas fa-check mr-1"></i>Agregar
                    </button>
                    <button type="button" onclick="hideQuickPublisherForm()"
                        class="bg-gray-300 text-gray-700 px-4 py-2 rounded text-sm hover:bg-gray-400 transition-colors flex items-center">
                        <i class="fas fa-times mr-1"></i>Cancelar
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script>
        // FUNCIONES QUE FALTABAN
        function showQuickPublisherForm() {
            console.log('Mostrando formulario de editorial');
            document.getElementById('quickPublisherForm').classList.remove('hidden');
            document.getElementById('new_publisher_name').focus();
        }

        function hideQuickPublisherForm() {
            console.log('Ocultando formulario de editorial');
            document.getElementById('quickPublisherForm').classList.add('hidden');

            // Limpiar campos
            document.getElementById('new_publisher_name').value = '';
            document.getElementById('new_publisher_city').value = '';
            document.getElementById('new_publisher_country').value = 'Perú';

            // Restaurar botón si estaba en estado loading
            const button = document.getElementById('addPublisherBtn');
            button.innerHTML = '<i class="fas fa-check mr-1"></i>Agregar';
            button.disabled = false;
        }

        function addNewPublisher() {
            const name = document.getElementById('new_publisher_name').value.trim();
            const country = document.getElementById('new_publisher_country').value;
            const city = document.getElementById('new_publisher_city').value.trim();

            console.log('Intentando agregar editorial:', {
                name,
                country,
                city
            });

            if (!name) {
                showNotification('El nombre de la editorial es requerido', 'error');
                document.getElementById('new_publisher_name').focus();
                return;
            }

            // Mostrar loading
            const button = document.getElementById('addPublisherBtn');
            const originalText = button.innerHTML;
            button.innerHTML = '<i class="fas fa-spinner fa-spin mr-1"></i>Creando...';
            button.disabled = true;

            // Enviar solicitud AJAX al controlador
            fetch('{{ route('admin.publishers.quick-create') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        name: name,
                        country: country,
                        city: city
                    })
                })
                .then(response => {
                    console.log('Respuesta del servidor:', response);
                    if (!response.ok) {
                        throw new Error('Error en la respuesta del servidor: ' + response.status);
                    }
                    return response.json();
                })
                .then(data => {
                    console.log('Datos recibidos:', data);

                    if (data.success) {
                        // Agregar la nueva opción al select
                        const select = document.getElementById('publisher_id');
                        const displayText = data.publisher.name + (data.publisher.city ? ' (' + data.publisher.city +
                            ')' : '');
                        const option = new Option(displayText, data.publisher.id, false, true);
                        select.appendChild(option);

                        // Forzar el cambio de valor
                        select.value = data.publisher.id;

                        // Disparar evento change para que otros scripts lo detecten
                        const event = new Event('change');
                        select.dispatchEvent(event);

                        // Ocultar el formulario y limpiar campos
                        hideQuickPublisherForm();

                        // Mostrar notificación de éxito
                        showNotification('✅ ' + data.message, 'success');
                    } else {
                        // Mostrar errores de validación
                        if (data.errors) {
                            const errorMessage = Object.values(data.errors).flat().join(', ');
                            showNotification('❌ ' + errorMessage, 'error');
                        } else {
                            showNotification('❌ ' + data.message, 'error');
                        }
                    }
                })
                .catch(error => {
                    console.error('Error en fetch:', error);
                    showNotification('❌ Error de conexión: ' + error.message, 'error');
                })
                .finally(() => {
                    // Restaurar botón
                    button.innerHTML = originalText;
                    button.disabled = false;
                });
        }

        function showNotification(message, type = 'info') {
            // Sistema de notificaciones simple - puedes mejorar esto después
            const notification = document.createElement('div');
            notification.className = `fixed top-4 right-4 p-4 rounded-lg shadow-lg z-50 ${
            type === 'success' ? 'bg-green-500 text-white' :
            type === 'error' ? 'bg-red-500 text-white' :
            'bg-blue-500 text-white'
        }`;
            notification.innerHTML = `
            <div class="flex items-center">
                <span>${message}</span>
                <button onclick="this.parentElement.parentElement.remove()" class="ml-4">×</button>
            </div>
        `;

            document.body.appendChild(notification);

            // Auto-remover después de 5 segundos
            setTimeout(() => {
                if (notification.parentElement) {
                    notification.remove();
                }
            }, 5000);
        }

        // También agregar soporte para la tecla Enter en los campos
        document.addEventListener('DOMContentLoaded', function() {
            const nameInput = document.getElementById('new_publisher_name');
            const cityInput = document.getElementById('new_publisher_city');

            if (nameInput) {
                nameInput.addEventListener('keypress', function(e) {
                    if (e.key === 'Enter') {
                        addNewPublisher();
                    }
                });
            }

            if (cityInput) {
                cityInput.addEventListener('keypress', function(e) {
                    if (e.key === 'Enter') {
                        addNewPublisher();
                    }
                });
            }
        });
    </script>
@endpush
