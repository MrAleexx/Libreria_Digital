{{-- resources/views/admin/books/form/form-basic.blade.php --}}
@props(['book' => null, 'categories' => [], 'publishers' => [], 'languages' => []])

<div class="space-y-6">
    <!-- Título e ISBN -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
            <label for="title" class="block text-sm font-medium text-gray-700 mb-1">
                Título del Libro *
            </label>
            <input type="text" name="title" id="title" value="{{ old('title', $book->title ?? '') }}" required
                class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('title') border-red-300 @enderror"
                placeholder="Ingresa el título completo del libro">
            @error('title')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="isbn" class="block text-sm font-medium text-gray-700 mb-1">
                ISBN *
            </label>
            <input type="text" name="isbn" id="isbn" value="{{ old('isbn', $book->isbn ?? '') }}" required
                class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('isbn') border-red-300 @enderror"
                placeholder="Ej: 9786120313879">
            @error('isbn')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>
    </div>

    <!-- Editorial con creación rápida -->
    <div>
        <label for="publisher_id" class="block text-sm font-medium text-gray-700 mb-1">
            Editorial *
        </label>
        <div class="flex space-x-3">
            <select name="publisher_id" id="publisher_id" required
                class="flex-1 border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('publisher_id') border-red-300 @enderror">
                <option value="">Selecciona una editorial</option>
                @foreach ($publishers as $publisher)
                    <option value="{{ $publisher->id }}"
                        {{ old('publisher_id', $book->publisher_id ?? '') == $publisher->id ? 'selected' : '' }}>
                        {{ $publisher->name }} {{ $publisher->city ? "({$publisher->city})" : '' }}
                    </option>
                @endforeach
            </select>
            <button type="button" onclick="openPublisherModal()"
                class="inline-flex items-center px-3 py-2 border border-gray-300 shadow-sm text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                <i class="fas fa-plus mr-1"></i>
                Nueva
            </button>
        </div>
        @error('publisher_id')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <!-- Idioma y Año de Publicación -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
            <label for="language_code" class="block text-sm font-medium text-gray-700 mb-1">
                Idioma *
            </label>
            <select name="language_code" id="language_code" required
                class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('language_code') border-red-300 @enderror">
                <option value="">Selecciona un idioma</option>
                @foreach ($languages as $language)
                    <option value="{{ $language->code }}"
                        {{ old('language_code', $book->language_code ?? 'es') == $language->code ? 'selected' : '' }}>
                        {{ $language->native_name }} ({{ $language->name }})
                    </option>
                @endforeach
            </select>
            @error('language_code')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="publication_year" class="block text-sm font-medium text-gray-700 mb-1">
                Año de Publicación *
            </label>
            <input type="number" name="publication_year" id="publication_year"
                value="{{ old('publication_year', $book->publication_year ?? date('Y')) }}" min="1900"
                max="{{ date('Y') }}" required
                class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('publication_year') border-red-300 @enderror">
            @error('publication_year')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>
    </div>

    <!-- Páginas y Tipo de Libro -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
            <label for="pages" class="block text-sm font-medium text-gray-700 mb-1">
                Número de Páginas *
            </label>
            <input type="number" name="pages" id="pages" value="{{ old('pages', $book->pages ?? '') }}"
                min="1" required
                class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('pages') border-red-300 @enderror"
                placeholder="Ej: 250">
            @error('pages')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="book_type" class="block text-sm font-medium text-gray-700 mb-1">
                Tipo de Libro *
            </label>
            <select name="book_type" id="book_type" required
                class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('book_type') border-red-300 @enderror">
                <option value="digital"
                    {{ old('book_type', $book->book_type ?? 'digital') == 'digital' ? 'selected' : '' }}>Digital
                </option>
                <option value="physical"
                    {{ old('book_type', $book->book_type ?? '') == 'physical' ? 'selected' : '' }}>Físico</option>
                <option value="both" {{ old('book_type', $book->book_type ?? '') == 'both' ? 'selected' : '' }}>Mixto
                    (Digital y Físico)</option>
            </select>
            @error('book_type')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>
    </div>

    <!-- Categorías -->
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-2">
            Categorías
        </label>
        <div
            class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-2 max-h-48 overflow-y-auto p-3 border border-gray-300 rounded-md">
            @foreach ($categories as $category)
                <label class="inline-flex items-center">
                    <input type="checkbox" name="categories[]" value="{{ $category->id }}"
                        {{ in_array($category->id, old('categories', $book->categories->pluck('id')->toArray() ?? [])) ? 'checked' : '' }}
                        class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    <span class="ml-2 text-sm text-gray-700">{{ $category->name }}</span>
                </label>
            @endforeach
        </div>
        @error('categories')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <!-- Descripción -->
    <div>
        <label for="description" class="block text-sm font-medium text-gray-700 mb-1">
            Descripción
        </label>
        <textarea name="description" id="description" rows="4"
            class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('description') border-red-300 @enderror"
            placeholder="Describe el contenido, temática y objetivo del libro...">{{ old('description', $book->details->description ?? '') }}</textarea>
        @error('description')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>
</div>

<!-- Modal para creación rápida de editorial -->
<div id="publisherModal" class="fixed inset-0 overflow-y-auto hidden" style="z-index: 9999;">
    <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" onclick="closePublisherModal()"></div>

        <div
            class="inline-block align-bottom bg-white rounded-lg px-4 pt-5 pb-4 text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full sm:p-6">
            <div>
                <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">
                    Crear Nueva Editorial
                </h3>

                <!-- AGREGAR novalidate Y cambiar el form -->
                <form id="quickPublisherForm" class="space-y-4" novalidate>
                    @csrf
                    <div>
                        <label for="publisher_name" class="block text-sm font-medium text-gray-700">Nombre *</label>
                        <input type="text" name="name" id="publisher_name" required
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label for="publisher_city" class="block text-sm font-medium text-gray-700">Ciudad</label>
                            <input type="text" name="city" id="publisher_city"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        </div>
                        <div>
                            <label for="publisher_country" class="block text-sm font-medium text-gray-700">País
                                *</label>
                            <select name="country" id="publisher_country" required
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                <option value="Perú" selected>Perú</option>
                                <option value="Argentina">Argentina</option>
                                <option value="México">México</option>
                                <option value="España">España</option>
                                <option value="Colombia">Colombia</option>
                                <option value="Chile">Chile</option>
                            </select>
                        </div>
                    </div>
                </form>
            </div>

            <div class="mt-5 sm:mt-6 sm:grid sm:grid-cols-2 sm:gap-3 sm:grid-flow-row-dense">
                <button type="button" onclick="saveQuickPublisher()"
                    class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:col-start-2 sm:text-sm">
                    Crear Editorial
                </button>
                <button type="button" onclick="closePublisherModal()"
                    class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:mt-0 sm:col-start-1 sm:text-sm">
                    Cancelar
                </button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script>
        function openPublisherModal() {
            document.getElementById('publisherModal').classList.remove('hidden');
        }

        function closePublisherModal() {
            document.getElementById('publisherModal').classList.add('hidden');
            document.getElementById('quickPublisherForm').reset();
        }

        function saveQuickPublisher() {
            const form = document.getElementById('quickPublisherForm');
            const formData = new FormData(form);

            // Validación manual antes de enviar
            const publisherName = document.getElementById('publisher_name').value;
            const publisherCountry = document.getElementById('publisher_country').value;

            if (!publisherName.trim()) {
                alert('El nombre de la editorial es obligatorio');
                return;
            }

            if (!publisherCountry) {
                alert('El país es obligatorio');
                return;
            }

            fetch('{{ route('admin.books.quick-create-publisher') }}', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json',
                    },
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Agregar la nueva editorial al select
                        const select = document.getElementById('publisher_id');
                        const option = new Option(data.publisher.name + (data.publisher.city ?
                            ` (${data.publisher.city})` : ''), data.publisher.id);
                        select.add(option);
                        select.value = data.publisher.id;

                        closePublisherModal();
                        alert('Editorial creada exitosamente');
                    } else {
                        alert(data.message || 'Error al crear la editorial');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Error al crear la editorial');
                });
        }

        function showNotification(message, type) {
            // Implementar notificación toast según tu sistema
            alert(message); // Temporal
        }
    </script>
@endpush
