export class LoginParticles {
    constructor(containerId = 'particles') {
        this.container = document.getElementById(containerId);
        this.particles = [];
        this.init();
    }

    init() {
        if (this.container) {
            this.createParticles();
            this.startAnimation();
        }
    }

    createParticles() {
        const particleCount = 15;

        for (let i = 0; i < particleCount; i++) {
            this.createParticle();
        }
    }

    createParticle() {
        const particle = document.createElement('div');
        particle.className = 'particle';

        // Tamaño aleatorio
        const size = Math.random() * 60 + 20;
        particle.style.width = `${size}px`;
        particle.style.height = `${size}px`;

        // Posición aleatoria
        particle.style.left = `${Math.random() * 100}%`;
        particle.style.top = `${Math.random() * 100}%`;

        // Opacidad aleatoria
        particle.style.opacity = Math.random() * 0.3 + 0.1;

        // Color basado en la paleta de la empresa
        const colors = [
            'rgba(234, 146, 22, 0.1)',
            'rgba(5, 47, 90, 0.1)',
            'rgba(39, 43, 48, 0.1)'
        ];
        particle.style.background = colors[Math.floor(Math.random() * colors.length)];

        // Animación única
        const duration = Math.random() * 10 + 10;
        const delay = Math.random() * 5;
        particle.style.animationDuration = `${duration}s`;
        particle.style.animationDelay = `${delay}s`;

        this.container.appendChild(particle);
        this.particles.push(particle);
    }

    startAnimation() {
        // La animación se maneja via CSS
    }

    destroy() {
        this.particles.forEach(particle => {
            if (particle.parentNode) {
                particle.remove();
            }
        });
        this.particles = [];
    }
}