{{-- resources/views/admin/books/partials/contributors-form.blade.php --}}
<div class="bg-white rounded-lg border border-gray-200 p-6">
    <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
        <i class="fas fa-users text-blue-500 mr-2"></i>
        Autores y Contribuidores
    </h3>

    <div id="contributors-container" class="space-y-4"
        data-initial-count="{{ count(old('contributors', [['contributor_type' => 'author', 'sequence_number' => 1]])) }}">

        @foreach (old('contributors', [['contributor_type' => 'author', 'sequence_number' => 1]]) as $index => $contributor)
            <div class="contributor-item border border-gray-300 p-4 rounded-md">
                <div class="grid grid-cols-1 md:grid-cols-12 gap-4">
                    <!-- Tipo de Contribuidor -->
                    <div class="md:col-span-3">
                        <label class="block text-sm font-medium text-gray-700 mb-1 flex items-center">
                            <i class="fas fa-tag text-gray-400 mr-1 text-xs"></i>
                            Tipo
                        </label>
                        <select name="contributors[{{ $index }}][contributor_type]"
                            class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="author"
                                {{ ($contributor['contributor_type'] ?? 'author') == 'author' ? 'selected' : '' }}>
                                Autor
                            </option>
                            <option value="editor"
                                {{ ($contributor['contributor_type'] ?? '') == 'editor' ? 'selected' : '' }}>
                                Editor
                            </option>
                            <option value="translator"
                                {{ ($contributor['contributor_type'] ?? '') == 'translator' ? 'selected' : '' }}>
                                Traductor
                            </option>
                            <option value="illustrator"
                                {{ ($contributor['contributor_type'] ?? '') == 'illustrator' ? 'selected' : '' }}>
                                Ilustrador
                            </option>
                        </select>
                    </div>

                    <!-- Nombre Completo -->
                    <div class="md:col-span-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1 flex items-center">
                            <i class="fas fa-user text-gray-400 mr-1 text-xs"></i>
                            Nombre Completo *
                        </label>
                        <input type="text" name="contributors[{{ $index }}][full_name]"
                            value="{{ $contributor['full_name'] ?? '' }}" placeholder="Ej: Alex Taya Yactayo"
                            class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                            required>
                    </div>

                    <!-- Orden -->
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1 flex items-center">
                            <i class="fas fa-sort-numeric-down text-gray-400 mr-1 text-xs"></i>
                            Orden
                        </label>
                        <input type="number" name="contributors[{{ $index }}][sequence_number]"
                            value="{{ $contributor['sequence_number'] ?? $index + 1 }}" min="1"
                            class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>

                    <!-- Botón Eliminar -->
                    <div class="md:col-span-3 flex items-end">
                        @if ($index > 0)
                            <button type="button"
                                class="remove-contributor-btn bg-red-500 text-white px-3 py-2 rounded-md hover:bg-red-600 transition-colors flex items-center">
                                <i class="fas fa-trash mr-1"></i>
                                Eliminar
                            </button>
                        @endif
                    </div>
                </div>

                <!-- Email y Biografía -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-3">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1 flex items-center">
                            <i class="fas fa-envelope text-gray-400 mr-1 text-xs"></i>
                            Email
                        </label>
                        <input type="email" name="contributors[{{ $index }}][email]"
                            value="{{ $contributor['email'] ?? '' }}" placeholder="email@ejemplo.com"
                            class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1 flex items-center">
                            <i class="fas fa-info-circle text-gray-400 mr-1 text-xs"></i>
                            Nota Biográfica
                        </label>
                        <textarea name="contributors[{{ $index }}][biographical_note]" rows="2"
                            placeholder="Breve biografía o información relevante"
                            class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">{{ $contributor['biographical_note'] ?? '' }}</textarea>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <button type="button"
        class="add-contributor-btn mt-4 bg-green-500 text-white px-4 py-2 rounded-md hover:bg-green-600 transition-colors flex items-center">
        <i class="fas fa-user-plus mr-2"></i>
        Agregar Contribuidor
    </button>
</div>
