{{-- resources/views/livewire/book-contents-manager.blade.php --}}
<div class="bg-white rounded-lg border border-gray-200" x-data="{
    showNotification: false,
    notificationMessage: '',
    notificationType: 'success',

    showSuccess(message) {
        this.notificationMessage = message;
        this.notificationType = 'success';
        this.showNotification = true;
        setTimeout(() => this.showNotification = false, 4000);
    },

    showWarning(message) {
        this.notificationMessage = message;
        this.notificationType = 'warning';
        this.showNotification = true;
        setTimeout(() => this.showNotification = false, 4000);
    },

    showError(message) {
        this.notificationMessage = message;
        this.notificationType = 'error';
        this.showNotification = true;
        setTimeout(() => this.showNotification = false, 5000);
    }
}"
    x-on:index-cleared.window="showSuccess($event.detail.message)"
    x-on:selected-deleted.window="showSuccess($event.detail.message)"
    x-on:content-deleted.window="showSuccess($event.detail.message)"
    x-on:template-applied.window="showSuccess($event.detail.message)"
    x-on:import-success.window="showSuccess($event.detail.message)"
    x-on:export-success.window="showSuccess($event.detail.message)"
    x-on:content-added.window="showSuccess($event.detail.message)"
    x-on:content-updated.window="showSuccess($event.detail.message)"
    x-on:no-selection.window="showWarning($event.detail.message)">

    <!-- Notificación Toast -->
    <div x-show="showNotification" x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 transform translate-y-2"
        x-transition:enter-end="opacity-100 transform translate-y-0"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100 transform translate-y-0"
        x-transition:leave-end="opacity-0 transform translate-y-2"
        class="fixed top-4 right-4 z-50 max-w-sm w-full text-white p-4 rounded-lg shadow-lg border-l-4"
        :class="{
            'bg-green-500 border-green-600': notificationType === 'success',
            'bg-blue-500 border-blue-600': notificationType === 'info',
            'bg-yellow-500 border-yellow-600': notificationType === 'warning',
            'bg-red-500 border-red-600': notificationType === 'error'
        }">
        <div class="flex items-start">
            <i class="fas text-lg mr-3 mt-0.5"
                :class="{
                    'fa-check-circle': notificationType === 'success',
                    'fa-info-circle': notificationType === 'info',
                    'fa-exclamation-triangle': notificationType === 'warning',
                    'fa-exclamation-circle': notificationType === 'error'
                }"></i>
            <div class="flex-1">
                <p x-text="notificationMessage" class="text-sm font-medium"></p>
            </div>
            <button @click="showNotification = false" class="ml-4 text-white hover:text-gray-200">
                <i class="fas fa-times"></i>
            </button>
        </div>
    </div>

    <!-- Contenido Principal -->
    <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
        <h3 class="text-lg font-semibold flex items-center">
            <i class="fas fa-list-ol text-green-500 mr-2"></i>
            Gestión de Contenido/Índice
        </h3>
        <div class="flex space-x-2">
            <button type="button" wire:click="$set('showImportForm', true)"
                class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 transition-colors duration-200 flex items-center">
                <i class="fas fa-bolt mr-2"></i>
                Plantillas Rápidas
            </button>
            <button type="button" wire:click="$set('showForm', true)"
                class="bg-orange-500 text-white px-4 py-2 rounded-lg hover:bg-orange-600 transition-colors duration-200 flex items-center">
                <i class="fas fa-plus mr-2"></i>
                Agregar Manual
            </button>
        </div>
    </div>

    <!-- Formulario para Agregar/Editar Manualmente -->
    @if ($showForm)
        <div class="px-6 py-4 border-b border-gray-200 bg-orange-50">
            <h4 class="text-md font-medium text-gray-700 mb-4 flex items-center">
                <i class="fas {{ $editingIndex === null ? 'fa-plus' : 'fa-edit' }} text-orange-500 mr-2"></i>
                {{ $editingIndex === null ? 'Agregar Nuevo Elemento' : 'Editar Elemento' }}
            </h4>

            <!-- DEBUG TEMPORAL -->
            @if ($editingIndex !== null)
                <div class="mb-4 p-2 bg-yellow-100 border border-yellow-300 rounded">
                    <p class="text-sm text-yellow-800">
                        <strong>Debug:</strong>
                        Editando índice {{ $editingIndex }} -
                        Nivel cargado: {{ $form['level'] }} -
                        Título: {{ $form['chapter_title'] }}
                    </p>
                </div>
            @endif

            <form wire:submit.prevent="{{ $editingIndex === null ? 'addContent' : 'updateContent' }}">
                <div class="grid grid-cols-1 gap-4">
                    <div>
                        <label for="chapter_title" class="block text-sm font-medium text-gray-700 mb-2">
                            Título del Elemento *
                        </label>
                        <input type="text" id="chapter_title" wire:model="form.chapter_title"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500"
                            placeholder="Ej: 1. Introducción a los Prompts">
                        @error('form.chapter_title')
                            <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label for="sort_order" class="block text-sm font-medium text-gray-700 mb-2">
                                Orden *
                            </label>
                            <input type="number" id="sort_order" wire:model="form.sort_order" min="0"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500">
                            @error('form.sort_order')
                                <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                            @enderror
                        </div>

                        <div>
                            <label for="level" class="block text-sm font-medium text-gray-700 mb-2">
                                Nivel Jerárquico *
                            </label>
                            <select id="level" wire:model="form.level"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500">
                                <option value="0">Tema Principal</option>
                                <option value="1">Subtema (Nivel 1)</option>
                                <option value="2">Subtema (Nivel 2)</option>
                                <option value="3">Subtema (Nivel 3)</option>
                                <option value="4">Subtema (Nivel 4)</option>
                            </select>
                            @error('form.level')
                                <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div>
                        <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                            Descripción (Opcional)
                        </label>
                        <textarea id="description" wire:model="form.description" rows="2"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500"
                            placeholder="Breve descripción del contenido..."></textarea>
                    </div>
                </div>

                <div class="flex justify-end space-x-3 mt-4">
                    <button type="button" wire:click="cancelEdit"
                        class="bg-gray-300 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-400 transition-colors duration-200">
                        <i class="fas fa-times mr-2"></i>
                        Cancelar
                    </button>
                    <button type="submit"
                        class="bg-orange-500 text-white px-4 py-2 rounded-lg hover:bg-orange-600 transition-colors duration-200">
                        <i class="fas {{ $editingIndex === null ? 'fa-plus' : 'fa-save' }} mr-2"></i>
                        {{ $editingIndex === null ? 'Agregar' : 'Actualizar' }}
                    </button>
                </div>
            </form>
        </div>
    @endif

    <!-- Formulario de Importación -->
    @if ($showImportForm)
        <div class="px-6 py-4 border-b border-gray-200 bg-blue-50">
            <h4 class="text-md font-medium text-gray-700 mb-4 flex items-center">
                <i class="fas fa-bolt text-blue-500 mr-2"></i>
                Plantillas Rápidas
            </h4>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <button type="button" wire:click="generatePromptBookTemplate"
                    class="bg-green-500 text-white px-4 py-3 rounded-lg hover:bg-green-600 transition-colors duration-200 flex items-center justify-center">
                    <i class="fas fa-book mr-2"></i>
                    Libro de Prompts Educativos
                </button>

                <button type="button" wire:click="generateGenericTemplate"
                    class="bg-purple-500 text-white px-4 py-3 rounded-lg hover:bg-purple-600 transition-colors duration-200 flex items-center justify-center">
                    <i class="fas fa-shapes mr-2"></i>
                    Plantilla Genérica
                </button>
            </div>

            <div class="mt-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    O importar desde texto:
                    <textarea wire:model="importText" rows="4"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                        placeholder="Pega aquí tu índice..."></textarea>
                    <div class="flex justify-end space-x-3 mt-3">
                        <button type="button" wire:click="$set('showImportForm', false)"
                            class="bg-gray-300 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-400 transition-colors duration-200">
                            Cancelar
                        </button>
                        <button type="button" wire:click="importFromText"
                            class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 transition-colors duration-200">
                            Importar
                        </button>
                    </div>
            </div>
        </div>
    @endif

    <!-- Lista de Contenido Existente -->
    <div class="px-6 py-4">
        @if (count($contents) > 0)
            <div class="mb-4 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                <div class="flex items-center space-x-4">
                    <label class="flex items-center">
                        <input type="checkbox" wire:model="selectAll"
                            class="rounded border-gray-300 text-orange-600 focus:ring-orange-500">
                        <span class="ml-2 text-sm text-gray-700">Seleccionar todo</span>
                    </label>

                    @if (count($selectedItems) > 0)
                        <span class="text-sm text-gray-600 bg-orange-100 px-2 py-1 rounded">
                            {{ count($selectedItems) }} seleccionados
                        </span>
                    @endif
                </div>

                <div class="flex space-x-2">
                    @if (count($selectedItems) > 0)
                        <button wire:click="deleteSelected"
                            wire:confirm="¿Estás seguro de que quieres eliminar {{ count($selectedItems) }} elemento(s) seleccionado(s)?"
                            class="bg-red-500 text-white px-3 py-1 rounded text-sm hover:bg-red-600 transition-colors duration-200 flex items-center">
                            <i class="fas fa-trash mr-1"></i>Eliminar Seleccionados
                        </button>
                    @endif
                    <button wire:click="exportToText"
                        class="bg-green-500 text-white px-3 py-1 rounded text-sm hover:bg-green-600 transition-colors duration-200 flex items-center">
                        <i class="fas fa-copy mr-1"></i>Copiar Índice
                    </button>
                    <button wire:click="clearIndex"
                        wire:confirm="¿Estás seguro de que quieres eliminar TODO el índice? Esta acción no se puede deshacer."
                        class="bg-gray-500 text-white px-3 py-1 rounded text-sm hover:bg-gray-600 transition-colors duration-200 flex items-center">
                        <i class="fas fa-broom mr-1"></i>Limpiar Todo
                    </button>
                </div>
            </div>

            <!-- Vista de árbol mejorada -->
            <div class="border border-gray-200 rounded-lg overflow-hidden">
                @foreach ($contents as $index => $content)
                    @php
                        $level = $content['level'] ?? 0;
                        $paddingLeft = $level * 24; // 24px por cada nivel
                        $bgColor = match ($level) {
                            0 => 'bg-white',
                            1 => 'bg-blue-50',
                            2 => 'bg-green-50',
                            3 => 'bg-yellow-50',
                            4 => 'bg-purple-50',
                            default => 'bg-white',
                        };
                        $borderColor = match ($level) {
                            0 => 'border-l-4 border-l-orange-500',
                            1 => 'border-l-4 border-l-blue-500',
                            2 => 'border-l-4 border-l-green-500',
                            3 => 'border-l-4 border-l-yellow-500',
                            4 => 'border-l-4 border-l-purple-500',
                            default => '',
                        };
                    @endphp
                    <div class="flex items-center p-3 border-b border-gray-200 hover:bg-gray-50 transition-colors duration-200 {{ $bgColor }} {{ $borderColor }}"
                        style="padding-left: {{ $paddingLeft }}px">

                        <!-- Checkbox de selección -->
                        <div class="flex-shrink-0 mr-3">
                            <input type="checkbox" wire:model="selectedItems" value="{{ $content['id'] }}"
                                class="rounded border-gray-300 text-orange-600 focus:ring-orange-500">
                        </div>

                        <!-- Contenido -->
                        <div class="flex-1">
                            <div class="flex items-center space-x-3 mb-1">
                                @if ($content['chapter_number'])
                                    <span class="bg-orange-100 text-orange-800 text-xs font-medium px-2 py-1 rounded">
                                        {{ $content['chapter_number'] }}
                                    </span>
                                @endif
                                <span class="font-medium text-gray-900">{{ $content['chapter_title'] }}</span>
                                @if ($level > 0)
                                    <span class="text-xs text-gray-500 bg-gray-200 px-2 py-1 rounded">
                                        Nivel {{ $level }}
                                    </span>
                                @endif
                            </div>
                            @if ($content['description'] && $content['description'] !== 'Contenido del libro')
                                <p class="text-xs text-gray-600 flex items-center">
                                    <i class="fas fa-info-circle mr-1"></i>
                                    {{ $content['description'] }}
                                </p>
                            @endif
                        </div>

                        <!-- Orden y acciones -->
                        <div class="flex items-center space-x-3">
                            <span class="text-sm text-gray-500 bg-gray-100 px-2 py-1 rounded">
                                <i class="fas fa-sort-numeric-down mr-1"></i>
                                {{ $content['sort_order'] }}
                            </span>
                            <div class="flex space-x-1">
                                <button wire:click="editContent({{ $index }})"
                                    class="text-blue-600 hover:text-blue-800 p-1 rounded transition-colors duration-200"
                                    title="Editar">
                                    <i class="fas fa-edit text-sm"></i>
                                </button>
                                <button wire:click="deleteContent({{ $index }})"
                                    wire:confirm="¿Estás seguro de que quieres eliminar este elemento del índice?"
                                    class="text-red-600 hover:text-red-800 p-1 rounded transition-colors duration-200"
                                    title="Eliminar">
                                    <i class="fas fa-trash text-sm"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Vista previa formateada -->
            <!-- Vista previa formateada -->
            <div class="mt-6">
                <h5 class="font-semibold text-gray-700 mb-3 flex items-center">
                    <i class="fas fa-eye mr-2"></i>
                    Vista Previa del Índice
                </h5>
                <div class="p-4 border border-gray-300 rounded-lg bg-white">
                    <div class="text-center font-semibold mb-3 text-gray-700 text-lg">ÍNDICE</div>
                    @foreach ($contents as $content)
                        @php
                            $level = $content['level'] ?? 0;
                            $indentation = $level * 20; // 20px por nivel
                            $title = $this->cleanTitle($content['chapter_title']);
                        @endphp
                        <div class="py-1 px-2 hover:bg-gray-50" style="padding-left: {{ $indentation }}px">
                            {{ $title }}
                        </div>
                    @endforeach
                </div>
            </div>
        @else
            <!-- Estado vacío -->
            <div class="text-center py-12 text-gray-500">
                <i class="fas fa-list-ol text-5xl mb-4 text-gray-300"></i>
                <p class="text-lg mb-2">No hay contenido en el índice</p>
                <p class="text-sm text-gray-400 mb-6">Comienza usando una plantilla rápida o agregando contenido
                    manualmente</p>
            </div>
        @endif
    </div>
</div>

<script>
    document.addEventListener('livewire:init', () => {
        Livewire.on('copy-to-clipboard', (event) => {
            navigator.clipboard.writeText(event.text).then(() => {
                // El éxito se maneja con la notificación Alpine
            }).catch(err => {
                console.error('Error al copiar: ', err);
            });
        });
    });
</script>
