// resources/js/admin/categories-form.js
function initializeCategoryForm() {
    const nameInput = document.getElementById('name');
    const slugInput = document.getElementById('slug');
    const isActiveCheckbox = document.getElementById('is_active');
    const statusIndicator = document.getElementById('status-indicator');
    const parentSelect = document.getElementById('parent_id');
    const metaTitle = document.getElementById('meta_title');
    const metaDescription = document.getElementById('meta_description');

    // Auto-generar slug desde el nombre
    if (nameInput && slugInput) {
        nameInput.addEventListener('blur', function () {
            // Solo generar slug si está vacío y el nombre tiene valor
            if (!slugInput.value.trim() && nameInput.value.trim()) {
                generateSlug(nameInput.value, slugInput);
            }
        });

        // También generar slug al escribir si el campo slug está vacío
        nameInput.addEventListener('input', function () {
            if (!slugInput.value.trim() && nameInput.value.trim()) {
                // Usar debounce para no generar en cada tecla
                clearTimeout(nameInput.slugTimeout);
                nameInput.slugTimeout = setTimeout(() => {
                    generateSlug(nameInput.value, slugInput);
                }, 500);
            }
        });
    }

    // Actualizar indicador visual del estado
    if (isActiveCheckbox && statusIndicator) {
        function updateStatusIndicator() {
            const isActive = isActiveCheckbox.checked;

            // Actualizar indicador visual
            if (isActive) {
                statusIndicator.classList.remove('bg-gray-400', 'bg-red-400');
                statusIndicator.classList.add('bg-green-500');
            } else {
                statusIndicator.classList.remove('bg-green-500', 'bg-red-400');
                statusIndicator.classList.add('bg-gray-400');
            }

            // Actualizar texto si existe
            const statusText = document.getElementById('status-text');
            if (statusText) {
                statusText.textContent = isActive ? 'Activa' : 'Inactiva';
                statusText.className = `text-sm font-medium ${isActive ? 'text-green-600' : 'text-gray-500'}`;
            }
        }

        isActiveCheckbox.addEventListener('change', updateStatusIndicator);
        updateStatusIndicator(); // Estado inicial

        // También actualizar al cargar la página por si hay valores por defecto
        document.addEventListener('DOMContentLoaded', updateStatusIndicator);
    }

    // Validación para evitar seleccionarse a sí mismo como padre
    if (parentSelect) {
        parentSelect.addEventListener('change', function () {
            const selectedOption = this.options[this.selectedIndex];
            if (selectedOption.disabled) {
                this.value = '';
                showAlert('No puedes seleccionar la categoría actual como padre.', 'warning');
            }
        });

        // Prevenir envío del formulario si se selecciona una opción inválida
        const form = parentSelect.closest('form');
        if (form) {
            form.addEventListener('submit', function (e) {
                const selectedOption = parentSelect.options[parentSelect.selectedIndex];
                if (selectedOption.disabled) {
                    e.preventDefault();
                    showAlert('Por favor, selecciona una categoría padre válida.', 'error');
                    parentSelect.focus();
                }
            });
        }
    }

    // Efectos de focus mejorados con transiciones suaves
    const inputs = document.querySelectorAll('input, textarea, select');
    inputs.forEach(input => {
        input.addEventListener('focus', function () {
            this.classList.add('ring-2', 'ring-blue-500/20', 'border-blue-500', 'shadow-md');
            this.classList.remove('border-gray-200');
        });

        input.addEventListener('blur', function () {
            this.classList.remove('ring-2', 'ring-blue-500/20', 'shadow-md');
            this.classList.add('border-gray-200');

            // Validación básica en blur
            validateField(this);
        });

        // Efecto hover suave
        input.addEventListener('mouseenter', function () {
            if (document.activeElement !== this) {
                this.classList.add('border-gray-300', 'shadow-sm');
            }
        });

        input.addEventListener('mouseleave', function () {
            if (document.activeElement !== this) {
                this.classList.remove('border-gray-300', 'shadow-sm');
                this.classList.add('border-gray-200');
            }
        });
    });

    // Contador de caracteres para SEO con recomendaciones
    if (metaTitle) {
        setupCharacterCounter(metaTitle, 'meta-title-count', {
            ideal: { min: 50, max: 60 },
            warning: 70,
            danger: 80
        });
    }

    if (metaDescription) {
        setupCharacterCounter(metaDescription, 'meta-description-count', {
            ideal: { min: 120, max: 160 },
            warning: 180,
            danger: 200
        });
    }

    // Validación en tiempo real para campos requeridos
    if (nameInput) {
        nameInput.addEventListener('input', function () {
            validateRequiredField(this, 'El nombre de la categoría es obligatorio');
        });
    }

    // Prevenir envío del formulario si hay errores
    const form = document.querySelector('form');
    if (form) {
        form.addEventListener('submit', function (e) {
            if (!validateForm()) {
                e.preventDefault();
                showAlert('Por favor, corrige los errores en el formulario antes de enviar.', 'error');
            }
        });
    }
}

// Función para generar slug
function generateSlug(text, slugInput) {
    const slug = text
        .toLowerCase()
        .trim()
        .normalize('NFD') // Separar acentos
        .replace(/[\u0300-\u036f]/g, '') // Eliminar acentos
        .replace(/[^a-z0-9 -]/g, '') // Eliminar caracteres especiales
        .replace(/\s+/g, '-') // Reemplazar espacios con guiones
        .replace(/-+/g, '-') // Eliminar guiones múltiples
        .replace(/^-+/, '') // Eliminar guiones al inicio
        .replace(/-+$/, ''); // Eliminar guiones al final

    slugInput.value = slug;
}

// Función para configurar contador de caracteres
function setupCharacterCounter(element, countId, limits) {
    function updateCounter() {
        let countElement = document.getElementById(countId);
        if (!countElement) {
            countElement = document.createElement('div');
            countElement.id = countId;
            countElement.className = 'text-xs mt-1 text-right transition-colors duration-200';
            element.parentNode.appendChild(countElement);
        }

        const length = element.value.length;
        countElement.textContent = `${length} caracteres`;

        // Aplicar colores según límites
        if (length === 0) {
            countElement.className = 'text-xs mt-1 text-right text-gray-400';
        } else if (length > limits.danger) {
            countElement.className = 'text-xs mt-1 text-right text-red-600 font-medium';
        } else if (length > limits.warning) {
            countElement.className = 'text-xs mt-1 text-right text-orange-500';
        } else if (length >= limits.ideal.min && length <= limits.ideal.max) {
            countElement.className = 'text-xs mt-1 text-right text-green-600 font-medium';
        } else if (length < limits.ideal.min) {
            countElement.className = 'text-xs mt-1 text-right text-blue-500';
        } else {
            countElement.className = 'text-xs mt-1 text-right text-gray-600';
        }

        // Agregar tooltip con recomendaciones
        if (!countElement.hasAttribute('title')) {
            countElement.setAttribute('title',
                `Recomendado: ${limits.ideal.min}-${limits.ideal.max} caracteres\n` +
                `Máximo: ${limits.danger} caracteres`
            );
        }
    }

    element.addEventListener('input', updateCounter);
    element.addEventListener('focus', updateCounter);
    updateCounter(); // Estado inicial
}

// Función para validar campos requeridos
function validateRequiredField(field, message) {
    const isValid = field.value.trim().length > 0;

    if (!isValid) {
        showFieldError(field, message);
    } else {
        clearFieldError(field);
    }

    return isValid;
}

// Función para validar campo genérico
function validateField(field) {
    if (field.hasAttribute('required') && !field.value.trim()) {
        showFieldError(field, 'Este campo es obligatorio');
        return false;
    }

    clearFieldError(field);
    return true;
}

// Función para mostrar error en campo
function showFieldError(field, message) {
    // Remover error anterior
    clearFieldError(field);

    // Aplicar estilos de error
    field.classList.add('border-red-300', 'ring-2', 'ring-red-500/20');
    field.classList.remove('border-gray-200', 'border-blue-500', 'ring-blue-500/20');

    // Crear elemento de error
    const errorElement = document.createElement('p');
    errorElement.className = 'text-red-600 text-sm mt-2 flex items-center animate-fade-in';
    errorElement.innerHTML = `<i class="fas fa-exclamation-circle mr-1.5"></i>${message}`;

    field.parentNode.appendChild(errorElement);
    field.errorElement = errorElement;
}

// Función para limpiar error de campo
function clearFieldError(field) {
    if (field.errorElement) {
        field.errorElement.remove();
        field.errorElement = null;
    }

    field.classList.remove('border-red-300', 'ring-2', 'ring-red-500/20');
    field.classList.add('border-gray-200');
}

// Función para validar formulario completo
function validateForm() {
    const requiredFields = document.querySelectorAll('input[required], textarea[required], select[required]');
    let isValid = true;

    requiredFields.forEach(field => {
        if (!validateField(field)) {
            isValid = false;

            // Scroll al primer campo con error
            if (isValid === false) {
                field.scrollIntoView({ behavior: 'smooth', block: 'center' });
                field.focus();
            }
        }
    });

    return isValid;
}

// Función para mostrar alertas (podrías integrar con SweetAlert o similar)
function showAlert(message, type = 'info') {
    const alertTypes = {
        success: { icon: '✅', color: 'green' },
        error: { icon: '❌', color: 'red' },
        warning: { icon: '⚠️', color: 'orange' },
        info: { icon: 'ℹ️', color: 'blue' }
    };

    const alertConfig = alertTypes[type] || alertTypes.info;

    alert(`${alertConfig.icon} ${message}`);
}

// Inicializar cuando el DOM esté listo
document.addEventListener('DOMContentLoaded', function () {
    initializeCategoryForm();
});

// Hacer funciones disponibles globalmente si es necesario
window.initializeCategoryForm = initializeCategoryForm;
window.validateCategoryForm = validateForm;