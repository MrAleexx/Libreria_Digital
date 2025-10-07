{{-- resources/views/livewire/book-contributors-manager.blade.php --}}
<div class="bg-white rounded-lg border border-gray-200">
    <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
        <h3 class="text-lg font-semibold flex items-center">
            <i class="fas fa-users text-blue-500 mr-2"></i>
            Gestión de Contribuidores
        </h3>
        <button type="button" wire:click="$set('showForm', true)"
            class="bg-orange-500 text-white px-4 py-2 rounded-lg hover:bg-orange-600 transition-colors duration-200 flex items-center">
            <i class="fas fa-user-plus mr-2"></i>
            Agregar Contribuidor
        </button>
    </div>

    <!-- Formulario -->
    @if ($showForm)
        <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
            <h4 class="text-md font-medium text-gray-700 mb-4 flex items-center">
                <i class="fas {{ $editingIndex === null ? 'fa-user-plus' : 'fa-user-edit' }} text-orange-500 mr-2"></i>
                {{ $editingIndex === null ? 'Agregar Nuevo Contribuidor' : 'Editar Contribuidor' }}
            </h4>

            <form wire:submit.prevent="{{ $editingIndex === null ? 'addContributor' : 'updateContributor' }}">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="contributor_type"
                            class="block text-sm font-medium text-gray-700 mb-2 flex items-center">
                            <i class="fas fa-tag text-gray-400 mr-2 text-xs"></i>
                            Tipo *
                        </label>
                        <select id="contributor_type" wire:model="form.contributor_type"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500">
                            <option value="author">Autor</option>
                            <option value="editor">Editor</option>
                            <option value="translator">Traductor</option>
                        </select>
                        @error('form.contributor_type')
                            <span class="text-red-500 text-sm flex items-center mt-1">
                                <i class="fas fa-exclamation-circle mr-1"></i>
                                {{ $message }}
                            </span>
                        @enderror
                    </div>

                    <div>
                        <label for="sequence_number"
                            class="block text-sm font-medium text-gray-700 mb-2 flex items-center">
                            <i class="fas fa-sort-numeric-down text-gray-400 mr-2 text-xs"></i>
                            Número de Secuencia *
                        </label>
                        <input type="number" id="sequence_number" wire:model="form.sequence_number" min="1"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500">
                        @error('form.sequence_number')
                            <span class="text-red-500 text-sm flex items-center mt-1">
                                <i class="fas fa-exclamation-circle mr-1"></i>
                                {{ $message }}
                            </span>
                        @enderror
                    </div>

                    <div class="md:col-span-2">
                        <label for="full_name" class="block text-sm font-medium text-gray-700 mb-2 flex items-center">
                            <i class="fas fa-user text-gray-400 mr-2 text-xs"></i>
                            Nombre Completo *
                        </label>
                        <input type="text" id="full_name" wire:model="form.full_name"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500">
                        @error('form.full_name')
                            <span class="text-red-500 text-sm flex items-center mt-1">
                                <i class="fas fa-exclamation-circle mr-1"></i>
                                {{ $message }}
                            </span>
                        @enderror
                    </div>

                    <div class="md:col-span-2">
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-2 flex items-center">
                            <i class="fas fa-envelope text-gray-400 mr-2 text-xs"></i>
                            Email
                        </label>
                        <input type="email" id="email" wire:model="form.email"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500">
                        @error('form.email')
                            <span class="text-red-500 text-sm flex items-center mt-1">
                                <i class="fas fa-exclamation-circle mr-1"></i>
                                {{ $message }}
                            </span>
                        @enderror
                    </div>

                    <div class="md:col-span-2">
                        <label for="biographical_note"
                            class="block text-sm font-medium text-gray-700 mb-2 flex items-center">
                            <i class="fas fa-info-circle text-gray-400 mr-2 text-xs"></i>
                            Nota Biográfica
                        </label>
                        <textarea id="biographical_note" wire:model="form.biographical_note" rows="3"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500"></textarea>
                        @error('form.biographical_note')
                            <span class="text-red-500 text-sm flex items-center mt-1">
                                <i class="fas fa-exclamation-circle mr-1"></i>
                                {{ $message }}
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="flex justify-end space-x-3 mt-4">
                    <button type="button" wire:click="cancelEdit"
                        class="bg-gray-300 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-400 transition-colors duration-200 flex items-center">
                        <i class="fas fa-times mr-2"></i>
                        Cancelar
                    </button>
                    <button type="submit"
                        class="bg-orange-500 text-white px-4 py-2 rounded-lg hover:bg-orange-600 transition-colors duration-200 flex items-center">
                        <i class="fas {{ $editingIndex === null ? 'fa-plus' : 'fa-save' }} mr-2"></i>
                        {{ $editingIndex === null ? 'Agregar' : 'Actualizar' }}
                    </button>
                </div>
            </form>
        </div>
    @endif

    <!-- Lista de Contribuidores -->
    <div class="px-6 py-4">
        @if (session()->has('message'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4 flex items-center">
                <i class="fas fa-check-circle mr-2"></i>
                {{ session('message') }}
            </div>
        @endif

        @if (count($contributors) > 0)
            <div class="space-y-3">
                @foreach ($contributors as $index => $contributor)
                    <div
                        class="flex items-center justify-between p-3 border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors duration-200">
                        <div class="flex items-center space-x-4">
                            <span
                                class="px-2 py-1 text-xs rounded-full flex items-center
                        @switch($contributor['contributor_type'])
                            @case('author') bg-blue-100 text-blue-800 @break
                            @case('editor') bg-green-100 text-green-800 @break
                            @case('translator') bg-purple-100 text-purple-800 @break
                            @default bg-gray-100 text-gray-800
                        @endswitch">
                                <i
                                    class="fas
                            @switch($contributor['contributor_type'])
                                @case('author') fa-user-edit @break
                                @case('editor') fa-edit @break
                                @case('translator') fa-language @break
                                @default fa-user
                            @endswitch mr-1">
                                </i>
                                {{ ucfirst($contributor['contributor_type']) }}
                            </span>
                            <div>
                                <h4 class="font-medium text-gray-900">{{ $contributor['full_name'] }}</h4>
                                @if ($contributor['email'])
                                    <p class="text-sm text-gray-600 flex items-center">
                                        <i class="fas fa-envelope mr-1"></i>
                                        {{ $contributor['email'] }}
                                    </p>
                                @endif
                            </div>
                        </div>
                        <div class="flex items-center space-x-2">
                            <span class="text-sm text-gray-500 flex items-center">
                                <i class="fas fa-sort-numeric-down mr-1"></i>
                                #{{ $contributor['sequence_number'] }}
                            </span>
                            <button wire:click="editContributor({{ $index }})"
                                class="text-blue-600 hover:text-blue-800 transition-colors duration-200 p-1 rounded"
                                title="Editar">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button wire:click="deleteContributor({{ $index }})"
                                class="text-red-600 hover:text-red-800 transition-colors duration-200 p-1 rounded"
                                title="Eliminar"
                                onclick="return confirm('¿Estás seguro de eliminar este contribuidor?')">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-8 text-gray-500">
                <i class="fas fa-users text-4xl mb-3 text-gray-300"></i>
                <p>No hay contribuidores agregados aún.</p>
            </div>
        @endif
    </div>
</div>
