<section class="cta-section py-20 bg-gradient-to-br from-slate-900 via-blue-900 to-slate-800 relative overflow-hidden">
    <!-- Background Elements -->
    <div class="absolute inset-0">
        <div id="cta-circle-1" class="cta-bg-circle bg-blue-500/10 top-0 left-0 w-96 h-96"></div>
        <div id="cta-circle-2" class="cta-bg-circle bg-green-500/10 bottom-0 right-0 w-96 h-96"></div>
        <div id="cta-circle-3" class="cta-bg-circle bg-purple-500/10 top-1/2 left-1/4 w-64 h-64"></div>
    </div>

    <!-- Floating Elements -->
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
        <div class="cta-floating-element element-1">
            <svg class="w-12 h-12 text-blue-400/20" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z" clip-rule="evenodd"/>
            </svg>
        </div>
        <div class="cta-floating-element element-2">
            <svg class="w-8 h-8 text-green-400/20" fill="currentColor" viewBox="0 0 20 20">
                <path d="M10 12a2 2 0 100-4 2 2 0 000 4z"/>
                <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd"/>
            </svg>
        </div>
        <div class="cta-floating-element element-3">
            <svg class="w-10 h-10 text-purple-400/20" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M12.316 3.051a1 1 0 01.633 1.265l-4 12a1 1 0 11-1.898-.632l4-12a1 1 0 011.265-.633zM5.707 6.293a1 1 0 010 1.414L3.414 10l2.293 2.293a1 1 0 11-1.414 1.414l-3-3a1 1 0 010-1.414l3-3a1 1 0 011.414 0zm8.586 0a1 1 0 011.414 0l3 3a1 1 0 010 1.414l-3 3a1 1 0 11-1.414-1.414L16.586 10l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd"/>
            </svg>
        </div>
    </div>

    <!-- Main Content -->
    <div class="container mx-auto px-6 text-center relative z-10">
        <!-- Badge -->
        <div id="cta-badge" class="cta-badge opacity-0">
            <span class="w-2 h-2 bg-green-400 rounded-full animate-pulse"></span>
            <span class="text-sm font-medium text-blue-300">Únete Ahora</span>
        </div>

        <!-- Title -->
        <h2 id="cta-title" class="text-4xl md:text-6xl font-bold text-white mb-8 leading-tight opacity-0">
            Únete a la
            <span class="bg-gradient-to-r from-blue-400 to-green-400 bg-clip-text text-transparent">
                Revolución del Conocimiento Libre
            </span>
        </h2>

        <!-- Description -->
        <p id="cta-description" class="text-xl text-slate-200 mb-12 max-w-3xl mx-auto leading-relaxed opacity-0">
            Descubre, aprende y comparte en una plataforma construida por y para la comunidad educativa global. 
            Acceso ilimitado, completamente gratuito.
        </p>

        <!-- Action Buttons -->
        <div id="cta-buttons" class="flex flex-col sm:flex-row gap-6 justify-center items-center mb-16 opacity-0">
            <a href="{{ route('homebook') }}" class="cta-btn primary">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                </svg>
                Explorar Biblioteca
            </a>
            <a href="{{ route('register') }}" class="cta-btn secondary">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                </svg>
                Unirse a la Comunidad
            </a>
        </div>

        {{-- <!-- Trust Indicators Gallery -->
        <div class="trust-gallery">
            <!-- Trust Item 1 -->
            <div class="trust-item">
                <div class="trust-image-container">
                    <img src="{{ asset('img/trust/verified.jpg') }}" alt="Contenido Verificado" class="trust-image" />
                    <div class="trust-overlay">
                        <h3 class="trust-number">#001</h3>
                    </div>
                </div>
                <div class="trust-content">
                    <div class="trust-icon">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                        </svg>
                    </div>
                    <div class="trust-text">
                        <div class="trust-title">Contenido Verificado</div>
                        <div class="trust-subtitle">Por la comunidad</div>
                    </div>
                </div>
            </div>

            <!-- Trust Item 2 -->
            <div class="trust-item">
                <div class="trust-image-container">
                    <img src="{{ asset('img/trust/download.jpg') }}" alt="Descarga Inmediata" class="trust-image" />
                    <div class="trust-overlay">
                        <h3 class="trust-number">#002</h3>
                    </div>
                </div>
                <div class="trust-content">
                    <div class="trust-icon">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                        </svg>
                    </div>
                    <div class="trust-text">
                        <div class="trust-title">Descarga Inmediata</div>
                        <div class="trust-subtitle">Sin esperas</div>
                    </div>
                </div>
            </div>

            <!-- Trust Item 3 -->
            <div class="trust-item">
                <div class="trust-image-container">
                    <img src="{{ asset('img/trust/opensource.jpg') }}" alt="Código Abierto" class="trust-image" />
                    <div class="trust-overlay">
                        <h3 class="trust-number">#003</h3>
                    </div>
                </div>
                <div class="trust-content">
                    <div class="trust-icon">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M12.316 3.051a1 1 0 01.633 1.265l-4 12a1 1 0 11-1.898-.632l4-12a1 1 0 011.265-.633zM5.707 6.293a1 1 0 010 1.414L3.414 10l2.293 2.293a1 1 0 11-1.414 1.414l-3-3a1 1 0 010-1.414l3-3a1 1 0 011.414 0zm8.586 0a1 1 0 011.414 0l3 3a1 1 0 010 1.414l-3 3a1 1 0 11-1.414-1.414L16.586 10l-2.293-2.293a1 1 0 010-1.414z"
                                clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="trust-text">
                        <div class="trust-title">Código Abierto</div>
                        <div class="trust-subtitle">100% transparente</div>
                    </div>
                </div>
            </div>

            <!-- Trust Item 4 -->
            <div class="trust-item">
                <div class="trust-image-container">
                    <img src="{{ asset('img/trust/community.jpg') }}" alt="Comunidad Global" class="trust-image" />
                    <div class="trust-overlay">
                        <h3 class="trust-number">#004</h3>
                    </div>
                </div>
                <div class="trust-content">
                    <div class="trust-icon">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                    </div>
                    <div class="trust-text">
                        <div class="trust-title">Comunidad Global</div>
                        <div class="trust-subtitle">+10k miembros</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section> --}}

<style>
    .cta-section {
        position: relative;
    }

    .cta-bg-circle {
        position: absolute;
        border-radius: 50%;
        filter: blur(64px);
    }

    .cta-floating-element {
        position: absolute;
        opacity: 0.3;
    }

    .cta-floating-element.element-1 {
        top: 20%;
        left: 10%;
    }

    .cta-floating-element.element-2 {
        top: 60%;
        right: 15%;
    }

    .cta-floating-element.element-3 {
        bottom: 20%;
        left: 20%;
    }

    .cta-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        background: rgba(255, 255, 255, 0.1);
        backdrop-filter: blur(8px);
        border: 1px solid rgba(255, 255, 255, 0.2);
        padding: 0.75rem 1.5rem;
        border-radius: 9999px;
        margin-bottom: 2rem;
    }

    .cta-btn {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        padding: 1.25rem 3rem;
        border-radius: 1rem;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.3s ease;
        font-size: 1.125rem;
    }

    .cta-btn.primary {
        background: #10b981;
        color: white;
        box-shadow: 0 10px 25px rgba(16, 185, 129, 0.3);
    }

    .cta-btn.primary:hover {
        background: #059669;
        transform: translateY(-3px);
        box-shadow: 0 20px 40px rgba(16, 185, 129, 0.4);
    }

    .cta-btn.secondary {
        border: 2px solid rgba(255, 255, 255, 0.3);
        color: white;
        backdrop-filter: blur(8px);
    }

    .cta-btn.secondary:hover {
        background: white;
        color: #1e293b;
        border-color: white;
        transform: translateY(-3px);
    }

    .trust-gallery {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 2rem;
        max-width: 1200px;
        margin: 0 auto;
        padding-top: 4rem;
        border-top: 1px solid rgba(255, 255, 255, 0.1);
    }

    .trust-item {
        background: rgba(255, 255, 255, 0.05);
        border-radius: 1.5rem;
        overflow: hidden;
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.1);
        transition: all 0.3s ease;
    }

    .trust-item:hover {
        transform: translateY(-5px);
        border-color: rgba(59, 130, 246, 0.5);
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);
    }

    .trust-image-container {
        position: relative;
        height: 120px;
        overflow: hidden;
    }

    .trust-image {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.3s ease;
    }

    .trust-item:hover .trust-image {
        transform: scale(1.1);
    }

    .trust-overlay {
        position: absolute;
        top: 0.75rem;
        right: 0.75rem;
    }

    .trust-number {
        color: #3b82f6;
        margin: 0;
        font-family: "Azeret Mono", monospace;
        font-size: 1.5rem;
        font-weight: 700;
        letter-spacing: -1px;
        line-height: 1;
        text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
    }

    .trust-content {
        padding: 1.5rem;
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .trust-icon {
        width: 3rem;
        height: 3rem;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 0.75rem;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .trust-icon svg {
        color: #60a5fa;
    }

    .trust-text {
        flex: 1;
    }

    .trust-title {
        color: white;
        font-weight: 600;
        margin-bottom: 0.25rem;
    }

    .trust-subtitle {
        color: #cbd5e1;
        font-size: 0.875rem;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .cta-btn {
            padding: 1rem 2rem;
            font-size: 1rem;
            width: 100%;
            justify-content: center;
        }

        .trust-gallery {
            grid-template-columns: 1fr;
        }

        .trust-content {
            flex-direction: column;
            text-align: center;
        }
    }

    @media (max-width: 640px) {
        .cta-buttons {
            flex-direction: column;
            width: 100%;
        }

        .cta-btn {
            width: 100%;
        }
    }
</style>
