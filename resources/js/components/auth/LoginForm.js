import { FormValidator } from '../utils/formValidator.js';

export class LoginForm {
    constructor(formId = 'loginForm') {
        this.form = document.getElementById(formId);
        this.validator = new FormValidator();
        this.init();
    }

    init() {
        if (this.form) {
            this.setupEventListeners();
            this.setupPasswordToggle();
        }
    }

    setupEventListeners() {
        this.form.addEventListener('submit', (e) => this.handleSubmit(e));

        // Validación en tiempo real
        const inputs = this.form.querySelectorAll('input[required]');
        inputs.forEach(input => {
            input.addEventListener('blur', () => this.validateField(input));
            input.addEventListener('input', () => this.clearFieldError(input));
        });
    }

    setupPasswordToggle() {
        const passwordInput = this.form.querySelector('#password');
        const toggleButton = this.form.querySelector('.password-toggle');

        if (passwordInput && toggleButton) {
            toggleButton.addEventListener('click', () => {
                const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                passwordInput.setAttribute('type', type);
                toggleButton.innerHTML = type === 'password' ? '👁️' : '👁️‍🗨️';
            });
        }
    }

    validateField(field) {
        const error = this.validator.validateField(field);
        this.displayFieldError(field, error);
        return !error;
    }

    displayFieldError(field, error) {
        this.clearFieldError(field);

        if (error) {
            field.classList.add('error');
            const errorElement = document.createElement('span');
            errorElement.className = 'form-error';
            errorElement.textContent = error;
            field.parentNode.appendChild(errorElement);
        }
    }

    clearFieldError(field) {
        field.classList.remove('error');
        const existingError = field.parentNode.querySelector('.form-error');
        if (existingError) {
            existingError.remove();
        }
    }

    async handleSubmit(e) {
        e.preventDefault();

        const isValid = this.validateForm();
        if (!isValid) return;

        this.setLoadingState(true);

        try {
            // Simular envío (en producción, esto sería real)
            await this.submitForm();
        } catch (error) {
            this.handleSubmitError(error);
        } finally {
            this.setLoadingState(false);
        }
    }

    validateForm() {
        const fields = this.form.querySelectorAll('input[required]');
        let isValid = true;

        fields.forEach(field => {
            if (!this.validateField(field)) {
                isValid = false;
            }
        });

        return isValid;
    }

    async submitForm() {
        // Aquí iría la lógica real de envío del formulario
        return new Promise((resolve) => {
            setTimeout(() => {
                // Simular éxito
                this.form.submit();
                resolve();
            }, 1000);
        });
    }

    handleSubmitError(error) {
        console.error('Error en el login:', error);
        // Podrías mostrar un mensaje de error específico aquí
    }

    setLoadingState(loading) {
        const submitButton = this.form.querySelector('.submit-button');

        if (loading) {
            submitButton.disabled = true;
            submitButton.classList.add('loading');
            submitButton.textContent = 'Iniciando Sesión...';
        } else {
            submitButton.disabled = false;
            submitButton.classList.remove('loading');
            submitButton.textContent = 'Iniciar Sesión';
        }
    }
}