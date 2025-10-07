{{-- resources/views/admin/books/partials/form-layout.blade.blade.php --}}
<form action="{{ $action }}" method="POST" enctype="multipart/form-data">
    @csrf
    @if ($method !== 'POST')
        @method($method)
    @endif

    <div class="space-y-6">
        <!-- Información Básica -->
        @include('admin.books.partials.form-sections.basic-info', ['book' => $book])

        <!-- Identificadores -->
        @include('admin.books.partials.form-sections.identifiers', ['book' => $book])

        <!-- Información Editorial -->
        @include('admin.books.partials.form-sections.publisher-info', ['book' => $book])

        <!-- Archivos -->
        @include('admin.books.partials.form-sections.files', ['book' => $book])

        <!-- Detalles Técnicos -->
        @include('admin.books.partials.form-sections.technical-details', ['book' => $book])

        <!-- Información Comercial -->
        @include('admin.books.partials.form-sections.commercial-info', ['book' => $book])

        <!-- Estados -->
        @include('admin.books.partials.form-sections.status', ['book' => $book])

        <!-- Botones de acción -->
        <div class="flex justify-end space-x-4 pt-6 border-t border-gray-200">
            <a href="{{ route('admin.books.index') }}"
                class="bg-gray-300 text-gray-700 px-6 py-2 rounded-lg hover:bg-gray-400 transition-colors duration-200 flex items-center">
                <i class="fas fa-times mr-2"></i>
                Cancelar
            </a>
            <button type="submit"
                class="bg-orange-500 text-white px-6 py-2 rounded-lg hover:bg-orange-600 transition-colors duration-200 flex items-center">
                <i class="fas fa-save mr-2"></i>
                {{ $book ? 'Actualizar' : 'Crear' }} Libro
            </button>
        </div>
    </div>
</form>
