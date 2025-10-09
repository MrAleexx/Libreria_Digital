@extends('layouts.app')

@section('titulo', 'OpenReads - Biblioteca Digital de Código Abierto')

@section('contenido')
    <!-- Hero Section con Scroll Snapping -->
    <section class="hero-section">
        @include('components.principal.hero')
    </section>

    <!-- Features Gallery con Scroll Horizontal -->
    <section class="features-gallery-section">
        @include('components.principal.features-gallery')
    </section>

    <!-- Libro Destacado -->
    <section class="featured-book-section">
        @include('components.principal.featured-book')
    </section>

    <!-- Stats Gallery -->
    <section class="stats-gallery-section">
        @include('components.principal.stats-gallery')
    </section>

    <!-- CTA Final -->
    <section class="cta-section">
        @include('components.principal.cta')
    </section>
@endsection

@section('scripts')
    @include('components.principal.scripts')
@endsection

<style>
    /* Scroll snapping para secciones principales */
    .hero-section,
    .features-gallery-section,
    .featured-book-section,
    .stats-gallery-section,
    .cta-section {
        scroll-snap-align: start;
    }

    html {
        scroll-snap-type: y proximity;
    }

    /* Progress bar global */
    .scroll-progress {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        height: 3px;
        background: linear-gradient(to right, #3b82f6, #10b981);
        transform-origin: left;
        z-index: 1000;
    }
</style>
