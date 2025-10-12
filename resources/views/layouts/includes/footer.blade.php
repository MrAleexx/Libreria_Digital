<footer class="bg-slate-900 text-white relative overflow-hidden">
    <!-- Elemento decorativo superior -->
    <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-blue-500 via-green-500 to-blue-500"></div>

    <!-- Efectos de fondo sutiles -->
    <div class="absolute inset-0 opacity-5">
        <div class="absolute top-0 right-0 w-32 h-32 rounded-full bg-blue-500 blur-2xl"></div>
        <div class="absolute bottom-0 left-0 w-24 h-24 rounded-full bg-green-500 blur-2xl"></div>
    </div>

    <div class="relative z-10 mx-auto w-full max-w-screen-xl px-4 py-8 lg:py-10">
        <!-- Contenido principal del footer -->
        <div class="lg:flex lg:justify-between lg:items-start">
            <!-- Información de la empresa -->
            <div class="mb-6 lg:mb-0 lg:max-w-sm">
                <a href="{{ route('bookmart') }}" class="inline-block mb-3">
                    <div class="flex items-center gap-2">
                        <div
                            class="w-8 h-8 bg-gradient-to-br from-blue-600 to-green-500 rounded-lg flex items-center justify-center">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                            </svg>
                        </div>
                        <span
                            class="text-xl font-bold bg-gradient-to-r from-blue-400 to-green-400 bg-clip-text text-transparent">
                            OpenReads
                        </span>
                    </div>
                </a>

                <p class="text-slate-300 mb-3 text-xs leading-relaxed">
                    Democratizando el acceso al conocimiento a través de libros de código abierto y contenido educativo
                    libre.
                </p>

                <div class="space-y-1 mb-4">
                    <div class="flex items-start">
                        <i class="fas fa-fingerprint text-blue-400 mr-2 mt-0.5 text-xs"></i>
                        <span class="text-xs text-slate-300">Plataforma de Código Abierto</span>
                    </div>
                    <div class="flex items-start">
                        <i class="fas fa-map-marker-alt text-blue-400 mr-2 mt-0.5 text-xs"></i>
                        <span class="text-xs text-slate-300">Comunidad Global</span>
                    </div>
                </div>

                <!-- Redes sociales -->
                <div class="flex space-x-2">
                    <a href="https://github.com/MrAleexx/Libreria_Digital"
                        class="group w-8 h-8 rounded-full bg-white/10 flex items-center justify-center transition-all duration-300 hover:bg-green-600 hover:scale-110"
                        aria-label="GitHub">
                        <i class="fab fa-github text-xs text-white"></i>
                    </a>
                </div>
            </div>

            <!-- Enlaces agrupados -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 sm:gap-6">
                <!-- Política -->
                <div>
                    <h3 class="mb-2 text-xs font-semibold text-white uppercase tracking-wider flex items-center">
                        <i class="fas fa-shield-alt text-blue-400 mr-2 text-xs"></i> Legal
                    </h3>
                    <ul class="space-y-1">
                        <li>
                            <a href="{{ route('privacy_policies') }}"
                                class="group flex items-center text-slate-300 hover:text-white transition-colors duration-200 text-xs">
                                <span
                                    class="w-1 h-1 bg-blue-400 rounded-full mr-2 group-hover:scale-150 transition-transform duration-200"></span>
                                Políticas de privacidad
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('cookie') }}"
                                class="group flex items-center text-slate-300 hover:text-white transition-colors duration-200 text-xs">
                                <span
                                    class="w-1 h-1 bg-blue-400 rounded-full mr-2 group-hover:scale-150 transition-transform duration-200"></span>
                                Políticas de Cookies
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('condicion') }}"
                                class="group flex items-center text-slate-300 hover:text-white transition-colors duration-200 text-xs">
                                <span
                                    class="w-1 h-1 bg-blue-400 rounded-full mr-2 group-hover:scale-150 transition-transform duration-200"></span>
                                Términos y condiciones
                            </a>
                        </li>
                    </ul>
                </div>

                <!-- Enlaces rápidos -->
                <div>
                    <h3 class="mb-2 text-xs font-semibold text-white uppercase tracking-wider flex items-center">
                        <i class="fas fa-link text-green-400 mr-2 text-xs"></i> Navegación
                    </h3>
                    <ul class="space-y-1">
                        <li>
                            <a href="{{ route('bookmart') }}"
                                class="group flex items-center text-slate-300 hover:text-white transition-colors duration-200 text-xs">
                                <span
                                    class="w-1 h-1 bg-green-400 rounded-full mr-2 group-hover:scale-150 transition-transform duration-200"></span>
                                Inicio
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('homebook') }}"
                                class="group flex items-center text-slate-300 hover:text-white transition-colors duration-200 text-xs">
                                <span
                                    class="w-1 h-1 bg-green-400 rounded-full mr-2 group-hover:scale-150 transition-transform duration-200"></span>
                                Biblioteca
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('homeabout') }}"
                                class="group flex items-center text-slate-300 hover:text-white transition-colors duration-200 text-xs">
                                <span
                                    class="w-1 h-1 bg-green-400 rounded-full mr-2 group-hover:scale-150 transition-transform duration-200"></span>
                                Nuestra Misión
                            </a>
                        </li>
                    </ul>
                </div>

                <!-- Contacto -->
                <div>
                    <h3 class="mb-2 text-xs font-semibold text-white uppercase tracking-wider flex items-center">
                        <i class="fas fa-envelope text-blue-400 mr-2 text-xs"></i> Soporte
                    </h3>
                    <ul class="space-y-1">
                        <li>
                            <a href="mailto:alextaya@hotmail.com"
                                class="group flex items-center text-slate-300 hover:text-white transition-colors duration-200 text-xs">
                                <span
                                    class="w-1 h-1 bg-blue-400 rounded-full mr-2 group-hover:scale-150 transition-transform duration-200"></span>
                                soporte@openreads.org
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('claims.index') }}"
                                class="group flex items-center text-slate-300 hover:text-white transition-colors duration-200 text-xs">
                                <span
                                    class="w-1 h-1 bg-blue-400 rounded-full mr-2 group-hover:scale-150 transition-transform duration-200"></span>
                                Reportar problema
                            </a>
                        </li>
                        <li class="flex items-center text-slate-300 text-xs mt-2 pt-2 border-t border-white/10">
                            <i class="fas fa-clock text-green-400 mr-2 text-xs"></i> Soporte 24/7
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Línea separadora -->
        <hr class="my-6 border-slate-700" />

        <!-- Copyright -->
        <div class="flex flex-col md:flex-row justify-between items-center gap-3 text-center">
            <div>
                <span class="text-xs text-slate-400">
                    © {{ now()->year }}
                    <a href="{{ route('bookmart') }}" class="text-blue-400 hover:underline">OpenReads</a>.
                    Conocimiento Libre.
                </span>
            </div>

            <div class="flex flex-wrap justify-center gap-3 text-xs text-slate-400">
                <a href="{{ route('privacy_policies') }}"
                    class="hover:text-blue-400 transition-colors duration-200">Privacidad</a>
                <span class="text-slate-600">•</span>
                <a href="{{ route('condicion') }}"
                    class="hover:text-blue-400 transition-colors duration-200">Términos</a>
                <span class="text-slate-600">•</span>
                <a href="{{ route('cookie') }}" class="hover:text-blue-400 transition-colors duration-200">Cookies</a>
            </div>

            <div>
                <span class="text-xs text-slate-400">
                    Código
                    <a href="#" class="text-green-400 hover:underline" target="_blank" rel="noopener noreferrer">
                        Open Source
                    </a>
                </span>
            </div>
        </div>
    </div>
</footer>

<!-- Botón para volver arriba -->
<button id="backToTop"
    class="fixed bottom-4 right-4 w-9 h-9 rounded-full bg-gradient-to-br from-blue-500 to-green-500 text-white flex items-center justify-center shadow-lg transition-all duration-300 opacity-0 invisible hover:from-blue-600 hover:to-green-600 hover:scale-110 z-40">
    <i class="fas fa-chevron-up text-xs"></i>
</button>

<style>
    /* Estilos específicos para el footer */
    #backToTop {
        transition: opacity 0.3s, visibility 0.3s, transform 0.2s;
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

    /* Efectos de hover suaves */
    .hover-lift {
        transition: transform 0.2s ease;
    }

    .hover-lift:hover {
        transform: translateY(-2px);
    }
</style>

<script>
    // Botón "Volver arriba"
    document.addEventListener('DOMContentLoaded', function() {
        const backToTopButton = document.getElementById('backToTop');

        window.addEventListener('scroll', () => {
            if (window.pageYOffset > 300) {
                backToTopButton.classList.add('active');
            } else {
                backToTopButton.classList.remove('active');
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
