// resources/js/components/book-form/InitialContentsManager.js

export class InitialContentsManager {
    constructor(containerId, initialCount = 3) {
        this.container = document.getElementById(containerId);
        this.index = initialCount;
        console.log(`📑 InitialContentsManager creado para ${containerId}, índice: ${this.index}`);
        this.init();
    }

    init() {
        console.log('🔧 Inicializando InitialContentsManager...');

        // Event delegation para botones de eliminar
        this.container.addEventListener('click', (e) => {
            if (e.target.classList.contains('remove-content-btn')) {
                console.log('🗑️ Click en eliminar contenido');
                this.removeContent(e.target);
            }
        });

        // Botón agregar
        const addButton = document.querySelector('.add-content-btn');
        if (addButton) {
            addButton.addEventListener('click', () => {
                console.log('➕ Click en agregar contenido');
                this.addContent();
            });
            console.log('✅ Event listener agregado a botón contenido');
        } else {
            console.error('❌ Botón add-content-btn no encontrado');
            console.log('🔍 Buscando en:', document.querySelectorAll('button'));
        }
    }

    addContent() {
        console.log(`➕ Agregando contenido #${this.index}`);
        const newContent = this.createContentHTML();
        this.container.insertAdjacentHTML('beforeend', newContent);
        this.index++;
        console.log(`✅ Contenido agregado, nuevo índice: ${this.index}`);
    }

    removeContent(button) {
        const contentItem = button.closest('.initial-content-item');
        if (contentItem) {
            contentItem.remove();
            console.log('✅ Contenido eliminado');
        }
    }

    createContentHTML() {
        return `
            <div class="initial-content-item border border-gray-300 p-3 rounded-md">
                <div class="grid grid-cols-1 md:grid-cols-12 gap-3">
                    <div class="md:col-span-5">
                        <label class="block text-sm font-medium text-gray-700 mb-1 flex items-center">
                            <i class="fas fa-heading text-gray-400 mr-1 text-xs"></i>
                            Título
                        </label>
                        <input type="text" 
                               name="initial_contents[${this.index}][chapter_title]" 
                               placeholder="Ej: Capítulo 1"
                               class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-500">
                    </div>
                    <div class="md:col-span-3">
                        <label class="block text-sm font-medium text-gray-700 mb-1 flex items-center">
                            <i class="fas fa-layer-group text-gray-400 mr-1 text-xs"></i>
                            Nivel
                        </label>
                        <select name="initial_contents[${this.index}][level]" 
                                class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-500">
                            <option value="0">Principal</option>
                            <option value="1">Nivel 1</option>
                            <option value="2">Nivel 2</option>
                        </select>
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1 flex items-center">
                            <i class="fas fa-sort-numeric-down text-gray-400 mr-1 text-xs"></i>
                            Orden
                        </label>
                        <input type="number" 
                               name="initial_contents[${this.index}][sort_order]" 
                               value="${this.index + 1}"
                               min="1"
                               class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-500">
                    </div>
                    <div class="md:col-span-2 flex items-end">
                        <button type="button" 
                                class="remove-content-btn bg-red-500 text-white px-3 py-2 rounded-md hover:bg-red-600 transition-colors text-sm flex items-center">
                            <i class="fas fa-trash mr-1"></i>
                            Eliminar
                        </button>
                    </div>
                </div>
            </div>
        `;
    }
}