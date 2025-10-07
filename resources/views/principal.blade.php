@extends('layouts.app')

@section('titulo', 'Inicio - Grupo A&T - Libros Digitales')

@section('contenido')
    <!-- Hero Section Mejorada -->
    <section class="relative w-full h-[70vh] min-h-[500px] bg-gray-900 overflow-hidden">
        <!-- Imagen de fondo con overlay -->
        <div class="absolute inset-0">
            <img src="{{ asset('img/banners/Banner_limpio.png') }}" alt="Biblioteca digital Grupo A&T"
                class="w-full h-full object-cover">
            <div class="absolute inset-0 bg-gradient-to-r from-[#04050E]/80 to-[#272b30]/60"></div>
        </div>

        <!-- Contenido Hero -->
        <div class="relative container mx-auto h-full flex items-center px-10">
            <div class="max-w-2xl text-white">
                <h1 class="text-4xl md:text-6xl font-bold mb-4 leading-tight">
                    Descubre el <span class="text-[#ea9216]">conocimiento que</span> transforma
                </h1>
                <p class="text-xl md:text-2xl mb-8 text-gray-200">
                    Libros digitales educativos para tu crecimiento personal y profesional
                </p>
                <div class="flex flex-col sm:flex-row gap-4">
                    <a href="{{ route('homebook') }}"
                        class="bg-[#ea9216] hover:bg-[#d48314] text-white px-8 py-3 rounded-lg font-semibold transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-xl text-center">
                        Explorar Libros
                    </a>
                    <a href="{{ route('homeabout') }}"
                        class="border-2 border-white text-white hover:bg-white hover:text-gray-900 px-8 py-3 rounded-lg font-semibold transition-all duration-300 text-center">
                        Conócenos
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Publicidad Section - Banners Horizontales -->
    <section class="py-16 bg-gradient-to-br from-[#f8fafc] to-[#e2e8f0]">
        <div class="container mx-auto px-4 max-w-7xl">
            <!-- Encabezado mejorado -->
            <div class="text-center mb-12">
                <div
                    class="inline-flex items-center gap-2 bg-[#ea9216]/10 text-[#ea9216] px-4 py-2 rounded-full text-sm font-semibold uppercase tracking-wider mb-4">
                    <span class="w-2 h-2 bg-[#ea9216] rounded-full animate-pulse"></span>
                    Novedad Exclusiva
                </div>
                <h2 class="text-4xl md:text-5xl font-bold text-[#052f5a] mt-2 mb-4 leading-tight">
                    Libro <span class="text-[#ea9216]">Destacado</span>
                </h2>
                <div class="w-24 h-1 bg-gradient-to-r from-[#ea9216] to-[#052f5a] mx-auto mb-6 rounded-full"></div>
                <p class="text-lg text-[#272b30] max-w-3xl mx-auto leading-relaxed">
                    Descubre nuestro manual más vendido para docentes innovadores. Una herramienta esencial para transformar
                    tu práctica educativa.
                </p>
            </div>

            <!-- Contenedor del carrusel mejorado - Layout Horizontal -->
            <div class="relative">
                <div class="swiper bannerSwiper">
                    <div class="swiper-wrapper">
                        <!-- Banner 1 - Manual del Docente Innovador (HORIZONTAL) -->
                        <div class="swiper-slide">
                            <div
                                class="bg-white rounded-2xl overflow-hidden shadow-xl hover:shadow-2xl transition-all duration-500 group h-full flex flex-col md:flex-row">
                                <!-- Imagen -->
                                <div class="relative md:w-2/5 h-64 md:h-auto overflow-hidden">
                                    <img src="{{ asset('img/banners/ad_publi.jpg') }}"
                                        alt="Manual del Docente Innovador - IA Generativa"
                                        class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
                                    <div class="absolute top-4 left-4">
                                        <span
                                            class="bg-gradient-to-r from-[#ea9216] to-[#d48314] text-white px-3 py-2 rounded-full text-sm font-bold shadow-lg flex items-center gap-2">
                                            <i class="fas fa-fire"></i> Más Vendido
                                        </span>
                                    </div>
                                    <div class="absolute bottom-4 right-4">
                                        <span
                                            class="bg-gradient-to-r from-[#052f5a] to-[#041e3a] text-white px-3 py-2 rounded-lg text-base font-bold shadow-lg flex items-center gap-1">
                                            <span class="text-xs line-through text-gray-300 mr-1">S/ 25.00</span> S/ 10.00
                                        </span>
                                    </div>
                                </div>

                                <!-- Contenido -->
                                <div class="md:w-3/5 p-6 flex flex-col justify-between">
                                    <div>
                                        <h3 class="text-2xl font-bold text-[#04050E] mb-3">Manual del DOCENTE INNOVADOR</h3>
                                        <p class="text-[#272b30] mb-4 leading-relaxed">
                                            Aplicando IA Generativa - Incluye banco de 1,440 Prompts Maestros para todos los
                                            niveles educativos. Ideal para docentes que buscan innovar en sus metodologías
                                            de enseñanza.
                                        </p>
                                        <div class="grid grid-cols-2 gap-4 mb-4">
                                            <div class="flex items-center text-sm text-[#272b30]">
                                                <div
                                                    class="w-8 h-8 bg-[#ea9216]/10 rounded-full flex items-center justify-center mr-2">
                                                    <i class="fas fa-users text-[#ea9216] text-xs"></i>
                                                </div>
                                                <span>+100 vendidos esta semana</span>
                                            </div>
                                            <div class="flex items-center text-sm text-[#272b30]">
                                                <div
                                                    class="w-8 h-8 bg-[#052f5a]/10 rounded-full flex items-center justify-center mr-2">
                                                    <i class="fas fa-clock text-[#052f5a] text-xs"></i>
                                                </div>
                                                <span>Oferta por tiempo limitado</span>
                                            </div>
                                        </div>
                                    </div>
                                    <a href="https://wa.me/51942784270?text=Hola,%20estoy%20interesado%20en%20el%20Manual%20del%20Docente%20Innovador"
                                        target="_blank"
                                        class="w-full bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white py-3 px-6 rounded-lg font-semibold transition-all duration-300 flex items-center justify-center gap-2 text-center">
                                        <i class="fab fa-whatsapp text-lg"></i>
                                        Comprar por WhatsApp
                                    </a>
                                </div>
                            </div>
                        </div>

                        <!-- Banner 2 - Contenidos del Libro -->
                        <div class="swiper-slide">
                            <div
                                class="bg-gradient-to-r from-[#052f5a] to-[#04050E] rounded-2xl overflow-hidden shadow-xl hover:shadow-2xl transition-all duration-500 group h-full flex flex-col md:flex-row">
                                <!-- Imagen -->
                                <div class="relative md:w-2/5 h-64 md:h-auto overflow-hidden">
                                    <img src="{{ asset('img/banners/ad_plu2.jpg') }}"
                                        alt="Contenidos del Manual del Docente Innovador"
                                        class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
                                    <div class="absolute inset-0 bg-gradient-to-r from-[#04050E]/50 to-transparent"></div>
                                    <div class="absolute top-4 left-4">
                                        <span
                                            class="bg-gradient-to-r from-[#ea9216] to-[#d48314] text-white px-3 py-2 rounded-full text-sm font-bold flex items-center gap-2">
                                            <i class="fas fa-book"></i> 1,440 Prompts
                                        </span>
                                    </div>
                                </div>

                                <!-- Contenido -->
                                <div class="md:w-3/5 p-6 text-white flex flex-col justify-between">
                                    <div>
                                        <h3 class="text-2xl font-bold mb-4">Contenido <span
                                                class="text-[#ea9216]">Exclusivo</span></h3>
                                        <div class="grid grid-cols-2 gap-3 mb-4">
                                            <div class="flex items-center gap-2 text-sm bg-white/5 rounded-lg p-2">
                                                <div
                                                    class="w-6 h-6 bg-[#ea9216] rounded-full flex items-center justify-center flex-shrink-0">
                                                    <i class="fas fa-check text-white text-xs"></i>
                                                </div>
                                                <span>Educación Inicial</span>
                                            </div>
                                            <div class="flex items-center gap-2 text-sm bg-white/5 rounded-lg p-2">
                                                <div
                                                    class="w-6 h-6 bg-[#ea9216] rounded-full flex items-center justify-center flex-shrink-0">
                                                    <i class="fas fa-check text-white text-xs"></i>
                                                </div>
                                                <span>Educación Primaria</span>
                                            </div>
                                            <div class="flex items-center gap-2 text-sm bg-white/5 rounded-lg p-2">
                                                <div
                                                    class="w-6 h-6 bg-[#ea9216] rounded-full flex items-center justify-center flex-shrink-0">
                                                    <i class="fas fa-check text-white text-xs"></i>
                                                </div>
                                                <span>Educación Secundaria</span>
                                            </div>
                                            <div class="flex items-center gap-2 text-sm bg-white/5 rounded-lg p-2">
                                                <div
                                                    class="w-6 h-6 bg-[#ea9216] rounded-full flex items-center justify-center flex-shrink-0">
                                                    <i class="fas fa-check text-white text-xs"></i>
                                                </div>
                                                <span>Básica Alternativa</span>
                                            </div>
                                        </div>
                                        <p class="text-gray-200 mb-4">
                                            Banco completo de prompts para ChatGPT organizado por áreas curriculares y
                                            niveles educativos. Incluye estrategias prácticas y ejemplos aplicables
                                            inmediatamente en el aula.
                                        </p>
                                    </div>
                                    <a href="https://wa.me/51942784270?text=Hola,%20quiero%20más%20información%20sobre%20los%20contenidos%20del%20manual"
                                        target="_blank"
                                        class="w-full bg-gradient-to-r from-[#ea9216] to-[#d48314] hover:from-[#d48314] hover:to-[#bf7512] text-white py-3 px-6 rounded-lg font-semibold transition-all duration-300 flex items-center justify-center gap-2 text-center">
                                        <i class="fas fa-info-circle"></i>
                                        Más Información
                                    </a>
                                </div>
                            </div>
                        </div>

                        <!-- Banner 3 - Especificaciones Técnicas (HORIZONTAL) -->
                        <div class="swiper-slide">
                            <div
                                class="bg-white rounded-2xl overflow-hidden shadow-xl hover:shadow-2xl transition-all duration-500 group h-full flex flex-col md:flex-row border-2 border-[#ea9216]/10">
                                <!-- Imagen -->
                                <div class="relative md:w-2/5 h-64 md:h-auto overflow-hidden">
                                    <img src="{{ asset('img/banners/ad_publi3.jpg') }}"
                                        alt="Especificaciones del Manual del Docente Innovador"
                                        class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
                                    <div class="absolute top-4 right-4">
                                        <span
                                            class="bg-gradient-to-r from-red-500 to-red-600 text-white px-3 py-2 rounded-lg text-sm font-bold flex items-center gap-2">
                                            <i class="fas fa-clock"></i> Oferta Limitada
                                        </span>
                                    </div>
                                </div>

                                <!-- Contenido -->
                                <div class="md:w-3/5 p-6 flex flex-col justify-between">
                                    <div>
                                        <h3 class="text-2xl font-bold text-[#04050E] mb-4">Información del <span
                                                class="text-[#052f5a]">Producto</span></h3>
                                        <div class="space-y-3 mb-4">
                                            <div class="flex justify-between items-center border-b border-gray-100 pb-2">
                                                <span class="text-[#272b30] flex items-center gap-2">
                                                    <i class="fas fa-file-pdf text-[#ea9216]"></i> Formato:
                                                </span>
                                                <span class="font-semibold text-[#052f5a]">PDF Digital</span>
                                            </div>
                                            <div class="flex justify-between items-center border-b border-gray-100 pb-2">
                                                <span class="text-[#272b30] flex items-center gap-2">
                                                    <i class="fas fa-barcode text-[#ea9216]"></i> ISBN:
                                                </span>
                                                <span class="font-semibold text-[#052f5a]">978-612-03-1387-9</span>
                                            </div>
                                            <div class="flex justify-between items-center border-b border-gray-100 pb-2">
                                                <span class="text-[#272b30] flex items-center gap-2">
                                                    <i class="fas fa-certificate text-[#ea9216]"></i> Depósito Legal:
                                                </span>
                                                <span class="font-semibold text-[#052f5a]">2025-09348</span>
                                            </div>
                                            <div class="flex justify-between items-center border-b border-gray-100 pb-2">
                                                <span class="text-[#272b30] flex items-center gap-2">
                                                    <i class="fas fa-shipping-fast text-[#ea9216]"></i> Entrega:
                                                </span>
                                                <span class="font-semibold text-[#052f5a]">Vía WhatsApp/Email</span>
                                            </div>
                                        </div>
                                        <div
                                            class="bg-gradient-to-r from-yellow-50 to-amber-50 border border-yellow-200 rounded-lg p-3 mb-4">
                                            <p
                                                class="text-yellow-800 text-sm text-center flex items-center justify-center gap-2">
                                                <i class="fas fa-exclamation-triangle text-yellow-600"></i>
                                                Precio de lanzamiento por tiempo limitado - ¡No te quedes sin el tuyo!
                                            </p>
                                        </div>
                                    </div>
                                    <a href="https://wa.me/51942784270?text=Hola,%20quiero%20comprar%20el%20Manual%20del%20Docente%20Innovador"
                                        target="_blank"
                                        class="w-full bg-gradient-to-r from-[#052f5a] to-[#041e3a] hover:from-[#041e3a] hover:to-[#03152d] text-white py-3 px-6 rounded-lg font-semibold transition-all duration-300 flex items-center justify-center gap-2 text-center">
                                        <i class="fas fa-shopping-cart"></i>
                                        Comprar Ahora
                                    </a>
                                </div>
                            </div>
                        </div>

                        <!-- Banner 4 - Autores y Contacto (HORIZONTAL) -->
                        <div class="swiper-slide">
                            <div
                                class="bg-gradient-to-r from-[#272b30] to-[#04050E] rounded-2xl overflow-hidden shadow-xl hover:shadow-2xl transition-all duration-500 group h-full flex flex-col md:flex-row">
                                <!-- Imagen -->
                                <div class="relative md:w-2/5 h-64 md:h-auto overflow-hidden">
                                    <img src="{{ asset('img/ing-Taya.jpg') }}" alt="Autores y contacto Grupo A&T"
                                        class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
                                    <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                                    <div class="absolute bottom-4 left-4 text-white">
                                        <h4 class="text-lg font-bold">Ing. Alex Taya</h4>
                                        <p class="text-gray-200 text-sm">Prof. Tania Urcia</p>
                                    </div>
                                </div>

                                <!-- Contenido -->
                                <div class="md:w-3/5 p-6 text-white flex flex-col justify-between">
                                    <div>
                                        <h3 class="text-2xl font-bold mb-4">Contacto <span
                                                class="text-[#ea9216]">Directo</span></h3>
                                        <p class="text-gray-200 mb-4">
                                            Venta directa con los autores. Atención personalizada y soporte post-venta.
                                            Resolvemos todas tus dudas sobre la implementación de IA en educación.
                                        </p>
                                        <div class="space-y-3 mb-4">
                                            <div class="flex items-center gap-3 bg-white/5 rounded-lg p-3">
                                                <div
                                                    class="w-10 h-10 bg-green-500 rounded-full flex items-center justify-center flex-shrink-0">
                                                    <i class="fab fa-whatsapp text-white"></i>
                                                </div>
                                                <div>
                                                    <p class="text-sm text-gray-300">WhatsApp</p>
                                                    <p class="font-semibold">+51 942 784 270</p>
                                                </div>
                                            </div>
                                            <div class="flex items-center gap-3 bg-white/5 rounded-lg p-3">
                                                <div
                                                    class="w-10 h-10 bg-[#052f5a] rounded-full flex items-center justify-center flex-shrink-0">
                                                    <i class="fas fa-envelope text-white"></i>
                                                </div>
                                                <div>
                                                    <p class="text-sm text-gray-300">Email</p>
                                                    <p class="font-semibold">envío directo</p>
                                                </div>
                                            </div>
                                            <div class="flex items-center gap-3 bg-white/5 rounded-lg p-3">
                                                <div
                                                    class="w-10 h-10 bg-[#1877F2] rounded-full flex items-center justify-center flex-shrink-0">
                                                    <i class="fab fa-facebook-f text-white"></i>
                                                </div>
                                                <div>
                                                    <p class="text-sm text-gray-300">Facebook</p>
                                                    <p class="font-semibold">facebook.com/grupoaytperu</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex gap-3">
                                        <a href="https://wa.me/51942784270" target="_blank"
                                            class="flex-1 bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white py-3 px-4 rounded-lg font-semibold transition-colors duration-300 flex items-center justify-center gap-2 text-center text-sm">
                                            <i class="fab fa-whatsapp"></i>
                                            WhatsApp
                                        </a>
                                        <a href="https://facebook.com/grupoaytperu" target="_blank"
                                            class="flex-1 bg-gradient-to-r from-[#1877F2] to-[#1666D6] hover:from-[#1666D6] hover:to-[#145cbf] text-white py-3 px-4 rounded-lg font-semibold transition-colors duration-300 flex items-center justify-center gap-2 text-center text-sm">
                                            <i class="fab fa-facebook-f"></i>
                                            Facebook
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Pagination -->
                    <div class="swiper-pagination mt-6 !relative"></div>
                </div>

                <!-- Navegación -->
                <div class="swiper-button-next-custom absolute top-1/2 -translate-y-1/2 -right-4 z-10 hidden md:flex">
                    <div
                        class="w-10 h-10 bg-white/90 hover:bg-white shadow-lg rounded-full flex items-center justify-center cursor-pointer transition-all duration-300 hover:scale-110 group">
                        <i class="fas fa-chevron-right text-[#052f5a] group-hover:text-[#ea9216]"></i>
                    </div>
                </div>
                <div class="swiper-button-prev-custom absolute top-1/2 -translate-y-1/2 -left-4 z-10 hidden md:flex">
                    <div
                        class="w-10 h-10 bg-white/90 hover:bg-white shadow-lg rounded-full flex items-center justify-center cursor-pointer transition-all duration-300 hover:scale-110 group">
                        <i class="fas fa-chevron-left text-[#052f5a] group-hover:text-[#ea9216]"></i>
                    </div>
                </div>
            </div>

            <!-- Indicador de oferta especial -->
            <div class="text-center mt-8">
                <div
                    class="inline-flex items-center gap-3 bg-gradient-to-r from-red-50 to-orange-50 border border-red-200 rounded-full px-6 py-3">
                    <div
                        class="w-8 h-8 bg-gradient-to-r from-red-500 to-orange-500 rounded-full flex items-center justify-center">
                        <i class="fas fa-bolt text-white text-sm"></i>
                    </div>
                    <div class="text-left">
                        <p class="text-red-700 font-bold">¡Oferta de lanzamiento!</p>
                        <p class="text-red-600 text-sm">Precio especial S/ 10.00 por tiempo limitado</p>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <!-- Libro Destacado Section -->
    <section class="py-16 bg-white">
        <div class="container mx-auto px-4">
            <div class="text-center mb-12">
                <span class="text-[#ea9216] font-semibold uppercase tracking-wider text-sm">Destacado</span>
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mt-2">Libro en Tendencia</h2>
                <p class="text-gray-600 max-w-2xl mx-auto mt-4">
                    Descubre nuestro libro más popular del momento
                </p>
            </div>

            <div class="max-w-4xl mx-auto">
                <div class="bg-gradient-to-r from-[#052f5a] to-[#272b30] rounded-2xl p-8 md:p-12 shadow-2xl">
                    <div class="grid md:grid-cols-2 gap-8 items-center">
                        <!-- Imagen del libro -->
                        <div class="relative group">
                            <div class="relative z-10 transform group-hover:scale-105 transition-transform duration-500">
                                <x-book-image :image="$book->image" :title="$book->title" class="w-full rounded-xl shadow-2xl" />
                            </div>
                            <div
                                class="absolute inset-0 bg-[#ea9216] rounded-xl transform rotate-3 scale-105 opacity-20 group-hover:rotate-6 transition-transform duration-500">
                            </div>
                        </div>

                        <!-- Información del libro -->
                        <div class="text-white">
                            <div class="flex items-center gap-2 mb-4">
                                <span class="bg-[#ea9216] text-white px-3 py-1 rounded-full text-sm font-semibold">
                                    🔥 Más Vendido
                                </span>
                                <span class="bg-white/20 px-3 py-1 rounded-full text-sm">
                                    {{ $book->category->name ?? 'Educación' }}
                                </span>
                            </div>

                            <h3 class="text-2xl md:text-3xl font-bold mb-4 leading-tight">
                                {{ $book->title }}
                            </h3>

                            <p class="text-gray-200 mb-6 line-clamp-3">
                                {{ $book->description ?? 'Descubre este increíble libro que está transformando la manera de aprender.' }}
                            </p>

                            <div class="flex items-center gap-4 mb-6">
                                <div class="text-3xl font-bold text-[#ea9216]">
                                    S/ {{ number_format($book->price, 2) }}
                                </div>
                                @if (isset($book->price_original) && $book->price_original > $book->price)
                                    <div class="text-lg text-gray-300 line-through">
                                        S/ {{ number_format($book->price_original, 2) }}
                                    </div>
                                @endif
                            </div>

                            <!-- BOTONES -->
                            <div class="flex flex-col sm:flex-row gap-3">
                                @auth
                                    <!-- Usuario autenticado: Ver detalles -->
                                    <a href="{{ route('bookmart.book', ['book' => $book->id]) }}"
                                        class="flex-1 bg-[#ea9216] hover:bg-[#d48314] text-white py-3 px-6 rounded-lg font-semibold transition-all duration-300 transform hover:scale-105 flex items-center justify-center gap-2 text-center">
                                        <i class="fas fa-eye"></i>
                                        Ver Detalles
                                    </a>
                                @else
                                    <!-- Usuario no autenticado: Ver detalles -->
                                    <a href="{{ route('bookmart.book', ['book' => $book->id]) }}"
                                        class="flex-1 bg-[#ea9216] hover:bg-[#d48314] text-white py-3 px-6 rounded-lg font-semibold transition-all duration-300 transform hover:scale-105 flex items-center justify-center gap-2 text-center">
                                        <i class="fas fa-eye"></i>
                                        Ver Detalles
                                    </a>
                                @endauth

                                <!-- Botón secundario para explorar más libros -->
                                <a href="{{ route('homebook') }}"
                                    class="bg-white/10 hover:bg-white/20 text-white py-3 px-6 rounded-lg font-semibold transition-all duration-300 text-center border border-white/20 flex items-center justify-center gap-2">
                                    <i class="fas fa-search"></i>
                                    Explorar Más
                                </a>
                            </div>

                            <!-- Características rápidas -->
                            <div class="grid grid-cols-2 gap-4 mt-6 pt-6 border-t border-white/20">
                                <div class="flex items-center gap-2 text-sm">
                                    <i class="fas fa-file-pdf text-[#ea9216]"></i>
                                    <span>Formato PDF</span>
                                </div>
                                <div class="flex items-center gap-2 text-sm">
                                    <i class="fas fa-download text-[#ea9216]"></i>
                                    <span>Descarga Inmediata</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-20 bg-gradient-to-r from-[#04050E] via-[#052f5a] to-[#272b30] relative overflow-hidden">
        <!-- Elementos decorativos -->
        <div class="absolute top-0 left-0 w-72 h-72 bg-[#ea9216]/10 rounded-full -translate-x-1/2 -translate-y-1/2"></div>
        <div class="absolute bottom-0 right-0 w-96 h-96 bg-[#ea9216]/5 rounded-full translate-x-1/2 translate-y-1/2"></div>

        <div class="container mx-auto px-4 text-center relative z-10">
            <h2 class="text-4xl md:text-5xl font-bold text-white mb-6 leading-tight">
                ¿Listo para comenzar tu <span class="text-[#ea9216]">viaje de aprendizaje</span>?
            </h2>
            <p class="text-gray-200 text-xl mb-10 max-w-3xl mx-auto leading-relaxed">
                Explora nuestra completa colección de libros digitales y lleva tu conocimiento al siguiente nivel. Aprende a
                tu ritmo, en cualquier momento y lugar.
            </p>
            <div class="flex flex-col sm:flex-row gap-6 justify-center items-center">
                <a href="{{ route('homebook') }}"
                    class="bg-[#ea9216] hover:bg-[#d48314] text-white px-10 py-5 rounded-xl font-semibold transition-all duration-300 transform hover:scale-105 shadow-2xl hover:shadow-3xl text-lg flex items-center gap-3">
                    <i class="fas fa-book-open"></i>
                    Ver Todos los Libros
                </a>
                <a href="{{ route('homecontact') }}"
                    class="border-2 border-white text-white hover:bg-white hover:text-gray-900 px-10 py-5 rounded-xl font-semibold transition-all duration-300 text-lg flex items-center gap-3">
                    <i class="fas fa-headset"></i>
                    Contáctanos
                </a>
            </div>

            <!-- Trust indicators -->
            <div class="flex flex-wrap justify-center gap-8 mt-12 pt-8 border-t border-white/20">
                <div class="flex items-center gap-3 text-white/80">
                    <i class="fas fa-lock text-[#ea9216]"></i>
                    <span>Pago seguro</span>
                </div>
                <div class="flex items-center gap-3 text-white/80">
                    <i class="fas fa-shipping-fast text-[#ea9216]"></i>
                    <span>Descarga inmediata</span>
                </div>
                <div class="flex items-center gap-3 text-white/80">
                    <i class="fas fa-user-shield text-[#ea9216]"></i>
                    <span>Garantía de satisfacción</span>
                </div>
            </div>
        </div>
    </section>

    <!-- Newsletter Section -->
    <section class="py-16 bg-white">
        <div class="container mx-auto px-4 max-w-5xl">
            <div
                class="bg-gradient-to-r from-[#052f5a] to-[#04050E] rounded-3xl p-8 md:p-12 text-center text-white relative overflow-hidden">
                <!-- Elemento decorativo -->
                <div
                    class="absolute top-0 right-0 w-64 h-64 bg-[#ea9216]/10 rounded-full -translate-y-1/2 translate-x-1/2">
                </div>

                <div class="relative z-10">
                    <h2 class="text-3xl md:text-4xl font-bold mb-4">
                        Mantente <span class="text-[#ea9216]">Informado</span>
                    </h2>
                    <p class="text-gray-200 text-lg mb-8 max-w-2xl mx-auto">
                        Suscríbete para recibir las últimas novedades, promociones exclusivas y nuevos lanzamientos
                        directamente en tu correo.
                    </p>
                    <form class="flex flex-col sm:flex-row gap-4 max-w-2xl mx-auto">
                        <div class="flex-grow">
                            <input type="email" placeholder="Tu correo electrónico"
                                class="w-full px-6 py-4 rounded-xl border-1 focus:outline-none focus:ring-2 focus:ring-[#ea9216] text-white-900">
                        </div>
                        <button type="submit"
                            class="bg-[#ea9216] hover:bg-[#d48314] text-white px-8 py-4 rounded-xl font-semibold transition-colors duration-300 flex items-center justify-center gap-3 shadow-lg hover:shadow-xl">
                            <span>Suscribirse</span>
                            <i class="fas fa-paper-plane"></i>
                        </button>
                    </form>
                    <p class="text-gray-300 text-sm mt-4">
                        📧 No spam, solo contenido de valor. Puedes darte de baja en cualquier momento.
                    </p>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('scripts')
    <!-- Swiper JS -->
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css" />
    <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var bannerSwiper = new Swiper('.bannerSwiper', {
                loop: true,
                autoplay: {
                    delay: 6000,
                    disableOnInteraction: false,
                },
                pagination: {
                    el: '.swiper-pagination',
                    clickable: true,
                },
                navigation: {
                    nextEl: '.swiper-button-next-custom',
                    prevEl: '.swiper-button-prev-custom',
                },
                breakpoints: {
                    320: {
                        slidesPerView: 1,
                        spaceBetween: 20
                    },
                    768: {
                        slidesPerView: 2,
                        spaceBetween: 30
                    },
                    1024: {
                        slidesPerView: 1,
                        spaceBetween: 40
                    }
                }
            });

            // Efecto hover para las tarjetas horizontales
            const cards = document.querySelectorAll('.swiper-slide > div');
            cards.forEach(card => {
                card.addEventListener('mouseenter', function() {
                    this.style.transform = 'translateY(-5px)';
                });

                card.addEventListener('mouseleave', function() {
                    this.style.transform = 'translateY(0)';
                });
            });
        });
    </script>

    <style>
        /* Estilos para banners horizontales */
        .swiper-slide {
            height: auto;
        }

        .swiper-slide>div {
            height: 100%;
            min-height: 320px;
        }

        /* Paginación personalizada */
        .swiper-pagination-bullet {
            width: 5px;
            height: 5px;
            background: #cbd5e0;
            opacity: 0.5;
        }

        .swiper-pagination-bullet-active {
            background: #ea9216;
            opacity: 1;
            width: 30px;
            border-radius: 5px;
        }

        /* Responsive para móviles */
        @media (max-width: 768px) {

            .swiper-button-next-custom,
            .swiper-button-prev-custom {
                display: none !important;
            }

            .swiper-slide>div {
                flex-direction: column;
            }

            .swiper-slide>div>div:first-child {
                width: 100% !important;
                height: 200px;
            }

            .swiper-slide>div>div:last-child {
                width: 100% !important;
            }
        }

        /* Mejoras de transición */
        .swiper-slide>div {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
    </style>
@endsection
