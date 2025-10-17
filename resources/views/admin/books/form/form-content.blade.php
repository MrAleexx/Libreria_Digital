{{-- resources/views/admin/books/form/form-content.blade.php --}}
<div>
    <!-- Header con información -->
    <div class="mb-6">
        <h4 class="text-lg font-medium text-gray-900 mb-2">Índice y Contenidos</h4>
        <p class="text-sm text-gray-600">
            Define la estructura del libro, como capítulos, secciones y prólogos.
        </p>
    </div>

    <!-- Livewire Component para gestión de contenidos -->
    @livewire('book-contents-manager', ['book' => $book ?? null])
</div>
