{{-- resources/views/admin/books/partials/form-layout.blade.php --}}
<form action="{{ $action }}" method="POST" enctype="multipart/form-data" id="bookForm">
    @csrf
    @if (isset($method) && $method !== 'POST')
        @method($method)
    @endif

    <div class="space-y-6">
        <!-- Solo incluir las secciones básicas -->
        @include('admin.books.partials.form-sections.basic-info')
        @include('admin.books.partials.form-sections.identifiers')
        @include('admin.books.partials.form-sections.publisher-info')
        @include('admin.books.partials.form-sections.technical-details')
        @include('admin.books.partials.form-sections.optional-details')
        @include('admin.books.partials.form-sections.library-info')
        @include('admin.books.partials.form-sections.status')
        @include('admin.books.partials.form-sections.files')

        <!-- Botones de acción -->
        <div class="flex justify-end space-x-4 pt-6 border-t border-gray-200">
            <a href="{{ route('admin.books.index') }}" type="button"
                class="bg-gray-300 text-gray-700 px-6 py-2 rounded-lg hover:bg-gray-400 transition-colors duration-200 flex items-center">
                <i class="fas fa-arrow-left mr-2"></i>
                Cancelar
            </a>
            <button type="submit" id="submitBtn"
                class="bg-purple-500 text-white px-6 py-2 rounded-lg hover:bg-purple-600 transition-colors duration-200 flex items-center">
                <i class="fas fa-save mr-2"></i>
                {{ isset($book) && $book->exists ? 'Actualizar Libro' : 'Crear Libro' }}
            </button>
        </div>
    </div>
</form>
