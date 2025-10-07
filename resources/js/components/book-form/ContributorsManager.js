// resources/js/components/book-form/ContributorsManager.js

export class ContributorsManager {
    constructor(containerId, initialCount = 1) {
        this.container = document.getElementById(containerId);
        this.index = initialCount;
        this.init();
    }

    init() {
        // Event delegation para botones de eliminar
        this.container.addEventListener('click', (e) => {
            if (e.target.classList.contains('remove-contributor-btn')) {
                console.log('🗑️ Click en eliminar contribuidor');
                this.removeContributor(e.target);
            }
        });

        // Botón agregar
        const addButton = document.querySelector('.add-contributor-btn');
        if (addButton) {
            addButton.addEventListener('click', () => {
                this.addContributor();
            });
        } else {
            console.error('❌ Botón add-contributor-btn no encontrado');
        }
    }

    addContributor() {
        const newContributor = this.createContributorHTML();
        this.container.insertAdjacentHTML('beforeend', newContributor);
        this.index++;
    }

    removeContributor(button) {
        const contributorItem = button.closest('.contributor-item');
        if (contributorItem) {
            contributorItem.remove();
            console.log('✅ Contribuidor eliminado');
        }
    }

    createContributorHTML() {
        return `
            <div class="contributor-item border border-gray-300 p-4 rounded-md">
                <div class="grid grid-cols-1 md:grid-cols-12 gap-4">
                    <div class="md:col-span-3">
                        <label class="block text-sm font-medium text-gray-700 mb-1 flex items-center">
                            <i class="fas fa-tag text-gray-400 mr-1 text-xs"></i>
                            Tipo
                        </label>
                        <select name="contributors[${this.index}][contributor_type]" 
                                class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="author">Autor</option>
                            <option value="editor">Editor</option>
                            <option value="translator">Traductor</option>
                            <option value="illustrator">Ilustrador</option>
                        </select>
                    </div>
                    <div class="md:col-span-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1 flex items-center">
                            <i class="fas fa-user text-gray-400 mr-1 text-xs"></i>
                            Nombre Completo *
                        </label>
                        <input type="text" 
                               name="contributors[${this.index}][full_name]" 
                               placeholder="Ej: Alex Taya Yactayo"
                               class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                               required>
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1 flex items-center">
                            <i class="fas fa-sort-numeric-down text-gray-400 mr-1 text-xs"></i>
                            Orden
                        </label>
                        <input type="number" 
                               name="contributors[${this.index}][sequence_number]" 
                               value="${this.index + 1}"
                               min="1"
                               class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div class="md:col-span-3 flex items-end">
                        <button type="button" 
                                class="remove-contributor-btn bg-red-500 text-white px-3 py-2 rounded-md hover:bg-red-600 transition-colors flex items-center">
                            <i class="fas fa-trash mr-1"></i>
                            Eliminar
                        </button>
                    </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-3">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1 flex items-center">
                            <i class="fas fa-envelope text-gray-400 mr-1 text-xs"></i>
                            Email
                        </label>
                        <input type="email" 
                               name="contributors[${this.index}][email]" 
                               placeholder="email@ejemplo.com"
                               class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1 flex items-center">
                            <i class="fas fa-info-circle text-gray-400 mr-1 text-xs"></i>
                            Nota Biográfica
                        </label>
                        <textarea name="contributors[${this.index}][biographical_note]" 
                                  rows="2"
                                  placeholder="Breve biografía o información relevante"
                                  class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
                    </div>
                </div>
            </div>
        `;
    }
}