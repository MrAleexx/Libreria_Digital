{{-- resources/views/components/principal/featured-book.blade.php --}}
<section class="py-20 bg-white">
    <div class="container mx-auto px-6">
        <div class="text-center mb-16">
            <span class="text-green-600 font-semibold uppercase tracking-wider text-sm">Recomendación de la
                Comunidad</span>
            <h2 class="text-4xl md:text-5xl font-bold text-slate-900 mt-4 mb-6">
                Libro <span
                    class="bg-gradient-to-r from-green-600 to-blue-600 bg-clip-text text-transparent">Destacado</span>
            </h2>
        </div>

        @if ($book)
            <div class="featured-book-container">
                <div class="featured-book-card">
                    <!-- Imagen del libro con efecto parallax -->
                    <div class="book-image-section">
                        <div class="book-image-wrapper">
                            <x-book-image :image="$book->image" :title="$book->title" class="book-main-image" />
                            <div class="book-image-overlay">
                                <h3 class="book-image-number">#001</h3>
                            </div>
                        </div>
                        <div class="book-floating-badges">
                            <span class="floating-badge trending">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path
                                        d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                </svg>
                                Trending
                            </span>
                            @if (!$book->is_free && isset($book->price_original) && $book->price_original > $book->price)
                                <span class="floating-badge discount">
                                    -{{ round((($book->price_original - $book->price) / $book->price_original) * 100) }}%
                                </span>
                            @endif
                        </div>
                    </div>

                    <!-- Información del libro -->
                    <div class="book-info-section">
                        <div class="book-badges">
                            <span class="info-badge recommended">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                        clip-rule="evenodd" />
                                </svg>
                                Recomendado
                            </span>
                            @if ($book->categories->first())
                                <span class="info-badge category">
                                    {{ $book->categories->first()->name }}
                                </span>
                            @endif
                        </div>

                        <h3 class="book-title">
                            {{ $book->title }}
                        </h3>

                        <p class="book-description">
                            {{ Str::limit($book->description, 200) }}
                        </p>

                        <div class="book-pricing">
                            <div class="price-main">
                                {{ $book->is_free ? 'Gratuito' : 'S/ ' . number_format($book->price, 2) }}
                            </div>
                            @if (!$book->is_free && isset($book->price_original) && $book->price_original > $book->price)
                                <div class="price-original">
                                    S/ {{ number_format($book->price_original, 2) }}
                                </div>
                            @endif
                        </div>

                        <div class="book-actions">
                            <a href="{{ route('bookmart.book', ['book' => $book->id]) }}" class="action-btn primary">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                                Ver Detalles
                            </a>
                            <a href="{{ route('homebook') }}" class="action-btn secondary">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                                Explorar Más
                            </a>
                        </div>

                        <!-- Características del libro -->
                        <div class="book-features">
                            <div class="feature-item">
                                <div class="feature-icon">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                </div>
                                <span>{{ strtoupper($book->file_format) }}</span>
                            </div>
                            <div class="feature-item">
                                <div class="feature-icon">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                    </svg>
                                </div>
                                <span>Descarga Libre</span>
                            </div>
                            <div class="feature-item">
                                <div class="feature-icon">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                    </svg>
                                </div>
                                <span>Acceso Seguro</span>
                            </div>
                            <div class="feature-item">
                                <div class="feature-icon">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                    </svg>
                                </div>
                                <span>Contenido Verificado</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <!-- Estado vacío -->
            <div class="empty-state-container">
                <div class="empty-state-card">
                    <div class="empty-state-icon">
                        <svg class="w-16 h-16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                        </svg>
                    </div>
                    <h3 class="empty-state-title">Biblioteca en Construcción</h3>
                    <p class="empty-state-description">Estamos curando nuestra colección de libros de código abierto.
                    </p>
                    <a href="{{ route('homebook') }}" class="empty-state-action">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                        Explorar Catálogo
                    </a>
                </div>
            </div>
        @endif
    </div>
</section>

<style>
    .featured-book-container {
        max-width: 1200px;
        margin: 0 auto;
    }

    .featured-book-card {
        background: linear-gradient(135deg, #1e293b 0%, #334155 100%);
        border-radius: 2rem;
        padding: 3rem;
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 3rem;
        align-items: center;
        position: relative;
        overflow: hidden;
    }

    .book-image-section {
        position: relative;
    }

    .book-image-wrapper {
        position: relative;
        border-radius: 1.5rem;
        overflow: hidden;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);
        transform: perspective(1000px) rotateY(-5deg);
        transition: transform 0.3s ease;
    }

    .featured-book-card:hover .book-image-wrapper {
        transform: perspective(1000px) rotateY(0deg);
    }

    .book-main-image {
        width: 100%;
        height: auto;
        border-radius: 1.5rem;
        border: 4px solid rgba(255, 255, 255, 0.1);
    }

    .book-image-overlay {
        position: absolute;
        top: 1.5rem;
        right: 1.5rem;
    }

    .book-image-number {
        color: #3b82f6;
        margin: 0;
        font-family: "Azeret Mono", monospace;
        font-size: 3rem;
        font-weight: 700;
        letter-spacing: -3px;
        line-height: 1;
        text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
    }

    .book-floating-badges {
        position: absolute;
        bottom: 1.5rem;
        left: 1.5rem;
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
    }

    .floating-badge {
        padding: 0.5rem 1rem;
        border-radius: 0.75rem;
        font-size: 0.875rem;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        backdrop-filter: blur(8px);
        border: 1px solid rgba(255, 255, 255, 0.2);
    }

    .floating-badge.trending {
        background: rgba(245, 158, 11, 0.2);
        color: #fbbf24;
        border-color: rgba(245, 158, 11, 0.3);
    }

    .floating-badge.discount {
        background: rgba(239, 68, 68, 0.2);
        color: #f87171;
        border-color: rgba(239, 68, 68, 0.3);
    }

    .book-info-section {
        color: white;
    }

    .book-badges {
        display: flex;
        gap: 0.75rem;
        margin-bottom: 1.5rem;
    }

    .info-badge {
        padding: 0.5rem 1rem;
        border-radius: 0.75rem;
        font-size: 0.875rem;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        backdrop-filter: blur(8px);
    }

    .info-badge.recommended {
        background: rgba(34, 197, 94, 0.2);
        color: #4ade80;
        border: 1px solid rgba(34, 197, 94, 0.3);
    }

    .info-badge.category {
        background: rgba(255, 255, 255, 0.1);
        color: #e2e8f0;
        border: 1px solid rgba(255, 255, 255, 0.2);
    }

    .book-title {
        font-size: 2.5rem;
        font-weight: 700;
        line-height: 1.2;
        margin-bottom: 1.5rem;
        color: white;
    }

    .book-description {
        font-size: 1.125rem;
        line-height: 1.6;
        color: #cbd5e1;
        margin-bottom: 2rem;
    }

    .book-pricing {
        display: flex;
        align-items: center;
        gap: 1rem;
        margin-bottom: 2rem;
    }

    .price-main {
        font-size: 2.5rem;
        font-weight: 700;
        color: #10b981;
    }

    .price-original {
        font-size: 1.5rem;
        color: #94a3b8;
        text-decoration: line-through;
    }

    .book-actions {
        display: flex;
        gap: 1rem;
        margin-bottom: 2rem;
    }

    .action-btn {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        padding: 1rem 2rem;
        border-radius: 0.75rem;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.3s ease;
        flex: 1;
        justify-content: center;
    }

    .action-btn.primary {
        background: #10b981;
        color: white;
    }

    .action-btn.primary:hover {
        background: #059669;
        transform: translateY(-2px);
        box-shadow: 0 10px 25px rgba(16, 185, 129, 0.3);
    }

    .action-btn.secondary {
        background: rgba(255, 255, 255, 0.1);
        color: white;
        border: 1px solid rgba(255, 255, 255, 0.2);
    }

    .action-btn.secondary:hover {
        background: rgba(255, 255, 255, 0.2);
        transform: translateY(-2px);
    }

    .book-features {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1rem;
        padding-top: 2rem;
        border-top: 1px solid rgba(255, 255, 255, 0.1);
    }

    .feature-item {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        color: #cbd5e1;
    }

    .feature-icon {
        width: 2.5rem;
        height: 2.5rem;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 0.75rem;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .feature-icon svg {
        color: #60a5fa;
    }

    /* Empty State */
    .empty-state-container {
        max-width: 600px;
        margin: 0 auto;
    }

    .empty-state-card {
        background: #f8fafc;
        border-radius: 2rem;
        padding: 4rem;
        text-align: center;
        border: 2px dashed #cbd5e1;
    }

    .empty-state-icon {
        width: 5rem;
        height: 5rem;
        background: #e2e8f0;
        border-radius: 1.5rem;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1.5rem;
    }

    .empty-state-icon svg {
        color: #64748b;
    }

    .empty-state-title {
        font-size: 2rem;
        font-weight: 700;
        color: #475569;
        margin-bottom: 1rem;
    }

    .empty-state-description {
        color: #64748b;
        margin-bottom: 2rem;
        font-size: 1.125rem;
    }

    .empty-state-action {
        display: inline-flex;
        align-items: center;
        gap: 0.75rem;
        background: #3b82f6;
        color: white;
        padding: 1rem 2rem;
        border-radius: 0.75rem;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.3s ease;
    }

    .empty-state-action:hover {
        background: #2563eb;
        transform: translateY(-2px);
    }

    /* Responsive */
    @media (max-width: 1024px) {
        .featured-book-card {
            grid-template-columns: 1fr;
            gap: 2rem;
            padding: 2rem;
        }

        .book-image-wrapper {
            transform: none;
        }

        .book-title {
            font-size: 2rem;
        }

        .book-actions {
            flex-direction: column;
        }
    }

    @media (max-width: 768px) {
        .book-features {
            grid-template-columns: 1fr;
        }

        .book-badges {
            flex-direction: column;
            align-items: flex-start;
        }

        .empty-state-card {
            padding: 2rem;
        }
    }
</style>
