@props(['books'])

<div class="container mx-auto flex flex-wrap justify-center gap-4">
    @foreach ($books as $book)
        <a href="{{ route('bookmart.book', ['book' => $book->id]) }}"
            class="w-40 md:w-48 bg-white rounded-lg shadow group relative">
            <div class="relative">
                {{-- Usar el nuevo componente --}}
                <x-book-image :image="$book->image" :title="$book->title" cclass="w-40 md:w-48 bg-white rounded-lg shadow group relative" />

                <button
                    class="cursor-pointer absolute inset-x-0 bottom-2 mx-auto w-11/12 bg-orange-400 hover:bg-orange-500 text-sm font-bold py-2 rounded opacity-0 translate-y-2 group-hover:opacity-100 group-hover:translate-y-0 transition-all duration-300 ease-in-out">
                    Añadir al Carrito
                </button>
            </div>

            <div class="p-2 text-center space-y-1.5">
                <p class="text-sm text-gray-700 truncate">
                    {{ $book->title }}
                </p>
                <span class="text-orange-600 font-bold">S/ {{ number_format($book->price, 2) }}</span>
            </div>
        </a>
    @endforeach
</div>
