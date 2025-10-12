<section class="py-20 bg-slate-50 overflow-hidden">
    <div class="container mx-auto px-6">
        <div class="text-center mb-16">
            <span class="text-blue-600 font-semibold uppercase tracking-wider text-sm">¿Por qué OpenReads?</span>
            <h2 class="text-4xl md:text-5xl font-bold text-slate-900 mt-4 mb-6">
                Conocimiento Libre,
                <span class="bg-gradient-to-r from-blue-600 to-green-600 bg-clip-text text-transparent">
                    Acceso Ilimitado
                </span>
            </h2>
        </div>

        <!-- Horizontal Scroll Gallery -->
        <div class="features-gallery-container">
            <div class="features-track">
                <!-- Feature 1 -->
                <div class="feature-card">
                    <div class="feature-image-container">
                        <img src="{{ asset('img/features/access.jpg') }}" alt="Acceso Sin Restricciones"
                            class="feature-image" />
                        <div class="feature-overlay">
                            <h3 class="feature-number">#001</h3>
                        </div>
                    </div>
                    <div class="feature-content">
                        <h3 class="text-xl font-bold text-slate-900 mb-4">Acceso Sin Restricciones</h3>
                        <p class="text-slate-600 leading-relaxed">
                            Todos nuestros libros son de código abierto y completamente gratuitos.
                            Sin suscripciones, sin pagos, solo conocimiento libre.
                        </p>
                    </div>
                </div>

                <!-- Feature 2 -->
                <div class="feature-card">
                    <div class="feature-image-container">
                        <img src="{{ asset('img/features/community.jpg') }}" alt="Comunidad Colaborativa"
                            class="feature-image" />
                        <div class="feature-overlay">
                            <h3 class="feature-number">#002</h3>
                        </div>
                    </div>
                    <div class="feature-content">
                        <h3 class="text-xl font-bold text-slate-900 mb-4">Comunidad Colaborativa</h3>
                        <p class="text-slate-600 leading-relaxed">
                            Únete a una red global de educadores y contribuidores que comparten
                            recursos educativos abiertos.
                        </p>
                    </div>
                </div>

                <!-- Feature 3 -->
                <div class="feature-card">
                    <div class="feature-image-container">
                        <img src="{{ asset('img/features/reader.jpg') }}" alt="Lector Integrado"
                            class="feature-image" />
                        <div class="feature-overlay">
                            <h3 class="feature-number">#003</h3>
                        </div>
                    </div>
                    <div class="feature-content">
                        <h3 class="text-xl font-bold text-slate-900 mb-4">Lector Integrado</h3>
                        <p class="text-slate-600 leading-relaxed">
                            Experiencia de lectura optimizada con múltiples formatos y herramientas
                            de estudio integradas.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
    .features-gallery-container {
        overflow-x: auto;
        scroll-snap-type: x mandatory;
        scroll-behavior: smooth;
        -webkit-overflow-scrolling: touch;
        padding: 2rem 0;
    }

    .features-track {
        display: flex;
        gap: 2rem;
        padding: 0 2rem;
    }

    .feature-card {
        scroll-snap-align: start;
        flex: 0 0 calc(80vw - 4rem);
        max-width: 400px;
        background: white;
        border-radius: 1.5rem;
        overflow: hidden;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
    }

    .feature-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
    }

    .feature-image-container {
        position: relative;
        height: 250px;
        overflow: hidden;
    }

    .feature-image {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.3s ease;
    }

    .feature-card:hover .feature-image {
        transform: scale(1.05);
    }

    .feature-overlay {
        position: absolute;
        top: 1rem;
        right: 1rem;
    }

    .feature-number {
        color: #3b82f6;
        margin: 0;
        font-family: "Azeret Mono", monospace;
        font-size: 2.5rem;
        font-weight: 700;
        letter-spacing: -2px;
        line-height: 1;
        text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
    }

    .feature-content {
        padding: 1.5rem;
    }

    @media (min-width: 768px) {
        .feature-card {
            flex: 0 0 calc(50vw - 4rem);
        }
    }

    @media (min-width: 1024px) {
        .feature-card {
            flex: 0 0 calc(33.333vw - 4rem);
        }
    }
</style>
