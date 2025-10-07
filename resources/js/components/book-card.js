export class BookCard {
    constructor() {
        this.cards = document.querySelectorAll('.book-card');
        this.init();
    }

    init() {
        this.cards.forEach(card => {
            this.addHoverEffects(card);
            this.addLoadingStates(card);
        });
    }

    addHoverEffects(card) {
        card.addEventListener('mouseenter', () => {
            card.classList.add('shadow-lg');
        });

        card.addEventListener('mouseleave', () => {
            card.classList.remove('shadow-lg');
        });
    }

    addLoadingStates(card) {
        const links = card.querySelectorAll('a');
        links.forEach(link => {
            link.addEventListener('click', (e) => {
                if (link.href.includes('books/show')) {
                    this.showLoadingState(link);
                }
            });
        });
    }

    showLoadingState(link) {
        const originalText = link.textContent;
        link.textContent = 'Cargando...';
        link.disabled = true;

        setTimeout(() => {
            link.textContent = originalText;
            link.disabled = false;
        }, 2000);
    }
}