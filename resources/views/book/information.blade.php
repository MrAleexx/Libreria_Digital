{{-- resources/views/book/information.blade.php --}}
@extends('layouts.app')

@section('titulo', $book->title . ' - Grupo A&T')

@section('contenido')
    <section class="container mx-auto px-4 sm:px-6 py-6 md:py-8 lg:py-10">
        <!-- Header del libro -->
        <div class="max-w-6xl mx-auto">
            <!-- Información principal del libro -->
            <div class="book-card">
                <div class="book-grid">
                    <!-- Imagen del libro -->
                    <div class="book-image-container">
                        <div class="relative">
                            <x-book-image :image="$book->image" :title="$book->title"
                                class="book-cover-image" />
                            @if ($book->is_new)
                                <span class="new-badge">
                                    <i class="fas fa-star mr-1"></i>¡NUEVO!
                                </span>
                            @endif
                        </div>
                    </div>

                    <!-- Información del libro -->
                    <div class="book-info-content">
                        <div>
                            <div class="book-header">
                                <h1 class="book-title">{{ $book->title }}</h1>
                                <p class="book-author">
                                    <i class="fas fa-user-edit author-icon"></i>
                                    por {{ $book->all_authors }}
                                </p>
                            </div>

                            <!-- Precio y etiquetas -->
                            <div class="price-section">
                                <div class="price-tags">
                                    <span class="book-price">S/ {{ number_format($book->price, 2) }}</span>
                                    @if ($book->is_new)
                                        <span class="new-tag">
                                            <i class="fas fa-bolt mr-1"></i>Novedad
                                        </span>
                                    @endif
                                </div>
                                <p class="tax-info">
                                    <i class="fas fa-receipt tax-icon"></i>
                                    Incluye IGV según Ley N.° 31893
                                </p>
                            </div>

                            <!-- Formulario de compra -->
                            <form action="{{ route('cart.add', $book) }}" method="POST" class="purchase-form">
                                @csrf
                                <div class="form-controls">
                                    <div class="quantity-control-group">
                                        <label class="quantity-label">
                                            <i class="fas fa-cubes mr-1"></i>Cantidad:
                                        </label>
                                        <div class="quantity-control-wrapper">
                                            <button type="button" class="quantity-btn decrement">
                                                <i class="fas fa-minus"></i>
                                            </button>
                                            <input type="number" id="quantity" name="quantity" value="1"
                                                min="1" max="5" class="quantity-input">
                                            <button type="button" class="quantity-btn increment">
                                                <i class="fas fa-plus"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <button type="submit" class="add-to-cart-btn">
                                        <i class="fas fa-shopping-cart"></i>
                                        AÑADIR AL CARRITO
                                    </button>
                                </div>
                            </form>
                        </div>

                        <!-- Acciones secundarias -->
                        <div class="secondary-actions">
                            <button class="action-btn share-btn">
                                <i class="fas fa-share-alt"></i>
                                Compartir
                            </button>
                            <button class="action-btn wishlist-btn">
                                <i class="far fa-heart"></i>
                                Guardar en favoritos
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Navegación de pestañas -->
            <div class="tabs-container">
                <div class="tabs-header">
                    <nav class="tabs-nav">
                        <button id="tab-info" class="tab-button active" data-tab="info">
                            <i class="fas fa-info-circle"></i>
                            Información General
                        </button>
                        <button id="tab-details" class="tab-button" data-tab="details">
                            <i class="fas fa-clipboard-list"></i>
                            Detalles del Producto
                        </button>
                        <button id="tab-index" class="tab-button" data-tab="index">
                            <i class="fas fa-list-ol"></i>
                            Índice General
                        </button>
                    </nav>
                </div>

                <!-- Contenido de pestañas -->
                <div class="tabs-content">
                    <!-- Pestaña Información General -->
                    <div id="content-info" class="tab-content active">
                        <div class="content-section">
                            <h3 class="content-title">
                                <i class="fas fa-file-alt title-icon"></i>
                                Resumen
                            </h3>
                            <div class="book-description">
                                {!! $book->description !!}
                            </div>
                        </div>
                    </div>

                    <!-- Pestaña Detalles del Producto -->
                    <div id="content-details" class="tab-content">
                        <div class="details-grid">
                            <div class="details-column">
                                <div class="detail-item">
                                    <span class="detail-label">
                                        <i class="fas fa-user-edit detail-icon"></i>
                                        Autor:
                                    </span>
                                    <strong class="detail-value">{{ $book->all_authors }}</strong>
                                </div>
                                <div class="detail-item">
                                    <span class="detail-label">
                                        <i class="fas fa-building detail-icon"></i>
                                        Editorial:
                                    </span>
                                    <strong class="detail-value">{{ $book->publisher }}</strong>
                                </div>
                                <div class="detail-item">
                                    <span class="detail-label">
                                        <i class="fas fa-file-pdf detail-icon"></i>
                                        Formato:
                                    </span>
                                    <strong class="detail-value">{{ $book->file_format }}</strong>
                                </div>
                                <div class="detail-item">
                                    <span class="detail-label">
                                        <i class="fas fa-file-text detail-icon"></i>
                                        Páginas:
                                    </span>
                                    <strong class="detail-value">{{ $book->pages }}</strong>
                                </div>
                            </div>
                            <div class="details-column">
                                <div class="detail-item">
                                    <span class="detail-label">
                                        <i class="fas fa-barcode detail-icon"></i>
                                        ISBN:
                                    </span>
                                    <strong class="detail-value">{{ $book->isbn }}</strong>
                                </div>
                                <div class="detail-item">
                                    <span class="detail-label">
                                        <i class="fas fa-language detail-icon"></i>
                                        Idioma:
                                    </span>
                                    <strong class="detail-value">{{ $book->language }}</strong>
                                </div>
                                <div class="detail-item">
                                    <span class="detail-label">
                                        <i class="fas fa-layer-group detail-icon"></i>
                                        Edición:
                                    </span>
                                    <strong class="detail-value">{{ $book->edition }}</strong>
                                </div>
                                <div class="detail-item">
                                    <span class="detail-label">
                                        <i class="fas fa-calendar-alt detail-icon"></i>
                                        Publicación:
                                    </span>
                                    <strong class="detail-value">{{ $book->publication->format('d/m/Y') }}</strong>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Pestaña Índice General -->
                    <div id="content-index" class="tab-content">
                        <h3 class="content-title">
                            <i class="fas fa-sitemap title-icon"></i>
                            Índice General
                        </h3>
                        <div class="index-content">
                            @if ($book->contents->count() > 0)
                                @foreach ($book->contents as $content)
                                    <div class="index-item" style="margin-left: {{ ($content->level - 1) * 1.5 }}rem">
                                        <div class="index-bullet"></div>
                                        <span class="index-text">{{ $content->chapter_title }}</span>
                                        @if ($content->page_start)
                                            <span class="page-number">- Pág. {{ $content->page_start }}</span>
                                        @endif
                                    </div>
                                @endforeach
                            @else
                                <div class="no-index">
                                    <i class="fas fa-list-alt no-index-icon"></i>
                                    <p class="no-index-text">Índice no disponible</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Libros relacionados -->
            <div class="related-section">
                <h3 class="related-title">
                    <i class="fas fa-book-open title-icon"></i>
                    Libros Relacionados
                </h3>
                 <div class="text-center py-8">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-[#272b30]/30 mx-auto mb-4"
                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                    </svg>
                    <p class="text-[#272b30]/60">Próximamente más libros de la colección</p>
                </div>
            </div>
        </div>
    </section>
@endsection
