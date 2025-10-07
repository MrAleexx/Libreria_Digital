// Módulo PDF Viewer
class PDFViewer {
    constructor() {
        this.SELECTORS = {
            pdfViewer: '#pdfViewer',
            fullscreenBtn: '#fullscreenBtn',
            zoomLevel: '#zoomLevel',
            pdfLoading: '#pdfLoading'
        };

        this.ZOOM_CONFIG = {
            MIN: 0.5,
            MAX: 2.0,
            STEP: 0.1,
            DEFAULT: 1.0
        };

        this.currentZoom = this.ZOOM_CONFIG.DEFAULT;
        this.lastTapTime = 0;
        this.isInitialized = false;
        this.iframe = null;
    }

    init() {
        if (this.isInitialized) return;

        this.iframe = document.querySelector(this.SELECTORS.pdfViewer);
        if (!this.iframe) return;

        this.setupEventListeners();
        this.setupPDFLoading(); // ✅ Correctamente colocado
        this.applyZoom();
        this.isInitialized = true;
    }

    setupEventListeners() {
        document.addEventListener('fullscreenchange', () => this.updateFullscreenButton());
        document.addEventListener('webkitfullscreenchange', () => this.updateFullscreenButton());
        document.addEventListener('msfullscreenchange', () => this.updateFullscreenButton());
        document.addEventListener('keydown', (e) => this.handleKeyPress(e));
        document.addEventListener('touchend', (e) => this.preventAccidentalZoom(e));
    }

    setupPDFLoading() {
        const loadingIndicator = document.querySelector(this.SELECTORS.pdfLoading);

        if (!this.iframe || !loadingIndicator) return;

        // Agregar transición CSS para fade suave
        loadingIndicator.style.transition = 'opacity 0.5s ease-in-out';

        // Ocultar loading cuando el iframe se carga
        this.iframe.addEventListener('load', () => {
            console.log('PDF loaded successfully with brand theme');

            // Efecto de fade out suave
            loadingIndicator.style.opacity = '0';
            setTimeout(() => {
                loadingIndicator.style.display = 'none';
            }, 500);
        });

        this.iframe.addEventListener('error', () => {
            console.error('Error loading PDF');
            this.showErrorState(loadingIndicator);
        });

        // Timeout de seguridad
        setTimeout(() => {
            if (loadingIndicator.style.display !== 'none' && loadingIndicator.style.opacity !== '0') {
                loadingIndicator.style.opacity = '0';
                setTimeout(() => {
                    loadingIndicator.style.display = 'none';
                }, 500);
            }
        }, 10000); // 10 segundos timeout
    }

    showErrorState(container) {
        container.innerHTML = `
            <div class="error-state text-center">
                <svg class="w-16 h-16 mx-auto mb-4 text-[#ea9216]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                          d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <p class="text-[#04050E] font-semibold text-lg mb-2">Error al cargar el PDF</p>
                <p class="text-[#272b30] mb-4">Por favor intenta nuevamente</p>
                <button onclick="location.reload()" class="bg-[#ea9216] hover:bg-[#d48314] text-white px-6 py-2 rounded-lg transition-colors">
                    Reintentar
                </button>
            </div>
        `;
    }

    // ... resto de los métodos se mantienen igual ...
    zoomIn() {
        this.currentZoom = Math.min(this.currentZoom + this.ZOOM_CONFIG.STEP, this.ZOOM_CONFIG.MAX);
        this.applyZoom();
    }

    zoomOut() {
        this.currentZoom = Math.max(this.currentZoom - this.ZOOM_CONFIG.STEP, this.ZOOM_CONFIG.MIN);
        this.applyZoom();
    }

    applyZoom() {
        if (this.iframe) {
            this.iframe.style.zoom = this.currentZoom;
        }

        const zoomLevel = document.querySelector(this.SELECTORS.zoomLevel);
        if (zoomLevel) {
            zoomLevel.textContent = `${Math.round(this.currentZoom * 100)}%`;
        }
    }

    toggleFullscreen() {
        const container = this.iframe?.parentElement?.parentElement;
        if (!container) return;

        if (!document.fullscreenElement) {
            this.enterFullscreen(container);
        } else {
            this.exitFullscreen();
        }
    }

    enterFullscreen(element) {
        const methods = ['requestFullscreen', 'webkitRequestFullscreen', 'msRequestFullscreen'];
        for (const method of methods) {
            if (element[method]) {
                element[method]();
                break;
            }
        }
    }

    exitFullscreen() {
        const methods = ['exitFullscreen', 'webkitExitFullscreen', 'msExitFullscreen'];
        for (const method of methods) {
            if (document[method]) {
                document[method]();
                break;
            }
        }
    }

    updateFullscreenButton() {
        const button = document.querySelector(this.SELECTORS.fullscreenBtn);
        if (!button) return;

        const isFullscreen = !!document.fullscreenElement;
        button.innerHTML = isFullscreen ?
            '<svg class="control-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>' :
            '<svg class="control-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5v-4m0 4h-4m4 0l-5-5"/></svg>';

        button.title = isFullscreen ? 'Salir de pantalla completa' : 'Pantalla completa';
    }

    handleKeyPress(event) {
        if (event.key === 'Escape' && document.fullscreenElement) {
            this.toggleFullscreen();
        }

        if (event.ctrlKey || event.metaKey) {
            switch (event.key) {
                case '=':
                    event.preventDefault();
                    this.zoomIn();
                    break;
                case '-':
                    event.preventDefault();
                    this.zoomOut();
                    break;
                case '0':
                    event.preventDefault();
                    this.currentZoom = this.ZOOM_CONFIG.DEFAULT;
                    this.applyZoom();
                    break;
            }
        }
    }

    preventAccidentalZoom(event) {
        const currentTime = new Date().getTime();
        const tapLength = currentTime - this.lastTapTime;

        if (tapLength < 300 && tapLength > 0) {
            event.preventDefault();
        }
        this.lastTapTime = currentTime;
    }
}

// Exportar para uso global
window.PDFViewer = PDFViewer;