<section class="py-20 bg-slate-900 overflow-hidden">
    <div class="container mx-auto px-6">
        <div class="text-center mb-16">
            <span class="text-green-400 font-semibold uppercase tracking-wider text-sm">Nuestro Impacto</span>
            <h2 class="text-4xl md:text-5xl font-bold text-white mt-4 mb-6">
                Creciendo <span
                    class="bg-gradient-to-r from-green-400 to-blue-400 bg-clip-text text-transparent">Juntos</span>
            </h2>
        </div>

        <!-- Stats Gallery -->
        <div class="stats-gallery">
            <!-- Stat 1 -->
            <div class="stat-container">
                <div class="stat-image-container">
                    <img src="{{ asset('img/stats/books.jpg') }}" alt="Libros Publicados" class="stat-image" />
                    <div class="stat-overlay">
                        <h3 class="stat-number">#001</h3>
                    </div>
                </div>
                <div class="stat-content">
                    <div class="text-4xl font-bold text-green-400 mb-2 counter" data-target="500">0</div>
                    <div class="text-slate-300">Libros Open Source</div>
                </div>
            </div>

            <!-- Stat 2 -->
            <div class="stat-container">
                <div class="stat-image-container">
                    <img src="{{ asset('img/stats/users.jpg') }}" alt="Usuarios Activos" class="stat-image" />
                    <div class="stat-overlay">
                        <h3 class="stat-number">#002</h3>
                    </div>
                </div>
                <div class="stat-content">
                    <div class="text-4xl font-bold text-blue-400 mb-2 counter" data-target="10000">0</div>
                    <div class="text-slate-300">Lectores Activos</div>
                </div>
            </div>

            <!-- Stat 3 -->
            <div class="stat-container">
                <div class="stat-image-container">
                    <img src="{{ asset('img/stats/countries.jpg') }}" alt="Países Alcanzados" class="stat-image" />
                    <div class="stat-overlay">
                        <h3 class="stat-number">#003</h3>
                    </div>
                </div>
                <div class="stat-content">
                    <div class="text-4xl font-bold text-purple-400 mb-2 counter" data-target="50">0</div>
                    <div class="text-slate-300">Países Alcanzados</div>
                </div>
            </div>

            <!-- Stat 4 -->
            <div class="stat-container">
                <div class="stat-image-container">
                    <img src="{{ asset('img/stats/downloads.jpg') }}" alt="Descargas Totales" class="stat-image" />
                    <div class="stat-overlay">
                        <h3 class="stat-number">#004</h3>
                    </div>
                </div>
                <div class="stat-content">
                    <div class="text-4xl font-bold text-yellow-400 mb-2 counter" data-target="25000">0</div>
                    <div class="text-slate-300">Descargas Totales</div>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
    .stats-gallery {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 2rem;
        max-width: 1200px;
        margin: 0 auto;
    }

    .stat-container {
        background: rgba(255, 255, 255, 0.05);
        border-radius: 1.5rem;
        overflow: hidden;
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.1);
        transition: all 0.3s ease;
    }

    .stat-container:hover {
        transform: translateY(-5px);
        border-color: rgba(59, 130, 246, 0.5);
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);
    }

    .stat-image-container {
        position: relative;
        height: 200px;
        overflow: hidden;
    }

    .stat-image {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.3s ease;
    }

    .stat-container:hover .stat-image {
        transform: scale(1.1);
    }

    .stat-overlay {
        position: absolute;
        top: 1rem;
        right: 1rem;
    }

    .stat-number {
        color: #3b82f6;
        margin: 0;
        font-family: "Azeret Mono", monospace;
        font-size: 2rem;
        font-weight: 700;
        letter-spacing: -2px;
        line-height: 1;
        text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
    }

    .stat-content {
        padding: 1.5rem;
        text-align: center;
    }
</style>
