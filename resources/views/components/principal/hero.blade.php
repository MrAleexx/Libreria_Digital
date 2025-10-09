<section class="relative w-full h-screen bg-gradient-to-br from-slate-900 via-blue-900 to-slate-800 overflow-hidden">
    <!-- Background Animation -->
    <div class="absolute inset-0 opacity-10">
        <div id="floating-circle-1" class="floating-bg-circle bg-blue-500 top-10 left-10 w-72 h-72"></div>
        <div id="floating-circle-2" class="floating-bg-circle bg-green-500 top-40 right-10 w-96 h-96"></div>
        <div id="floating-circle-3" class="floating-bg-circle bg-indigo-500 bottom-10 left-1/2 w-80 h-80"></div>
    </div>

    <!-- Content -->
    <div class="relative container mx-auto h-full flex items-center px-6">
        <div class="max-w-3xl text-white text-center mx-auto">
            <!-- Badge -->
            <div id="hero-badge" class="hero-badge opacity-0">
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
                <a href="{{ route('homebook') }}" class="hero-btn primary">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                    </svg>
                    Explorar Biblioteca
                </a>
                <a href="{{ route('homeabout') }}" class="hero-btn secondary">
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

    <!-- Scroll Indicator -->
    <div id="scroll-indicator" class="absolute bottom-8 left-1/2 transform -translate-x-1/2 opacity-0">
        <div class="animate-bounce">
            <svg class="w-6 h-6 text-white/60" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3" />
            </svg>
        </div>
    </div>
</section>
