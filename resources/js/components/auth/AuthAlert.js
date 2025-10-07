export class AuthAlert {
    constructor() {
        this.alerts = document.querySelectorAll('.alert');
        this.init();
    }

    init() {
        this.setupAutoDismiss();
        this.setupCloseButtons();
    }

    setupAutoDismiss() {
        this.alerts.forEach(alert => {
            const duration = alert.dataset.duration || 5000;

            setTimeout(() => {
                this.dismissAlert(alert);
            }, duration);
        });
    }

    setupCloseButtons() {
        this.alerts.forEach(alert => {
            const closeButton = alert.querySelector('.alert-close');
            if (closeButton) {
                closeButton.addEventListener('click', () => {
                    this.dismissAlert(alert);
                });
            }
        });
    }

    dismissAlert(alert) {
        alert.style.opacity = '0';
        alert.style.transform = 'translateY(-20px)';
        alert.style.transition = 'all 0.3s ease';

        setTimeout(() => {
            alert.remove();
        }, 300);
    }

    static showMessage(type, message, duration = 5000) {
        const alert = document.createElement('div');
        alert.className = `alert alert-${type}`;
        alert.innerHTML = `
            ${message}
            <button class="alert-close">&times;</button>
        `;

        document.body.appendChild(alert);
        new AuthAlert();

        setTimeout(() => {
            if (alert.parentNode) {
                alert.remove();
            }
        }, duration);
    }
}