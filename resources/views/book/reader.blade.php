@extends('layouts.app')

@section('titulo', $book->title)

@section('contenido')
    <section class="my-5 md:my-10 container mx-auto px-3">
        <div class="max-w-6xl mx-auto bg-white rounded-2xl shadow-xl overflow-hidden border border-[#e9ecef]">

            <!-- Header con gradiente mejorado -->
            <div class="gradient-header p-6 border-b border-[#e9ecef]">
                <div class="flex flex-col lg:flex-row lg:justify-between lg:items-start gap-6">
                    <div class="flex-1">
                        <div class="mb-3">
                            <span
                                class="inline-block bg-[#ea9216]/10 text-[#ea9216] px-3 py-1 rounded-full text-sm font-medium mb-3">
                                Libro Digital
                            </span>
                        </div>
                        <h1 class="text-2xl lg:text-4xl font-bold text-[#04050E] mb-3 leading-tight">
                            {{ $book->title }}
                        </h1>
                        <div class="flex items-center gap-3">
                            <svg class="w-5 h-5 text-[#ea9216]" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 15l-5-5 1.41-1.41L11 14.17l7.59-7.59L20 8l-9 9z" />
                            </svg>
                            <p class="text-[#272b30] text-lg font-medium">Por: {{ $book->author }}</p>
                        </div>
                    </div>

                    <div class="flex flex-col sm:flex-row gap-3">
                        @if ($book->pdf_file)
                            <a href="{{ route('user.books.download', $book) }}"
                                class="btn-primary gradient-primary hover:shadow-xl">
                                <svg class="btn-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4">
                                    </path>
                                </svg>
                                Descargar PDF
                            </a>

                            <button onclick="window.pdfViewerInstance?.toggleFullscreen()"
                                class="btn-secondary gradient-secondary hover:shadow-xl">
                                <svg class="btn-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5v-4m0 4h-4m4 0l-5-5">
                                    </path>
                                </svg>
                                Pantalla Completa
                            </button>
                        @endif

                        <a href="{{ route('book.index') }}"
                            class="btn-outline border-2 hover:bg-[#ea9216] hover:text-white">
                            <svg class="btn-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                            </svg>
                            Volver a Biblioteca
                        </a>
                    </div>
                </div>
            </div>

            <!-- Contenido Principal -->
            <div class="p-6 lg:p-8">
                @if ($book->pdf_file)
                    <!-- Visualizador de PDF -->
                    <div class="pdf-viewer-container shadow-inner">
                        <div class="pdf-viewer-wrapper">
                            <iframe id="pdfViewer" src="{{ route('user.books.view', $book) }}#toolbar=0&view=FitH"
                                class="pdf-iframe" title="Visualizador de PDF - {{ $book->title }}" allowfullscreen
                                onload="console.log('PDF iframe loaded')">
                            </iframe>
                        </div>

                        <!-- Controles flotantes -->
                        <div class="pdf-controls">
                            <button onclick="window.pdfViewerInstance?.toggleFullscreen()" id="fullscreenBtn"
                                class="control-btn hover:scale-110 transition-transform" title="Pantalla completa">
                                <svg class="control-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5v-4m0 4h-4m4 0l-5-5">
                                    </path>
                                </svg>
                            </button>

                            <div class="mobile-controls backdrop-blur-sm bg-white/95">
                                <button onclick="window.pdfViewerInstance?.zoomOut()" class="control-btn hover:bg-[#052f5a]"
                                    title="Alejar">
                                    <svg class="control-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M20 12H4" />
                                    </svg>
                                </button>
                                <span class="zoom-level font-semibold" id="zoomLevel">100%</span>
                                <button onclick="window.pdfViewerInstance?.zoomIn()" class="control-btn hover:bg-[#052f5a]"
                                    title="Acercar">
                                    <svg class="control-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                    </svg>
                                </button>
                            </div>
                        </div>

                        <!-- Loading con diseño mejorado -->
                        <div id="pdfLoading" class="pdf-loading">
                            <div class="loading-spinner"></div>
                            <p class="loading-text">Cargando documento...</p>
                            <p class="text-sm text-[#272b30]/60 mt-2">Por favor espere</p>
                        </div>
                    </div>
                @else
                    <!-- Sin PDF disponible -->
                    <div class="empty-state bg-[#f8f9fa] rounded-2xl p-8">
                        <div class="empty-state-icon">
                            <svg class="w-20 h-20 text-[#ea9216]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                        </div>
                        <h3 class="empty-state-title">PDF no disponible</h3>
                        <p class="empty-state-description">
                            Este libro no tiene un archivo PDF disponible para visualización en este momento.
                        </p>
                        <div class="mt-6">
                            <a href="{{ route('book.index') }}" class="btn-outline inline-flex">
                                <svg class="btn-icon mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                                </svg>
                                Explorar otros libros
                            </a>
                        </div>
                    </div>
                @endif

                <!-- Detalles del libro con diseño mejorado -->
                <div class="book-details">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-1 h-8 bg-[#ea9216] rounded-full"></div>
                        <h3 class="section-title">Detalles del libro</h3>
                    </div>

                    <div class="details-grid bg-[#f8f9fa] rounded-2xl p-6">
                        <div class="detail-item">
                            <span class="detail-label flex items-center gap-2">
                                <svg class="w-4 h-4 text-[#ea9216]" fill="currentColor" viewBox="0 0 24 24">
                                    <path
                                        d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 15l-5-5 1.41-1.41L11 14.17l7.59-7.59L20 8l-9 9z" />
                                </svg>
                                Editorial:
                            </span>
                            <span class="detail-value">{{ $book->editorial }}</span>
                        </div>
                        <div class="detail-item">
                            <span class="detail-label flex items-center gap-2">
                                <svg class="w-4 h-4 text-[#ea9216]" fill="currentColor" viewBox="0 0 24 24">
                                    <path
                                        d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 15l-5-5 1.41-1.41L11 14.17l7.59-7.59L20 8l-9 9z" />
                                </svg>
                                Páginas:
                            </span>
                            <span class="detail-value">{{ $book->pages }}</span>
                        </div>
                        <div class="detail-item">
                            <span class="detail-label flex items-center gap-2">
                                <svg class="w-4 h-4 text-[#ea9216]" fill="currentColor" viewBox="0 0 24 24">
                                    <path
                                        d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 15l-5-5 1.41-1.41L11 14.17l7.59-7.59L20 8l-9 9z" />
                                </svg>
                                Formato:
                            </span>
                            <span class="detail-value">{{ $book->format }}</span>
                        </div>
                        <div class="detail-item">
                            <span class="detail-label flex items-center gap-2">
                                <svg class="w-4 h-4 text-[#ea9216]" fill="currentColor" viewBox="0 0 24 24">
                                    <path
                                        d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 15l-5-5 1.41-1.41L11 14.17l7.59-7.59L20 8l-9 9z" />
                                </svg>
                                ISBN:
                            </span>
                            <span class="detail-value font-mono">{{ $book->isbn }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            console.log('DOM loaded, initializing PDF viewer with brand colors...');
        });
    </script>
@endpush
