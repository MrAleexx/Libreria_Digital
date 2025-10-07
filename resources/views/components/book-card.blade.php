@props(['item'])

<div class="book-card">
    <!-- Imagen -->
    <a href="{{ route('user.books.show', $item->book) }}" class="block">
        <div class="book-card__image-container">
            <x-book-image :image="$item->book->image ?? 'https://via.placeholder.com/150x200?text=Sin+imagen'" :title="$item->book->title" class="book-card__image" />
            <span class="book-card__badge">Comprado</span>
        </div>
    </a>

    <!-- Info + botón con flex -->
    <div class="book-card__content">
        <a href="{{ route('user.books.show', $item->book) }}" class="block">
            <h3 class="book-card__title">{{ $item->book->title }}</h3>
            <p class="book-card__author">{{ $item->book->author }}</p>
        </a>

        <div class="book-card__info">
            <span class="book-card__status">Comprado</span>
            <span class="book-card__quantity">Cantidad: {{ $item->quantity }}</span>
        </div>

        <div class="book-card__date">
            <p>Fecha compra: {{ $item->order->created_at->format('d/m/Y') }}</p>
        </div>

        <!-- Botón siempre al fondo -->
        <div class="mt-auto">
            <a href="{{ route('user.books.show', $item->book) }}" class="book-card__button">
                Leer Ahora
            </a>
        </div>
    </div>
</div>
