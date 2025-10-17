// resources/js/app.js
import './bootstrap';
import './components/pdf-viewer';
import { SuccessMessage } from './components/success-message';
import { BookCard } from './components/book-card';
import './components/auth/ViewPassword';
import { ContributorsManager } from './components/book-form/ContributorsManager';
import { InitialContentsManager } from './components/book-form/InitialContentsManager';
import './layouts/book-information';
import './admin/categories-form';
import './admin/books';
import Chart from 'chart.js/auto';

console.log('🚀 App.js iniciado - Módulos cargados');

// Inicialización global
document.addEventListener('DOMContentLoaded', function () {

    // Auto-inicializar PDF Viewer si existe en la página
    if (document.getElementById('pdfViewer')) {
        const pdfViewer = new window.PDFViewer();
        pdfViewer.init();
        window.pdfViewerInstance = pdfViewer;
    }

    // Inicializar componentes del formulario de libros
    initializeBookFormComponents();
});

function initializeBookFormComponents() {
    // Contributors Manager
    const contributorsContainer = document.getElementById('contributors-container');
    if (contributorsContainer && window.ContributorsManager) {
        const initialCount = parseInt(contributorsContainer.dataset.initialCount) || 1;
        new ContributorsManager('contributors-container', initialCount);
    }

    // Initial Contents Manager
    const contentsContainer = document.getElementById('initial-contents-container');
    if (contentsContainer && window.InitialContentsManager) {
        const initialCount = parseInt(contentsContainer.dataset.initialCount) || 3;
        new InitialContentsManager('initial-contents-container', initialCount);
    }
}

// Hacer disponibles globalmente
window.SuccessMessage = SuccessMessage;
window.BookCard = BookCard;
window.ContributorsManager = ContributorsManager;
window.InitialContentsManager = InitialContentsManager;
window.Chart = Chart;