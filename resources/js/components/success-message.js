export class SuccessMessage {
    constructor(elementId = 'successMessage') {
        this.element = document.getElementById(elementId);
        this.init();
    }

    init() {
        if (this.element) {
            setTimeout(() => {
                this.hide();
            }, 5000);
        }
    }

    hide() {
        if (this.element) {
            this.element.style.opacity = '0';
            this.element.style.transition = 'opacity 0.5s ease';
            setTimeout(() => {
                this.element.remove();
            }, 500);
        }
    }
}