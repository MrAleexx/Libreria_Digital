export class FormValidator {
    validateField(field) {
        const value = field.value.trim();
        const type = field.getAttribute('type');
        const name = field.getAttribute('name');

        if (!value) {
            return 'Este campo es obligatorio';
        }

        switch (type) {
            case 'email':
                return this.validateEmail(value);
            case 'password':
                return this.validatePassword(value);
            default:
                return null;
        }
    }

    validateEmail(email) {
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailRegex.test(email)) {
            return 'Por favor, introduce un email válido';
        }
        return null;
    }

    validatePassword(password) {
        if (password.length < 6) {
            return 'La contraseña debe tener al menos 6 caracteres';
        }
        return null;
    }

    validateForm(form) {
        const fields = form.querySelectorAll('input[required]');
        let isValid = true;

        fields.forEach(field => {
            const error = this.validateField(field);
            if (error) {
                isValid = false;
            }
        });

        return isValid;
    }
}