@props(['title', 'subtitle' => ''])

<div class="login-container">
    <div class="login-background" style="--banner-image: url('{{ asset('img/banners/banner_AyT.jpg') }}')">
        <div class="particles" id="particles"></div>

        <!-- Texto de fallback - solo visible si imagen no carga -->
        <div class="fallback-text">
            <div class="banner-logo">A&T</div>
            <div class="banner-title">
                Nuestro diseñador/editor se fue de vacaciones,<br>
                pero nuestros proyectos literarios no...
            </div>
            <div class="banner-subtitle">
                <span class="brand-highlight">GRUPO A&T</span><br>
                ...seguimos escribiendo para ti...
            </div>
        </div>
    </div>

    <!-- Lado derecho con formulario -->
    <div class="login-sidebar">
        <div class="login-card">
            <div class="login-header">
                <div class="login-logo">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                    </svg>
                </div>
                <h1 class="login-title">{{ $title }}</h1>
                @if ($subtitle)
                    <p class="login-subtitle">{{ $subtitle }}</p>
                @endif
            </div>
            {{ $slot }}
        </div>
    </div>
</div>
