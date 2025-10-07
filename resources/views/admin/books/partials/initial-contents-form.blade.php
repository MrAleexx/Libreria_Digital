{{-- resources/views/admin/books/partials/initial-contents-form.blade.php --}}
<div class="bg-white rounded-lg border border-gray-200 p-6">
    <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
        <i class="fas fa-list-ol text-green-500 mr-2"></i>
        Estructura Inicial del Índice (Opcional)
    </h3>

    <p class="text-sm text-gray-600 mb-4 flex items-center">
        <i class="fas fa-info-circle text-blue-400 mr-2"></i>
        Puedes agregar una estructura básica del índice. Después de crear el libro, podrás gestionar el índice completo
        con todas las funcionalidades.
    </p>

    <div id="initial-contents-container" class="space-y-3"
        data-initial-count="{{ count(
            old('initial_contents', [
                ['chapter_title' => 'Introducción', 'level' => 0, 'sort_order' => 1],
                ['chapter_title' => 'Contenido Principal', 'level' => 0, 'sort_order' => 2],
                ['chapter_title' => 'Conclusión', 'level' => 0, 'sort_order' => 3],
            ]),
        ) }}">

        @foreach (old('initial_contents', [['chapter_title' => 'Introducción', 'level' => 0, 'sort_order' => 1], ['chapter_title' => 'Contenido Principal', 'level' => 0, 'sort_order' => 2], ['chapter_title' => 'Conclusión', 'level' => 0, 'sort_order' => 3]]) as $index => $content)
            <div class="initial-content-item border border-gray-300 p-3 rounded-md">
                <div class="grid grid-cols-1 md:grid-cols-12 gap-3">
                    <!-- Título -->
                    <div class="md:col-span-5">
                        <label class="block text-sm font-medium text-gray-700 mb-1 flex items-center">
                            <i class="fas fa-heading text-gray-400 mr-1 text-xs"></i>
                            Título
                        </label>
                        <input type="text" name="initial_contents[{{ $index }}][chapter_title]"
                            value="{{ $content['chapter_title'] ?? '' }}" placeholder="Ej: Capítulo 1"
                            class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-500">
                    </div>

                    <!-- Nivel -->
                    <div class="md:col-span-3">
                        <label class="block text-sm font-medium text-gray-700 mb-1 flex items-center">
                            <i class="fas fa-layer-group text-gray-400 mr-1 text-xs"></i>
                            Nivel
                        </label>
                        <select name="initial_contents[{{ $index }}][level]"
                            class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-500">
                            <option value="0" {{ ($content['level'] ?? 0) == 0 ? 'selected' : '' }}>Principal
                            </option>
                            <option value="1" {{ ($content['level'] ?? 0) == 1 ? 'selected' : '' }}>Nivel 1
                            </option>
                            <option value="2" {{ ($content['level'] ?? 0) == 2 ? 'selected' : '' }}>Nivel 2
                            </option>
                        </select>
                    </div>

                    <!-- Orden -->
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1 flex items-center">
                            <i class="fas fa-sort-numeric-down text-gray-400 mr-1 text-xs"></i>
                            Orden
                        </label>
                        <input type="number" name="initial_contents[{{ $index }}][sort_order]"
                            value="{{ $content['sort_order'] ?? $index + 1 }}" min="1"
                            class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-500">
                    </div>

                    <!-- Eliminar -->
                    <div class="md:col-span-2 flex items-end">
                        @if ($index > 2)
                            {{-- No eliminar los 3 básicos --}}
                            <button type="button"
                                class="remove-content-btn bg-red-500 text-white px-3 py-2 rounded-md hover:bg-red-600 transition-colors text-sm flex items-center">
                                <i class="fas fa-trash mr-1"></i>
                                Eliminar
                            </button>
                        @endif
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <button type="button"
        class="add-content-btn mt-4 bg-green-500 text-white px-4 py-2 rounded-md hover:bg-green-600 transition-colors flex items-center">
        <i class="fas fa-plus mr-2"></i>
        Agregar Sección
    </button>
</div>
