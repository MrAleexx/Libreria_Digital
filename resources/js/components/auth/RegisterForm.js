import { LoginParticles } from '../LoginParticles.js';
import { FormValidator } from '../Auth/Utils/FormValidator.js';

export class RegisterForm {
    constructor() {
        this.form = document.getElementById('registerForm');
        this.validator = new FormValidator();
        this.init();
    }

    init() {
        if (this.form) {
            this.initParticles();
            this.setupEventListeners();
            this.setupCustomValidation();
        }
    }

    initParticles() {
        try {
            // Usar el contenedor de partículas del registro
            const particlesContainer = document.getElementById('particles');
            if (particlesContainer) {
                new LoginParticles('particles');
            }
        } catch (error) {
            console.warn('LoginParticles no pudo inicializarse:', error);
        }
    }

    setupEventListeners() {
        // Validación en tiempo real
        const inputs = this.form.querySelectorAll('input[required]');
        inputs.forEach(input => {
            input.addEventListener('blur', this.validateField.bind(this));
            input.addEventListener('input', this.clearFieldError.bind(this));
        });

        // Validación al enviar formulario
        this.form.addEventListener('submit', this.handleSubmit.bind(this));
    }

    setupCustomValidation() {
        // Validación personalizada para DNI
        const dniInput = this.form.querySelector('input[name="dni"]');
        if (dniInput) {
            dniInput.addEventListener('blur', this.validateDNI.bind(this));
        }

        // Validación personalizada para teléfono
        const phoneInput = this.form.querySelector('input[name="phone"]');
        if (phoneInput) {
            phoneInput.addEventListener('blur', this.validatePhone.bind(this));
        }

        // Validación de confirmación de contraseña
        const passwordInput = this.form.querySelector('input[name="password"]');
        const confirmPasswordInput = this.form.querySelector('input[name="password_confirmation"]');

        if (passwordInput && confirmPasswordInput) {
            confirmPasswordInput.addEventListener('blur', this.validatePasswordMatch.bind(this));
        }
    }

    validateField(event) {
        const field = event.target;
        const error = this.validator.validateField(field);
        this.displayFieldError(field, error);
    }

    validateDNI(event) {
        const field = event.target;
        const value = field.value.trim();

        if (!value) return;

        const dniRegex = /^\d{8}$/;
        if (!dniRegex.test(value)) {
            this.displayFieldError(field, 'El DNI debe tener 8 dígitos numéricos');
            return;
        }

        this.clearFieldError(field);
    }

    validatePhone(event) {
        const field = event.target;
        const value = field.value.trim();

        if (!value) return;

        const phoneRegex = /^\d{9}$/;
        if (!phoneRegex.test(value)) {
            this.displayFieldError(field, 'El teléfono debe tener 9 dígitos numéricos');
            return;
        }

        this.clearFieldError(field);
    }

    validatePasswordMatch(event) {
        const confirmField = event.target;
        const passwordField = this.form.querySelector('input[name="password"]');

        if (!passwordField.value || !confirmField.value) return;

        if (passwordField.value !== confirmField.value) {
            this.displayFieldError(confirmField, 'Las contraseñas no coinciden');
        } else {
            this.clearFieldError(confirmField);
        }
    }

    displayFieldError(field, errorMessage) {
        const formGroup = field.closest('.form-group');
        let errorElement = formGroup.querySelector('.form-error');

        if (errorMessage) {
            field.classList.add('error');
            if (!errorElement) {
                errorElement = document.createElement('span');
                errorElement.className = 'form-error';
                formGroup.appendChild(errorElement);
            }
            errorElement.textContent = errorMessage;
        } else {
            this.clearFieldError(field);
        }
    }

    clearFieldError(event) {
        const field = event.target;
        const formGroup = field.closest('.form-group');
        const errorElement = formGroup.querySelector('.form-error');

        field.classList.remove('error');
        if (errorElement) {
            errorElement.textContent = '';
        }
    }

    handleSubmit(event) {
        const isValid = this.validator.validateForm(this.form);

        // Validación adicional de campos personalizados
        const dniValid = this.validateDNIField();
        const phoneValid = this.validatePhoneField();
        const passwordMatch = this.validatePasswordMatchOnSubmit();

        if (!isValid || !dniValid || !phoneValid || !passwordMatch) {
            event.preventDefault();
            this.showFormErrors();
        }
    }

    validateDNIField() {
        const dniInput = this.form.querySelector('input[name="dni"]');
        if (!dniInput) return true;

        const value = dniInput.value.trim();
        if (!value) return true; // La validación required se encarga de esto

        const dniRegex = /^\d{8}$/;
        if (!dniRegex.test(value)) {
            this.displayFieldError(dniInput, 'El DNI debe tener 8 dígitos numéricos');
            return false;
        }

        return true;
    }

    validatePhoneField() {
        const phoneInput = this.form.querySelector('input[name="phone"]');
        if (!phoneInput) return true;

        const value = phoneInput.value.trim();
        if (!value) return true;

        const phoneRegex = /^\d{9}$/;
        if (!phoneRegex.test(value)) {
            this.displayFieldError(phoneInput, 'El teléfono debe tener 9 dígitos numéricos');
            return false;
        }

        return true;
    }

    validatePasswordMatchOnSubmit() {
        const passwordInput = this.form.querySelector('input[name="password"]');
        const confirmInput = this.form.querySelector('input[name="password_confirmation"]');

        if (!passwordInput || !confirmInput) return true;

        if (passwordInput.value !== confirmInput.value) {
            this.displayFieldError(confirmInput, 'Las contraseñas no coinciden');
            return false;
        }

        return true;
    }

    showFormErrors() {
        AuthAlert.showMessage('error', 'Por favor, corrige los errores en el formulario');
    }

    destroy() {
        // Cleanup si es necesario
    }
}

// Inicialización automática cuando el DOM está listo
document.addEventListener('DOMContentLoaded', function () {
    new RegisterForm();
});