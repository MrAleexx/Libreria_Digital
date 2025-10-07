<footer class="bg-[#061b31] text-white relative overflow-hidden">
    <!-- Elemento decorativo superior -->
    <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-[#ea9216] via-[#ea9216] to-[#ea9216]"></div>

    <!-- Efectos de fondo sutiles -->
    <div class="absolute inset-0 opacity-5">
        <div class="absolute top-10 right-10 w-64 h-64 rounded-full bg-[#ea9216] blur-3xl"></div>
        <div class="absolute bottom-10 left-10 w-48 h-48 rounded-full bg-[#052f5a] blur-3xl"></div>
    </div>

    <div class="relative z-10 mx-auto w-full max-w-screen-xl px-4 py-12 lg:py-16">
        <!-- Contenido principal del footer -->
        <div class="lg:flex lg:justify-between">
            <!-- Información de la empresa -->
            <div class="mb-8 lg:mb-0 lg:max-w-md">
                <a href="{{ route('bookmart') }}" class="inline-block mb-4">
                    <h2 class="font-extrabold text-2xl text-white">
                        GRUPO<span class="text-[#ea9216]">-</span>A&T
                    </h2>
                </a>

                <p class="text-gray-300 mb-4 text-sm leading-relaxed">
                    Líderes en venta de libros digitales educativos. Contenido de calidad para tu crecimiento.
                </p>

                <div class="space-y-2 mb-6">
                    <div class="flex items-start">
                        <i class="fas fa-fingerprint text-[#ea9216] mr-2 mt-0.5 text-xs"></i>
                        <span class="text-sm">RUC: 10154316189</span>
                    </div>
                    <div class="flex items-start">
                        <i class="fas fa-map-marker-alt text-[#ea9216] mr-2 mt-0.5 text-xs"></i>
                        <span class="text-sm">Urb. Libertad Mz. I Lt. 5 Calle las Moras S/N San Vicente - Cañete - Lima
                            - Perú</span>
                    </div>
                </div>

                <!-- Redes sociales -->
                <div class="flex space-x-2">
                    <a href="https://www.facebook.com/grupoaytperu"
                        class="group w-9 h-9 rounded-full bg-white/10 flex items-center justify-center transition-colors duration-300 hover:bg-[#3b5998]"
                        aria-label="Facebook">
                        <img src="{{ asset('img/icons/facebook.svg') }}" alt="Facebook logo"
                            class="w-9 h-9 transition-transform duration-300 group-hover:scale-110">
                    </a>

                    <a href="https://www.instagram.com/alex_taya/"
                        class="group w-9 h-9 rounded-full bg-white/10 flex items-center justify-center transition-colors duration-300 "
                        aria-label="Instagram">
                        <img src="{{ asset('img/icons/instagram.svg') }}" alt="Instagram logo"
                            class="w-9 h-9 transition-transform duration-300 group-hover:scale-110">
                    </a>
                    {{-- <a href="#"
                        class="w-8 h-8 rounded-full bg-white/10 flex items-center justify-center hover:bg-[#ea9216] transition-colors duration-300"
                        aria-label="LinkedIn">
                        <i class="fab fa-linkedin-in text-xs"></i>
                    </a> --}}
                </div>
            </div>

            <!-- Enlaces agrupados -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 sm:gap-8">
                <!-- Política -->
                <div>
                    <h3 class="mb-3 text-sm font-semibold text-white uppercase tracking-wider flex items-center">
                        <i class="fas fa-shield-alt text-[#ea9216] mr-2 text-xs"></i> Política
                    </h3>
                    <ul class="space-y-2">
                        <li>
                            <a href="{{ route('privacy_policies') }}"
                                class="group flex items-center text-gray-300 hover:text-white transition-colors duration-200 text-xs">
                                <span
                                    class="w-1 h-1 bg-[#ea9216] rounded-full mr-2 group-hover:scale-150 transition-transform duration-200"></span>
                                Políticas de privacidad
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('cookie') }}"
                                class="group flex items-center text-gray-300 hover:text-white transition-colors duration-200 text-xs">
                                <span
                                    class="w-1 h-1 bg-[#ea9216] rounded-full mr-2 group-hover:scale-150 transition-transform duration-200"></span>
                                Políticas de Cookies
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('condicion') }}"
                                class="group flex items-center text-gray-300 hover:text-white transition-colors duration-200 text-xs">
                                <span
                                    class="w-1 h-1 bg-[#ea9216] rounded-full mr-2 group-hover:scale-150 transition-transform duration-200"></span>
                                Términos de condiciones
                            </a>
                        </li>
                    </ul>
                </div>

                <!-- Enlaces rápidos -->
                <div>
                    <h3 class="mb-3 text-sm font-semibold text-white uppercase tracking-wider flex items-center">
                        <i class="fas fa-link text-[#ea9216] mr-2 text-xs"></i> Enlaces rápidos
                    </h3>
                    <ul class="space-y-2">
                        <li>
                            <a href="{{ route('bookmart') }}"
                                class="group flex items-center text-gray-300 hover:text-white transition-colors duration-200 text-xs">
                                <span
                                    class="w-1 h-1 bg-[#ea9216] rounded-full mr-2 group-hover:scale-150 transition-transform duration-200"></span>
                                Inicio
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('homebook') }}"
                                class="group flex items-center text-gray-300 hover:text-white transition-colors duration-200 text-xs">
                                <span
                                    class="w-1 h-1 bg-[#ea9216] rounded-full mr-2 group-hover:scale-150 transition-transform duration-200"></span>
                                Nuestros Libros
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('homeabout') }}"
                                class="group flex items-center text-gray-300 hover:text-white transition-colors duration-200 text-xs">
                                <span
                                    class="w-1 h-1 bg-[#ea9216] rounded-full mr-2 group-hover:scale-150 transition-transform duration-200"></span>
                                Sobre Nosotros
                            </a>
                        </li>
                    </ul>
                </div>

                <!-- Contacto -->
                <div>
                    <h3 class="mb-3 text-sm font-semibold text-white uppercase tracking-wider flex items-center">
                        <i class="fas fa-envelope text-[#ea9216] mr-2 text-xs"></i> Contacto
                    </h3>
                    <ul class="space-y-2">
                        <li>
                            <a href="mailto:alextaya@hotmail.com"
                                class="group flex items-center text-gray-300 hover:text-white transition-colors duration-200 text-xs">
                                <span
                                    class="w-1 h-1 bg-[#ea9216] rounded-full mr-2 group-hover:scale-150 transition-transform duration-200"></span>
                                alextaya@hotmail.com
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('claims.index') }}"
                                class="group flex items-center text-gray-300 hover:text-white transition-colors duration-200 text-xs">
                                <span
                                    class="w-1 h-1 bg-[#ea9216] rounded-full mr-2 group-hover:scale-150 transition-transform duration-200"></span>
                                Libro de reclamaciones
                            </a>
                        </li>
                        <li class="flex items-center text-gray-300 text-xs mt-3 pt-3 border-t border-white/10">
                            <i class="fas fa-clock text-[#ea9216] mr-2"></i> L-V 9am - 6pm
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Línea separadora -->
        <hr class="my-8 border-[#052f5a]" />

        <!-- Copyright -->
        <div class="flex flex-col md:flex-row justify-between items-center gap-4 text-center">
            <div>
                <span class="text-xs text-gray-400">
                    © {{ now()->year }}
                    <a href="{{ route('bookmart') }}" class="text-[#ea9216] hover:underline">GRUPOA&T™</a>.
                    Todos los derechos reservados.
                </span>
            </div>

            <div class="flex flex-wrap justify-center gap-3 text-xs text-gray-400">
                <a href="{{ route('privacy_policies') }}"
                    class="hover:text-[#ea9216] transition-colors duration-200">Privacidad</a>
                <span>•</span>
                <a href="{{ route('condicion') }}"
                    class="hover:text-[#ea9216] transition-colors duration-200">Términos</a>
                <span>•</span>
                <a href="{{ route('cookie') }}" class="hover:text-[#ea9216] transition-colors duration-200">Cookies</a>
            </div>

            <div>
                <span class="text-xs text-gray-400">
                    Desarrollado por
                    <a href="https://www.mattinnovasolution.com/" class="text-[#ea9216] hover:underline" target="_blank"
                        rel="noopener noreferrer">
                        Matt Innova Solution
                    </a>
                </span>
            </div>
        </div>
    </div>
</footer>

<!-- Botón para volver arriba -->
<button id="backToTop"
    class="fixed bottom-6 right-6 w-10 h-10 rounded-full bg-[#ea9216] text-white flex items-center justify-center shadow-lg transition-all duration-300 opacity-0 invisible hover:bg-[#d48314] hover:scale-110">
    <i class="fas fa-chevron-up text-sm"></i>
</button>

<style>
    /* Estilos específicos para el footer */
    #backToTop {
        transition: opacity 0.3s, visibility 0.3s, transform 0.2s;
        z-index: 40;
    }

    #backToTop.active {
        opacity: 1;
        visibility: visible;
    }

    /* Smooth scroll para toda la página */
    html {
        scroll-behavior: smooth;
    }

    /* Mejoras de hover para enlaces */
    .group:hover .group-hover\:scale-150 {
        transform: scale(1.5);
    }
</style>

<script>
    // Botón "Volver arriba" - Solo el necesario para el footer
    document.addEventListener('DOMContentLoaded', function() {
        const backToTopButton = document.getElementById('backToTop');

        window.addEventListener('scroll', () => {
            if (window.pageYOffset > 300) {
                backToTopButton.classList.add('active');
                backToTopButton.style.opacity = '1';
                backToTopButton.style.visibility = 'visible';
            } else {
                backToTopButton.classList.remove('active');
                backToTopButton.style.opacity = '0';
                backToTopButton.style.visibility = 'hidden';
            }
        });

        backToTopButton.addEventListener('click', () => {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });
    });
</script>
