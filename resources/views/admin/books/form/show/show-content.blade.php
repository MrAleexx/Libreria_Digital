{{-- resources/views/admin/books/form/show-content.blade.php --}}
<div class="space-y-6">
    @if ($book->contents->count() > 0)
        <div class="bg-white border border-gray-200 rounded-lg overflow-hidden">
            <div class="px-6 py-4 bg-gray-50 border-b border-gray-200">
                <h3 class="text-lg font-medium text-gray-900">Índice del Libro</h3>
                <p class="text-sm text-gray-600 mt-1">{{ $book->contents->count() }} elementos en el índice</p>
            </div>

            <div class="divide-y divide-gray-200">
                @foreach ($book->contents->sortBy('sort_order') as $content)
                    @php
                        $paddingLeft = ($content->level ?? 0) * 24;
                        $bgColor = match ($content->level ?? 0) {
                            0 => 'bg-white',
                            1 => 'bg-blue-50',
                            2 => 'bg-green-50',
                            3 => 'bg-yellow-50',
                            4 => 'bg-purple-50',
                            default => 'bg-white',
                        };
                    @endphp

                    <div class="px-6 py-4 hover:bg-gray-50 transition-colors duration-200 {{ $bgColor }}"
                        style="padding-left: {{ $paddingLeft }}px">
                        <div class="flex items-start justify-between">
                            <div class="flex-1">
                                <div class="flex items-center space-x-3 mb-1">
                                    @if ($content->chapter_number)
                                        <span
                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-orange-100 text-orange-800">
                                            {{ $content->chapter_number }}
                                        </span>
                                    @endif
                                    <h4 class="text-sm font-medium text-gray-900">{{ $content->chapter_title }}</h4>
                                    @if ($content->level > 0)
                                        <span
                                            class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-gray-100 text-gray-800">
                                            Nivel {{ $content->level }}
                                        </span>
                                    @endif
                                </div>

                                @if ($content->description && $content->description !== 'Contenido del libro')
                                    <p class="text-sm text-gray-600 mt-1">{{ $content->description }}</p>
                                @endif

                                @if ($content->page_start || $content->page_end)
                                    <p class="text-xs text-gray-500 mt-1">
                                        Páginas:
                                        @if ($content->page_start && $content->page_end)
                                            {{ $content->page_start }} - {{ $content->page_end }}
                                        @elseif($content->page_start)
                                            Desde página {{ $content->page_start }}
                                        @elseif($content->page_end)
                                            Hasta página {{ $content->page_end }}
                                        @endif
                                    </p>
                                @endif
                            </div>

                            <div class="flex items-center space-x-2 ml-4">
                                <span class="text-xs text-gray-500 bg-gray-100 px-2 py-1 rounded">
                                    Orden: {{ $content->sort_order }}
                                </span>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Vista previa del índice -->
        <div class="bg-gray-50 p-6 rounded-lg border">
            <h4 class="text-lg font-medium text-gray-900 mb-4">Vista Previa del Índice</h4>
            <div class="prose prose-sm max-w-none bg-white p-6 rounded border">
                <h5 class="text-center font-bold text-gray-900 mb-4">ÍNDICE</h5>
                @foreach ($book->contents->sortBy('sort_order') as $content)
                    @php
                        $indentation = ($content->level ?? 0) * 20;
                    @endphp
                    <div class="py-1" style="padding-left: {{ $indentation }}px">
                        {{ $content->chapter_title }}
                    </div>
                @endforeach
            </div>
        </div>
    @else
        <div class="text-center py-12">
            <i class="fas fa-list-ol text-4xl text-gray-300 mb-4"></i>
            <h3 class="text-lg font-medium text-gray-900 mb-2">No hay contenido en el índice</h3>
            <p class="text-gray-500">Aún no se ha definido la estructura del libro (capítulos, secciones, etc.).</p>
            <a href="{{ route('admin.books.edit', $book) }}?tab=content"
                class="mt-4 inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700">
                <i class="fas fa-plus mr-2"></i>
                Crear Índice
            </a>
        </div>
    @endif
</div>
