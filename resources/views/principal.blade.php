{{-- resources/views/principal.blade.php --}}
@extends('layouts.app')

@section('titulo', 'OpenReads - Biblioteca Digital de Código Abierto')

@section('contenido')
    <!-- Hero Section con Motion One -->
    <section
        class="relative w-full h-[80vh] min-h-[600px] bg-gradient-to-br from-slate-900 via-blue-900 to-slate-800 overflow-hidden">
        <!-- Patrón de fondo abstracto animado -->
        <div class="absolute inset-0 opacity-10">
            <div id="floating-circle-1"
                class="absolute top-10 left-10 w-72 h-72 bg-blue-500 rounded-full mix-blend-multiply filter blur-xl"></div>
            <div id="floating-circle-2"
                class="absolute top-40 right-10 w-96 h-96 bg-green-500 rounded-full mix-blend-multiply filter blur-xl"></div>
            <div id="floating-circle-3"
                class="absolute bottom-10 left-1/2 w-80 h-80 bg-indigo-500 rounded-full mix-blend-multiply filter blur-xl">
            </div>
        </div>

        <!-- Contenido Hero -->
        <div class="relative container mx-auto h-full flex items-center px-6">
            <div class="max-w-3xl text-white text-center mx-auto">
                <!-- Badge de código abierto -->
                <div id="hero-badge"
                    class="inline-flex items-center gap-3 bg-white/10 backdrop-blur-sm border border-white/20 px-6 py-3 rounded-full mb-8 opacity-0">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M12.316 3.051a1 1 0 01.633 1.265l-4 12a1 1 0 11-1.898-.632l4-12a1 1 0 011.265-.633zM5.707 6.293a1 1 0 010 1.414L3.414 10l2.293 2.293a1 1 0 11-1.414 1.414l-3-3a1 1 0 010-1.414l3-3a1 1 0 011.414 0zm8.586 0a1 1 0 011.414 0l3 3a1 1 0 010 1.414l-3 3a1 1 0 11-1.414-1.414L16.586 10l-2.293-2.293a1 1 0 010-1.414z"
                            clip-rule="evenodd" />
                    </svg>
                    <span class="text-sm font-semibold">Plataforma de Código Abierto</span>
                </div>

                <h1 id="hero-title" class="text-5xl md:text-7xl font-bold mb-6 leading-tight opacity-0">
                    <span class="bg-gradient-to-r from-blue-400 to-green-400 bg-clip-text text-transparent">
                        OpenReads
                    </span>
                </h1>

                <p id="hero-subtitle"
                    class="text-xl md:text-2xl mb-8 text-slate-200 leading-relaxed max-w-2xl mx-auto opacity-0">
                    Democratizando el acceso al conocimiento a través de libros educativos de código abierto y contenido
                    libre.
                </p>

                <div id="hero-buttons" class="flex flex-col sm:flex-row gap-4 justify-center items-center opacity-0">
                    <a href="{{ route('homebook') }}"
                        class="hero-btn group bg-blue-600 hover:bg-blue-700 text-white px-8 py-4 rounded-xl font-semibold transition-all duration-300 shadow-lg hover:shadow-blue-500/25 flex items-center gap-3">
                        <svg class="w-5 h-5 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                        </svg>
                        Explorar Biblioteca
                    </a>
                    <a href="{{ route('homeabout') }}"
                        class="hero-btn border-2 border-white/30 text-white hover:bg-white hover:text-slate-900 px-8 py-4 rounded-xl font-semibold transition-all duration-300 flex items-center gap-3 backdrop-blur-sm">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Nuestra Misión
                    </a>
                </div>

                <!-- Stats -->
                <div id="hero-stats"
                    class="flex flex-wrap justify-center gap-8 mt-12 pt-8 border-t border-white/20 opacity-0">
                    <div class="text-center stat-item">
                        <div class="text-2xl font-bold text-blue-300 counter" data-target="500">0</div>
                        <div class="text-sm text-slate-300">Libros Open Source</div>
                    </div>
                    <div class="text-center stat-item">
                        <div class="text-2xl font-bold text-green-300 counter" data-target="10000">0</div>
                        <div class="text-sm text-slate-300">Lectores Activos</div>
                    </div>
                    <div class="text-center stat-item">
                        <div class="text-2xl font-bold text-purple-300">100%</div>
                        <div class="text-sm text-slate-300">Contenido Libre</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Scroll indicator animado -->
        <div id="scroll-indicator" class="absolute bottom-8 left-1/2 transform -translate-x-1/2 opacity-0">
            <div class="animate-bounce">
                <svg class="w-6 h-6 text-white/60" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3" />
                </svg>
            </div>
        </div>
    </section>

    <!-- Features Section con Animaciones Scroll -->
    <section class="py-20 bg-slate-50">
        <div class="container mx-auto px-6">
            <div class="text-center mb-16">
                <span class="text-blue-600 font-semibold uppercase tracking-wider text-sm">¿Por qué OpenReads?</span>
                <h2 class="text-4xl md:text-5xl font-bold text-slate-900 mt-4 mb-6">
                    Conocimiento Libre,
                    <span class="bg-gradient-to-r from-blue-600 to-green-600 bg-clip-text text-transparent">
                        Acceso Ilimitado
                    </span>
                </h2>
                <p class="text-lg text-slate-600 max-w-2xl mx-auto">
                    Creamos un ecosistema donde educadores, estudiantes y lectores pueden compartir y descubrir contenido
                    educativo sin barreras.
                </p>
            </div>

            <div class="grid md:grid-cols-3 gap-8 max-w-6xl mx-auto">
                <!-- Feature 1 -->
                <div
                    class="motion-feature bg-white rounded-2xl p-8 shadow-lg hover:shadow-xl transition-all duration-300 border border-slate-100 group">
                    <div class="feature-icon w-14 h-14 bg-blue-100 rounded-xl flex items-center justify-center mb-6">
                        <svg class="w-7 h-7 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-slate-900 mb-4">Acceso Sin Restricciones</h3>
                    <p class="text-slate-600 leading-relaxed">
                        Todos nuestros libros son de código abierto y completamente gratuitos. Sin suscripciones, sin pagos,
                        solo conocimiento libre.
                    </p>
                </div>

                <!-- Feature 2 -->
                <div
                    class="motion-feature bg-white rounded-2xl p-8 shadow-lg hover:shadow-xl transition-all duration-300 border border-slate-100 group">
                    <div class="feature-icon w-14 h-14 bg-green-100 rounded-xl flex items-center justify-center mb-6">
                        <svg class="w-7 h-7 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-slate-900 mb-4">Comunidad Colaborativa</h3>
                    <p class="text-slate-600 leading-relaxed">
                        Únete a una red global de educadores y contribuidores que comparten recursos educativos abiertos.
                    </p>
                </div>

                <!-- Feature 3 -->
                <div
                    class="motion-feature bg-white rounded-2xl p-8 shadow-lg hover:shadow-xl transition-all duration-300 border border-slate-100 group">
                    <div class="feature-icon w-14 h-14 bg-purple-100 rounded-xl flex items-center justify-center mb-6">
                        <svg class="w-7 h-7 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 10V3L4 14h7v7l9-11h-7z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-slate-900 mb-4">Lector Integrado</h3>
                    <p class="text-slate-600 leading-relaxed">
                        Experiencia de lectura optimizada con múltiples formatos y herramientas de estudio integradas.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Libro Destacado Section -->
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
                <div class="motion-book max-w-6xl mx-auto">
                    <div class="bg-gradient-to-r from-slate-900 to-blue-900 rounded-3xl p-8 md:p-12 shadow-2xl">
                        <div class="grid lg:grid-cols-2 gap-12 items-center">
                            <!-- Imagen del libro -->
                            <div class="relative group">
                                <div
                                    class="relative z-10 transform group-hover:scale-105 transition-transform duration-500">
                                    <x-book-image :image="$book->image" :title="$book->title"
                                        class="w-full rounded-2xl shadow-2xl border-4 border-white/20" />
                                </div>
                                <div
                                    class="absolute inset-0 bg-gradient-to-br from-blue-500 to-green-500 rounded-2xl transform rotate-3 scale-105 opacity-20 group-hover:rotate-6 transition-transform duration-500">
                                </div>
                            </div>

                            <!-- Información del libro -->
                            <div class="text-white">
                                <div class="flex items-center gap-3 mb-6">
                                    <span
                                        class="bg-green-500 text-white px-4 py-2 rounded-full text-sm font-semibold flex items-center gap-2">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                            <path
                                                d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                        </svg>
                                        Recomendado
                                    </span>
                                    @if ($book->categories->first())
                                        <span class="bg-white/20 px-4 py-2 rounded-full text-sm backdrop-blur-sm">
                                            {{ $book->categories->first()->name }}
                                        </span>
                                    @endif
                                </div>

                                <h3 class="text-3xl md:text-4xl font-bold mb-6 leading-tight">
                                    {{ $book->title }}
                                </h3>

                                <p class="text-slate-200 text-lg mb-8 leading-relaxed">
                                    {{ Str::limit($book->description, 200) }}
                                </p>

                                <div class="flex items-center gap-4 mb-8">
                                    <div class="text-2xl font-bold text-green-400">
                                        {{ $book->is_free ? 'Gratuito' : 'S/ ' . number_format($book->price, 2) }}
                                    </div>
                                    @if (!$book->is_free && isset($book->price_original) && $book->price_original > $book->price)
                                        <div class="text-lg text-slate-400 line-through">
                                            S/ {{ number_format($book->price_original, 2) }}
                                        </div>
                                    @endif
                                </div>

                                <div class="flex flex-col sm:flex-row gap-4">
                                    <a href="{{ route('bookmart.book', ['book' => $book->id]) }}"
                                        class="flex-1 bg-green-600 hover:bg-green-700 text-white py-4 px-8 rounded-xl font-semibold transition-all duration-300 transform hover:scale-105 flex items-center justify-center gap-3 text-center group">
                                        <svg class="w-5 h-5 group-hover:scale-110 transition-transform" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                        Ver Detalles
                                    </a>
                                    <a href="{{ route('homebook') }}"
                                        class="bg-white/10 hover:bg-white/20 text-white py-4 px-8 rounded-xl font-semibold transition-all duration-300 text-center border border-white/20 flex items-center justify-center gap-3 backdrop-blur-sm">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                        </svg>
                                        Explorar Más
                                    </a>
                                </div>

                                <!-- Características -->
                                <div class="grid grid-cols-2 gap-4 mt-8 pt-8 border-t border-white/20">
                                    <div class="flex items-center gap-3 text-slate-200">
                                        <svg class="w-5 h-5 text-blue-400" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                        </svg>
                                        <span class="text-sm">{{ strtoupper($book->file_format) }}</span>
                                    </div>
                                    <div class="flex items-center gap-3 text-slate-200">
                                        <svg class="w-5 h-5 text-green-400" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                        </svg>
                                        <span class="text-sm">Descarga Libre</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <!-- Estado vacío -->
                <div class="max-w-2xl mx-auto text-center">
                    <div class="bg-slate-50 rounded-3xl p-12 border-2 border-dashed border-slate-200">
                        <svg class="w-16 h-16 text-slate-400 mx-auto mb-4" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                        </svg>
                        <h3 class="text-2xl font-bold text-slate-600 mb-4">Biblioteca en Construcción</h3>
                        <p class="text-slate-500 mb-8">Estamos curando nuestra colección de libros de código abierto.</p>
                        <a href="{{ route('homebook') }}"
                            class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-3 rounded-xl font-semibold transition-all duration-300 inline-flex items-center gap-2">
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

    <!-- CTA Final -->
    <section class="py-20 bg-gradient-to-br from-slate-900 via-blue-900 to-slate-800 relative overflow-hidden">
        <!-- Elementos decorativos -->
        <div class="absolute top-0 left-0 w-96 h-96 bg-blue-500/10 rounded-full -translate-x-1/2 -translate-y-1/2"></div>
        <div class="absolute bottom-0 right-0 w-96 h-96 bg-green-500/10 rounded-full translate-x-1/2 translate-y-1/2">
        </div>

        <div class="container mx-auto px-6 text-center relative z-10">
            <h2 class="text-4xl md:text-6xl font-bold text-white mb-8 leading-tight">
                Únete a la
                <span class="bg-gradient-to-r from-blue-400 to-green-400 bg-clip-text text-transparent">
                    Revolución del Conocimiento Libre
                </span>
            </h2>
            <p class="text-xl text-slate-200 mb-12 max-w-3xl mx-auto leading-relaxed">
                Descubre, aprende y comparte en una plataforma construida por y para la comunidad educativa global.
            </p>
            <div class="flex flex-col sm:flex-row gap-6 justify-center items-center">
                <a href="{{ route('homebook') }}"
                    class="bg-green-600 hover:bg-green-700 text-white px-12 py-5 rounded-xl font-semibold transition-all duration-300 transform hover:scale-105 shadow-2xl hover:shadow-green-500/25 text-lg flex items-center gap-3 group">
                    <svg class="w-6 h-6 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                    </svg>
                    Explorar Biblioteca
                </a>
                <a href="{{ route('register') }}"
                    class="border-2 border-white/30 text-white hover:bg-white hover:text-slate-900 px-12 py-5 rounded-xl font-semibold transition-all duration-300 text-lg flex items-center gap-3 backdrop-blur-sm">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                    </svg>
                    Unirse a la Comunidad
                </a>
            </div>

            <!-- Trust indicators -->
            <div class="flex flex-wrap justify-center gap-8 mt-16 pt-12 border-t border-white/20">
                <div class="flex items-center gap-3 text-slate-300">
                    <svg class="w-5 h-5 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                    </svg>
                    <span>Contenido Verificado</span>
                </div>
                <div class="flex items-center gap-3 text-slate-300">
                    <svg class="w-5 h-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                    </svg>
                    <span>Descarga Imediata</span>
                </div>
                <div class="flex items-center gap-3 text-slate-300">
                    <svg class="w-5 h-5 text-purple-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M12.316 3.051a1 1 0 01.633 1.265l-4 12a1 1 0 11-1.898-.632l4-12a1 1 0 011.265-.633zM5.707 6.293a1 1 0 010 1.414L3.414 10l2.293 2.293a1 1 0 11-1.414 1.414l-3-3a1 1 0 010-1.414l3-3a1 1 0 011.414 0zm8.586 0a1 1 0 011.414 0l3 3a1 1 0 010 1.414l-3 3a1 1 0 11-1.414-1.414L16.586 10l-2.293-2.293a1 1 0 010-1.414z"
                            clip-rule="evenodd" />
                    </svg>
                    <span>Código Abierto</span>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/motion@10.16.4/+esm"></script>
    <script type="module">
        import {
            animate,
            stagger,
            timeline,
            scroll,
            inView
        } from 'https://cdn.jsdelivr.net/npm/motion@10.16.4/+esm';

        document.addEventListener('DOMContentLoaded', function() {
            // Animación de entrada del hero
            const heroSequence = timeline([
                ['#hero-badge', {
                    opacity: 1,
                    y: [30, 0]
                }, {
                    duration: 0.8,
                    easing: 'ease-out'
                }],
                ['#hero-title', {
                    opacity: 1
                }, {
                    duration: 0.8,
                    at: 0.2
                }],
                ['#hero-subtitle', {
                    opacity: 1,
                    y: [-20, 0]
                }, {
                    duration: 0.8,
                    at: 0.4
                }],
                ['#hero-buttons', {
                    opacity: 1
                }, {
                    duration: 0.6,
                    at: 0.6
                }],
                ['#hero-stats', {
                    opacity: 1
                }, {
                    duration: 0.8,
                    at: 0.8
                }],
                ['#scroll-indicator', {
                    opacity: 1
                }, {
                    duration: 0.6,
                    at: 1.0
                }]
            ]);

            // Animación de círculos flotantes en el fondo
            animate(
                '#floating-circle-1', {
                    x: [0, 100, 0],
                    y: [0, -50, 0],
                    scale: [1, 1.2, 1]
                }, {
                    duration: 15,
                    repeat: Infinity,
                    easing: 'ease-in-out'
                }
            );

            animate(
                '#floating-circle-2', {
                    x: [0, -80, 0],
                    y: [0, 60, 0],
                    scale: [1, 1.1, 1]
                }, {
                    duration: 12,
                    repeat: Infinity,
                    easing: 'ease-in-out',
                    delay: 2
                }
            );

            animate(
                '#floating-circle-3', {
                    x: [0, 60, 0],
                    y: [0, -30, 0],
                    scale: [1, 1.15, 1]
                }, {
                    duration: 18,
                    repeat: Infinity,
                    easing: 'ease-in-out',
                    delay: 4
                }
            );

            // Animación de contadores
            inView('.stat-item', ({
                target
            }) => {
                const counter = target.querySelector('.counter');
                if (counter && counter.textContent === '0') {
                    const targetValue = parseInt(counter.getAttribute('data-target'));
                    const duration = 2000;
                    const step = targetValue / (duration / 16);
                    let current = 0;

                    const updateCounter = () => {
                        current += step;
                        if (current < targetValue) {
                            counter.textContent = Math.floor(current).toLocaleString();
                            requestAnimationFrame(updateCounter);
                        } else {
                            counter.textContent = targetValue.toLocaleString();
                        }
                    };
                    updateCounter();
                }
            }, {
                margin: '-50px'
            });

            // Animaciones scroll para features
            inView('.motion-feature', (info) => {
                animate(
                    info.target, {
                        opacity: [0, 1],
                        y: [30, 0]
                    }, {
                        duration: 0.8,
                        easing: 'ease-out'
                    }
                );
            }, {
                margin: '-50px'
            });

            // Animación para el libro destacado
            inView('.motion-book', (info) => {
                animate(
                    info.target, {
                        opacity: [0, 1],
                        y: [40, 0]
                    }, {
                        duration: 1,
                        easing: 'ease-out'
                    }
                );
            }, {
                margin: '-50px'
            });

            // Micro-interacciones para botones del hero
            const heroButtons = document.querySelectorAll('.hero-btn');
            heroButtons.forEach(button => {
                button.addEventListener('mouseenter', () => {
                    animate(
                        button, {
                            scale: 1.05
                        }, {
                            duration: 0.2,
                            easing: 'ease-out'
                        }
                    );
                });

                button.addEventListener('mouseleave', () => {
                    animate(
                        button, {
                            scale: 1
                        }, {
                            duration: 0.2,
                            easing: 'ease-out'
                        }
                    );
                });
            });

            // Animaciones hover para feature icons
            const featureIcons = document.querySelectorAll('.feature-icon');
            featureIcons.forEach(icon => {
                icon.addEventListener('mouseenter', () => {
                    animate(
                        icon, {
                            scale: 1.1,
                            rotate: 5
                        }, {
                            duration: 0.3,
                            easing: 'ease-out'
                        }
                    );
                });

                icon.addEventListener('mouseleave', () => {
                    animate(
                        icon, {
                            scale: 1,
                            rotate: 0
                        }, {
                            duration: 0.3,
                            easing: 'ease-out'
                        }
                    );
                });
            });

            // Efecto de scroll suave mejorado
            const scrollLinks = document.querySelectorAll('a[href^="#"]');
            scrollLinks.forEach(link => {
                link.addEventListener('click', (e) => {
                    e.preventDefault();
                    const target = document.querySelector(link.getAttribute('href'));
                    if (target) {
                        const targetPosition = target.getBoundingClientRect().top + window
                            .pageYOffset;
                        animate(
                            window, {
                                scrollY: targetPosition
                            }, {
                                duration: 1,
                                easing: 'ease-in-out'
                            }
                        );
                    }
                });
            });

            // Efecto de partículas sutiles
            function createParticles() {
                const heroSection = document.querySelector('section:first-child');
                for (let i = 0; i < 12; i++) {
                    const particle = document.createElement('div');
                    particle.className = 'absolute w-1 h-1 bg-white/20 rounded-full pointer-events-none';
                    particle.style.left = Math.random() * 100 + '%';
                    particle.style.top = Math.random() * 100 + '%';
                    heroSection.appendChild(particle);

                    animate(
                        particle, {
                            y: [0, -40],
                            opacity: [0, 0.6, 0],
                            scale: [1, 1.5, 1]
                        }, {
                            duration: 2 + Math.random() * 2,
                            repeat: Infinity,
                            delay: Math.random() * 2,
                            easing: 'ease-in-out'
                        }
                    );
                }
            }

            createParticles();

            // Animación de scroll indicator
            animate(
                '#scroll-indicator', {
                    y: [0, -10, 0]
                }, {
                    duration: 1.5,
                    repeat: Infinity,
                    easing: 'ease-in-out'
                }
            );
        });
    </script>

    <style>
        /* Mejoras de rendimiento para animaciones */
        .motion-feature,
        .motion-book,
        .hero-btn {
            will-change: transform, opacity;
        }

        /* Suavizado adicional */
        html {
            scroll-behavior: smooth;
        }

        /* Efectos de profundidad mejorados */
        .motion-feature:hover {
            transform: translateY(-8px);
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.15);
        }

        /* Transiciones mejoradas */
        .transition-all {
            transition-property: all;
            transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
            transition-duration: 400ms;
        }

        /* Mejoras de accesibilidad para animaciones */
        @media (prefers-reduced-motion: reduce) {
            * {
                animation-duration: 0.01ms !important;
                animation-iteration-count: 1 !important;
                transition-duration: 0.01ms !important;
            }
        }

        /* Estados focus mejorados */
        .hero-btn:focus {
            outline: 2px solid #3b82f6;
            outline-offset: 2px;
        }

        /* Mejoras de rendimiento */
        .feature-icon {
            transform: translateZ(0);
        }
    </style>
@endsection
