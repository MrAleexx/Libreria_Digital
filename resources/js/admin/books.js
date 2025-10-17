// resources/js/admin/books.js

// Manejo de pestañas en formularios
function initBookFormTabs() {
    return {
        activeTab: 'basic',

        switchTab(tabName) {
            this.activeTab = tabName;
            // Guardar la pestaña activa en sessionStorage
            sessionStorage.setItem('activeBookTab', tabName);
        },

        init() {
            // Restaurar pestaña activa si existe
            const savedTab = sessionStorage.getItem('activeBookTab');
            if (savedTab) {
                this.activeTab = savedTab;
            }
        }
    }
}

// Validación de ISBN
function validateISBN(isbn) {
    // Eliminar guiones y espacios
    isbn = isbn.replace(/[-\s]/g, '');

    // Validar formato básico
    if (!/^(?:\d{9}[\dX]|\d{13})$/.test(isbn)) {
        return false;
    }

    // Validar checksum para ISBN-10
    if (isbn.length === 10) {
        let sum = 0;
        for (let i = 0; i < 9; i++) {
            sum += parseInt(isbn[i]) * (10 - i);
        }
        let checksum = isbn[9].toUpperCase() === 'X' ? 10 : parseInt(isbn[9]);
        sum += checksum;
        return sum % 11 === 0;
    }

    // Validar checksum para ISBN-13
    if (isbn.length === 13) {
        let sum = 0;
        for (let i = 0; i < 12; i++) {
            sum += parseInt(isbn[i]) * (i % 2 === 0 ? 1 : 3);
        }
        let checksum = (10 - (sum % 10)) % 10;
        return checksum === parseInt(isbn[12]);
    }

    return false;
}

// Manejo de drag and drop para archivos
function initFileUpload() {
    const dropAreas = document.querySelectorAll('.file-upload-area');

    dropAreas.forEach(area => {
        const input = area.querySelector('input[type="file"]');

        ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
            area.addEventListener(eventName, preventDefaults, false);
        });

        function preventDefaults(e) {
            e.preventDefault();
            e.stopPropagation();
        }

        ['dragenter', 'dragover'].forEach(eventName => {
            area.addEventListener(eventName, highlight, false);
        });

        ['dragleave', 'drop'].forEach(eventName => {
            area.addEventListener(eventName, unhighlight, false);
        });

        function highlight() {
            area.classList.add('dragover');
        }

        function unhighlight() {
            area.classList.remove('dragover');
        }

        area.addEventListener('drop', handleDrop, false);

        function handleDrop(e) {
            const dt = e.dataTransfer;
            const files = dt.files;
            input.files = files;

            // Disparar evento change para actualizar la UI
            const event = new Event('change', { bubbles: true });
            input.dispatchEvent(event);
        }
    });
}

// Inicialización cuando el DOM está listo
document.addEventListener('DOMContentLoaded', function () {
    initFileUpload();

    // Validación de ISBN en tiempo real
    const isbnInput = document.getElementById('isbn');
    if (isbnInput) {
        isbnInput.addEventListener('blur', function () {
            if (this.value && !validateISBN(this.value)) {
                this.classList.add('border-red-300');
                // Mostrar mensaje de error
                showNotification('El ISBN no tiene un formato válido', 'error');
            } else {
                this.classList.remove('border-red-300');
            }
        });
    }
});

// Función de notificación (debes integrar con tu sistema de notificaciones)
function showNotification(message, type = 'info') {
    // Implementar según tu sistema de notificaciones
    console.log(`${type.toUpperCase()}: ${message}`);
}