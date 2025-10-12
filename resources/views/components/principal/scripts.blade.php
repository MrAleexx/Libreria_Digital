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
        // Progress bar para scroll global
        const progressBar = document.createElement('div');
        progressBar.className = 'scroll-progress';
        document.body.appendChild(progressBar);

        scroll(animate(".scroll-progress", {
            scaleX: [0, 1]
        }, {
            ease: "linear"
        }));

        // Animación de entrada del hero
        const heroSequence = timeline([
            ['#hero-badge', { opacity: 1, y: [30, 0] }, { duration: 0.8, easing: 'ease-out' }],
            ['#hero-title', { opacity: 1 }, { duration: 0.8, at: 0.2 }],
            ['#hero-subtitle', { opacity: 1, y: [-20, 0] }, { duration: 0.8, at: 0.4 }],
            ['#hero-buttons', { opacity: 1 }, { duration: 0.6, at: 0.6 }],
            ['#hero-stats', { opacity: 1 }, { duration: 0.8, at: 0.8 }],
            ['#scroll-indicator', { opacity: 1 }, { duration: 0.6, at: 1.0 }]
        ]);
        
        // Animación de círculos flotantes
        animate('#floating-circle-1', {
            x: [0, 100, 0],
            y: [0, -50, 0],
            scale: [1, 1.2, 1]
        }, {
            duration: 15,
            repeat: Infinity,
            easing: 'ease-in-out'
        });

        animate('#floating-circle-2', {
            x: [0, -80, 0],
            y: [0, 60, 0],
            scale: [1, 1.1, 1]
        }, {
            duration: 12,
            repeat: Infinity,
            easing: 'ease-in-out',
            delay: 2
        });

        animate('#floating-circle-3', {
            x: [0, 60, 0],
            y: [0, -30, 0],
            scale: [1, 1.15, 1]
        }, {
            duration: 18,
            repeat: Infinity,
            easing: 'ease-in-out',
            delay: 4
        });

        // Animaciones para features gallery
        document.querySelectorAll(".feature-card").forEach((section, index) => {
            const header = section.querySelector(".feature-number");

            // Efecto parallax en los números
            scroll(animate(header, {
                y: [-100, 100]
            }, {
                ease: "linear"
            }), {
                target: header,
            });

            // Animación de entrada
            inView(section, () => {
                animate(section, {
                    opacity: [0, 1],
                    x: [50, 0]
                }, {
                    duration: 0.8,
                    delay: index * 0.1,
                    easing: 'ease-out'
                });
            }, {
                margin: '-50px'
            });
        });

        // Animaciones para stats gallery
        document.querySelectorAll(".stat-container").forEach((section, index) => {
            const header = section.querySelector(".stat-number");

            scroll(animate(header, {
                y: [-80, 80]
            }, {
                ease: "linear"
            }), {
                target: header,
            });

            inView(section, () => {
                animate(section, {
                    opacity: [0, 1],
                    y: [30, 0]
                }, {
                    duration: 0.6,
                    delay: index * 0.1,
                    easing: 'ease-out'
                });
            }, {
                margin: '-50px'
            });
        });

        // Animaciones para el libro destacado
        document.querySelectorAll(".featured-book-container").forEach((section) => {
            const header = section.querySelector(".book-image-number");

            scroll(animate(header, {
                y: [-100, 100]
            }, {
                ease: "linear"
            }), {
                target: header,
            });

            inView(section, () => {
                animate(section, {
                    opacity: [0, 1],
                    y: [40, 0]
                }, {
                    duration: 1,
                    easing: 'ease-out'
                });
            }, {
                margin: '-50px'
            });
        });

        // Animaciones para CTA
        const ctaSequence = timeline([
            ['#cta-badge', {
                opacity: 1,
                y: [30, 0]
            }, {
                duration: 0.8,
                easing: 'ease-out'
            }],
            ['#cta-title', {
                opacity: 1
            }, {
                duration: 0.8,
                at: 0.2
            }],
            ['#cta-description', {
                opacity: 1,
                y: [-20, 0]
            }, {
                duration: 0.8,
                at: 0.4
            }],
            ['#cta-buttons', {
                opacity: 1
            }, {
                duration: 0.6,
                at: 0.6
            }]
        ]);

        // Animaciones para trust gallery
        document.querySelectorAll(".trust-item").forEach((section, index) => {
            const header = section.querySelector(".trust-number");

            scroll(animate(header, {
                y: [-60, 60]
            }, {
                ease: "linear"
            }), {
                target: header,
            });

            inView(section, () => {
                animate(section, {
                    opacity: [0, 1],
                    x: [index % 2 === 0 ? -30 : 30, 0]
                }, {
                    duration: 0.6,
                    delay: index * 0.1,
                    easing: 'ease-out'
                });
            }, {
                margin: '-50px'
            });
        });

        // Animaciones para círculos del CTA
        animate('#cta-circle-1', {
            x: [0, 50, 0],
            y: [0, -30, 0],
            scale: [1, 1.1, 1]
        }, {
            duration: 20,
            repeat: Infinity,
            easing: 'ease-in-out'
        });

        animate('#cta-circle-2', {
            x: [0, -40, 0],
            y: [0, 40, 0],
            scale: [1, 1.05, 1]
        }, {
            duration: 15,
            repeat: Infinity,
            easing: 'ease-in-out',
            delay: 5
        });

        animate('#cta-circle-3', {
            x: [0, 30, 0],
            y: [0, -20, 0],
            scale: [1, 1.08, 1]
        }, {
            duration: 25,
            repeat: Infinity,
            easing: 'ease-in-out',
            delay: 10
        });

        // Animaciones para elementos flotantes del CTA
        animate('.cta-floating-element.element-1', {
            y: [0, -20, 0],
            rotate: [0, 10, 0]
        }, {
            duration: 6,
            repeat: Infinity,
            easing: 'ease-in-out'
        });

        animate('.cta-floating-element.element-2', {
            y: [0, 15, 0],
            rotate: [0, -5, 0]
        }, {
            duration: 4,
            repeat: Infinity,
            easing: 'ease-in-out',
            delay: 1
        });

        animate('.cta-floating-element.element-3', {
            y: [0, -25, 0],
            rotate: [0, 8, 0]
        }, {
            duration: 5,
            repeat: Infinity,
            easing: 'ease-in-out',
            delay: 2
        });

        // Contadores animados
        inView('.counter', ({
            target
        }) => {
            if (target.textContent === '0') {
                const targetValue = parseInt(target.getAttribute('data-target'));
                const duration = 2000;
                const step = targetValue / (duration / 16);
                let current = 0;

                const updateCounter = () => {
                    current += step;
                    if (current < targetValue) {
                        target.textContent = Math.floor(current).toLocaleString();
                        requestAnimationFrame(updateCounter);
                    } else {
                        target.textContent = targetValue.toLocaleString();
                    }
                };
                updateCounter();
            }
        }, {
            margin: '-50px'
        });

        // Micro-interacciones
        const heroButtons = document.querySelectorAll('.hero-btn');
        heroButtons.forEach(button => {
            button.addEventListener('mouseenter', () => {
                animate(button, {
                    scale: 1.05
                }, {
                    duration: 0.2,
                    easing: 'ease-out'
                });
            });

            button.addEventListener('mouseleave', () => {
                animate(button, {
                    scale: 1
                }, {
                    duration: 0.2,
                    easing: 'ease-out'
                });
            });
        });

        // Scroll indicator animation
        animate('#scroll-indicator', {
            y: [0, -10, 0]
        }, {
            duration: 1.5,
            repeat: Infinity,
            easing: 'ease-in-out'
        });

        // Efecto de partículas sutiles
        function createParticles() {
            const heroSection = document.querySelector('.hero-section');
            if (!heroSection) return;
            
            for (let i = 0; i < 12; i++) {
                const particle = document.createElement('div');
                particle.className = 'absolute w-1 h-1 bg-white/20 rounded-full pointer-events-none';
                particle.style.left = Math.random() * 100 + '%';
                particle.style.top = Math.random() * 100 + '%';
                heroSection.appendChild(particle);

                animate(particle, {
                    y: [0, -40],
                    opacity: [0, 0.6, 0],
                    scale: [1, 1.5, 1]
                }, {
                    duration: 2 + Math.random() * 2,
                    repeat: Infinity,
                    delay: Math.random() * 2,
                    easing: 'ease-in-out'
                });
            }
        }
        createParticles();

        // Smooth scroll para enlaces internos
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });

        // Efectos hover para feature icons
        const featureIcons = document.querySelectorAll('.feature-icon');
        featureIcons.forEach(icon => {
            icon.addEventListener('mouseenter', () => {
                animate(icon, {
                    scale: 1.1,
                    rotate: 5
                }, {
                    duration: 0.3,
                    easing: 'ease-out'
                });
            });

            icon.addEventListener('mouseleave', () => {
                animate(icon, {
                    scale: 1,
                    rotate: 0
                }, {
                    duration: 0.3,
                    easing: 'ease-out'
                });
            });
        });

        // Efectos hover para cards
        const interactiveCards = document.querySelectorAll('.feature-card, .stat-container, .trust-item');
        interactiveCards.forEach(card => {
            card.addEventListener('mouseenter', () => {
                animate(card, {
                    y: -5,
                    scale: 1.02
                }, {
                    duration: 0.3,
                    easing: 'ease-out'
                });
            });

            card.addEventListener('mouseleave', () => {
                animate(card, {
                    y: 0,
                    scale: 1
                }, {
                    duration: 0.3,
                    easing: 'ease-out'
                });
            });
        });

        // Detectar preferencia de movimiento reducido
        const prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
        if (prefersReducedMotion) {
            // Desactivar animaciones complejas
            document.querySelectorAll('*').forEach(el => {
                el.style.animation = 'none';
            });
        }
    });
</script>

<style>
    /* Estilos globales para las animaciones */
    .floating-bg-circle {
        position: absolute;
        border-radius: 50%;
        mix-blend-mode: multiply;
        filter: blur(64px);
    }

    .hero-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.75rem;
        background: rgba(255, 255, 255, 0.1);
        backdrop-filter: blur(8px);
        border: 1px solid rgba(255, 255, 255, 0.2);
        padding: 0.75rem 1.5rem;
        border-radius: 9999px;
        margin-bottom: 2rem;
    }

    .hero-btn {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        padding: 1rem 2rem;
        border-radius: 0.75rem;
        font-weight: 600;
        transition: all 0.3s ease;
        text-decoration: none;
    }

    .hero-btn.primary {
        background: #2563eb;
        color: white;
        box-shadow: 0 10px 25px rgba(37, 99, 235, 0.3);
    }

    .hero-btn.primary:hover {
        background: #1d4ed8;
        transform: translateY(-2px);
        box-shadow: 0 15px 35px rgba(37, 99, 235, 0.4);
    }

    .hero-btn.secondary {
        border: 2px solid rgba(255, 255, 255, 0.3);
        color: white;
        backdrop-filter: blur(8px);
    }

    .hero-btn.secondary:hover {
        background: white;
        color: #1e293b;
        border-color: white;
    }

    /* Mejoras de rendimiento */
    .feature-card,
    .stat-container,
    .hero-btn {
        will-change: transform, opacity;
    }

    /* Scroll snapping mejorado */
    .features-gallery-container::-webkit-scrollbar {
        height: 8px;
    }

    .features-gallery-container::-webkit-scrollbar-track {
        background: rgba(0, 0, 0, 0.1);
        border-radius: 4px;
    }

    .features-gallery-container::-webkit-scrollbar-thumb {
        background: #3b82f6;
        border-radius: 4px;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .features-track {
            gap: 1rem;
            padding: 0 1rem;
        }

        .feature-card {
            flex: 0 0 calc(85vw - 2rem);
        }

        .stats-gallery {
            grid-template-columns: 1fr;
        }
    }

    /* Prefers reduced motion */
    @media (prefers-reduced-motion: reduce) {
        * {
            animation-duration: 0.01ms !important;
            animation-iteration-count: 1 !important;
            transition-duration: 0.01ms !important;
        }
    }
</style>
