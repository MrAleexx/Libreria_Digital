// resources/js/book-information.js

class BookInformation {
    constructor() {
        this.currentTab = 'info';
        this.init();
    }

    init() {
        this.bindEvents();
        this.initImageHover();
        this.initQuantityControl();
    }

    bindEvents() {
        // Sistema de pestañas
        this.initTabs();

        // Acciones de usuario
        this.initUserActions();

        // Manejo de formularios
        this.initFormHandling();
    }

    initTabs() {
        const tabButtons = document.querySelectorAll('.tab-button');
        const tabContents = document.querySelectorAll('.tab-content');

        tabButtons.forEach(button => {
            button.addEventListener('click', (e) => {
                e.preventDefault();
                this.switchTab(button);
            });

            // Soporte para teclado
            button.addEventListener('keydown', (e) => {
                if (e.key === 'Enter' || e.key === ' ') {
                    e.preventDefault();
                    this.switchTab(button);
                }
            });
        });
    }

    switchTab(button) {
        const tabName = button.getAttribute('data-tab');

        // Remover clase active de todos los botones y contenidos
        document.querySelectorAll('.tab-button').forEach(btn => {
            btn.classList.remove('active');
        });

        document.querySelectorAll('.tab-content').forEach(content => {
            content.classList.remove('active');
        });

        // Añadir clase active al botón clickeado
        button.classList.add('active');

        // Mostrar contenido correspondiente
        const contentId = `content-${tabName}`;
        const contentElement = document.getElementById(contentId);

        if (contentElement) {
            contentElement.classList.add('active');
            this.currentTab = tabName;

            // Disparar evento personalizado
            this.dispatchTabChangeEvent(tabName);
        }
    }

    dispatchTabChangeEvent(tabName) {
        const event = new CustomEvent('bookTabChanged', {
            detail: { tab: tabName }
        });
        document.dispatchEvent(event);
    }

    initQuantityControl() {
        const quantityInput = document.getElementById('quantity');
        const decrementBtn = document.querySelector('.quantity-btn.decrement');
        const incrementBtn = document.querySelector('.quantity-btn.increment');

        if (!quantityInput || !decrementBtn || !incrementBtn) return;

        decrementBtn.addEventListener('click', () => {
            this.changeQuantity(-1);
        });

        incrementBtn.addEventListener('click', () => {
            this.changeQuantity(1);
        });

        quantityInput.addEventListener('input', (e) => {
            this.validateQuantityInput(e.target);
        });

        quantityInput.addEventListener('change', (e) => {
            this.validateQuantityInput(e.target);
        });

        // Soporte para teclado
        quantityInput.addEventListener('keydown', (e) => {
            if (e.key === 'ArrowUp') {
                e.preventDefault();
                this.changeQuantity(1);
            } else if (e.key === 'ArrowDown') {
                e.preventDefault();
                this.changeQuantity(-1);
            }
        });
    }

    changeQuantity(delta) {
        const quantityInput = document.getElementById('quantity');
        if (!quantityInput) return;

        let currentValue = parseInt(quantityInput.value) || 1;
        let newValue = currentValue + delta;

        // Validar límites
        if (newValue >= 1 && newValue <= 5) {
            quantityInput.value = newValue;
            this.animateQuantityChange(quantityInput);

            // Disparar evento de cambio
            quantityInput.dispatchEvent(new Event('change', { bubbles: true }));
        }
    }

    validateQuantityInput(input) {
        let value = parseInt(input.value);

        if (isNaN(value) || value < 1) {
            input.value = 1;
        } else if (value > 5) {
            input.value = 5;
        }

        this.animateQuantityChange(input);
    }

    animateQuantityChange(input) {
        input.classList.add('quantity-changing');
        setTimeout(() => {
            input.classList.remove('quantity-changing');
        }, 200);
    }

    initImageHover() {
        const bookImage = document.querySelector('.book-cover-image');
        if (!bookImage) return;

        bookImage.addEventListener('mouseenter', () => {
            bookImage.style.transform = 'scale(1.03)';
        });

        bookImage.addEventListener('mouseleave', () => {
            bookImage.style.transform = 'scale(1)';
        });

        // Touch devices
        bookImage.addEventListener('touchstart', () => {
            bookImage.style.transform = 'scale(1.03)';
        });

        bookImage.addEventListener('touchend', () => {
            bookImage.style.transform = 'scale(1)';
        });
    }

    initUserActions() {
        // Compartir libro
        const shareBtn = document.querySelector('.share-btn');
        if (shareBtn) {
            shareBtn.addEventListener('click', () => this.shareBook());
        }

        // Añadir a favoritos
        const wishlistBtn = document.querySelector('.wishlist-btn');
        if (wishlistBtn) {
            wishlistBtn.addEventListener('click', () => this.toggleWishlist());
        }
    }

    initFormHandling() {
        const purchaseForm = document.querySelector('.purchase-form');
        if (purchaseForm) {
            purchaseForm.addEventListener('submit', (e) => {
                this.handlePurchaseForm(e);
            });
        }
    }

    async shareBook() {
        const bookTitle = document.querySelector('.book-title')?.textContent?.trim() || 'Libro';
        const bookAuthor = document.querySelector('.book-author')?.textContent?.replace('por ', '').trim() || '';

        const shareData = {
            title: `📚 ${bookTitle}`,
            text: `Te recomiendo el libro "${bookTitle}" por ${bookAuthor}. Échale un vistazo en Grupo A&T.`,
            url: window.location.href,
        };

        try {
            if (navigator.share && navigator.canShare(shareData)) {
                await navigator.share(shareData);
                this.showNotification('¡Libro compartido exitosamente!', 'success');
            } else {
                // Fallback: copiar enlace al portapapeles
                await navigator.clipboard.writeText(window.location.href);
                this.showNotification('Enlace copiado al portapapeles', 'success');
            }
        } catch (error) {
            if (error.name !== 'AbortError') {
                console.error('Error al compartir:', error);
                this.showNotification('Error al compartir el libro', 'error');
            }
        }
    }

    toggleWishlist() {
        const wishlistBtn = document.querySelector('.wishlist-btn');
        const icon = wishlistBtn.querySelector('i');

        if (icon.classList.contains('far')) {
            // Añadir a favoritos
            icon.className = 'fas fa-heart';
            wishlistBtn.style.color = '#ef4444';
            this.showNotification('Libro añadido a tus favoritos', 'success');

            // this.addToWishlistAPI();
        } else {
            // Remover de favoritos
            icon.className = 'far fa-heart';
            wishlistBtn.style.color = '';
            this.showNotification('Libro removido de tus favoritos', 'info');

            // this.removeFromWishlistAPI();
        }
    }

    handlePurchaseForm(e) {
        const quantityInput = document.getElementById('quantity');
        const quantity = parseInt(quantityInput.value);

        // Validación adicional
        if (quantity < 1 || quantity > 5) {
            e.preventDefault();
            this.showNotification('La cantidad debe estar entre 1 y 5', 'error');
            return;
        }

        // Mostrar loading state
        const submitBtn = e.target.querySelector('.add-to-cart-btn');
        const originalText = submitBtn.innerHTML;

        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> AÑADIENDO...';
        submitBtn.disabled = true;

        // Restaurar después de 2 segundos (simulación)
        setTimeout(() => {
            submitBtn.innerHTML = originalText;
            submitBtn.disabled = false;
        }, 2000);
    }

    showNotification(message, type = 'info') {
        // Remover notificaciones existentes
        const existingNotifications = document.querySelectorAll('.book-notification');
        existingNotifications.forEach(notification => notification.remove());

        // Crear notificación
        const notification = document.createElement('div');
        const typeConfig = {
            success: { bg: 'bg-green-500', icon: 'fa-check-circle' },
            error: { bg: 'bg-red-500', icon: 'fa-exclamation-circle' },
            info: { bg: 'bg-blue-500', icon: 'fa-info-circle' }
        }[type] || { bg: 'bg-blue-500', icon: 'fa-info-circle' };

        notification.className = `book-notification fixed top-4 right-4 ${typeConfig.bg} text-white px-6 py-3 rounded-lg shadow-xl z-50 transform transition-all duration-300 translate-x-full`;
        notification.innerHTML = `
            <div class="flex items-center gap-3">
                <i class="fas ${typeConfig.icon}"></i>
                <span class="font-medium">${message}</span>
            </div>
        `;

        document.body.appendChild(notification);

        // Animación de entrada
        requestAnimationFrame(() => {
            notification.classList.remove('translate-x-full');
        });

        // Auto-remover después de 4 segundos
        setTimeout(() => {
            notification.classList.add('translate-x-full');
            setTimeout(() => {
                if (notification.parentNode) {
                    notification.remove();
                }
            }, 300);
        }, 4000);

        // Cerrar al hacer click
        notification.addEventListener('click', () => {
            notification.classList.add('translate-x-full');
            setTimeout(() => {
                if (notification.parentNode) {
                    notification.remove();
                }
            }, 300);
        });
    }

    // Métodos para API (placeholder)
    async addToWishlistAPI() {
        // Implementar llamada API para añadir a favoritos
        // await fetch('/api/wishlist/add', { method: 'POST', body: JSON.stringify({ bookId: this.bookId }) });
    }

    async removeFromWishlistAPI() {
        // Implementar llamada API para remover de favoritos
        // await fetch('/api/wishlist/remove', { method: 'POST', body: JSON.stringify({ bookId: this.bookId }) });
    }
}

// Inicialización
document.addEventListener('DOMContentLoaded', function () {
    window.bookInformation = new BookInformation();
});

// Exportar para uso modular
if (typeof module !== 'undefined' && module.exports) {
    module.exports = BookInformation;
}