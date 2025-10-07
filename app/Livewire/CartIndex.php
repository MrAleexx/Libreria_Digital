<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\On;
use App\Services\CartService;

class CartIndex extends Component
{
    public $cart = [];
    public $total = 0;
    private CartService $cartService;

    public function boot(CartService $cartService): void
    {
        $this->cartService = $cartService;
    }

    public function mount(): void
    {
        $this->updateCartState();
    }

    public function increment(int $itemId): void
    {
        $cart = $this->cartService->getCart();

        if (isset($cart[$itemId]) && $cart[$itemId]['quantity'] < 5) {
            $this->cartService->updateQuantity($itemId, $cart[$itemId]['quantity'] + 1);
            $this->notifySuccess('Cantidad aumentada');
        }
    }

    public function decrement(int $itemId): void
    {
        $cart = $this->cartService->getCart();

        if (isset($cart[$itemId]) && $cart[$itemId]['quantity'] > 1) {
            $this->cartService->updateQuantity($itemId, $cart[$itemId]['quantity'] - 1);
            $this->notifySuccess('Cantidad disminuida');
        }
    }

    public function updateQuantity(int $itemId, int $quantity): void
    {
        $this->cartService->updateQuantity($itemId, $quantity);
        $this->notifySuccess('Cantidad actualizada');
    }

    public function removeItem(int $itemId): void
    {
        if ($itemTitle = $this->cartService->removeItem($itemId)) {
            $this->notifySuccess("{$itemTitle} eliminado del carrito");
        }
    }

    public function clearCart(): void
    {
        $this->cartService->clearCart();
        $this->notifySuccess('Carrito vaciado correctamente');
    }

    #[On('cart-updated')]
    public function refreshCart(): void
    {
        $this->updateCartState();
    }

    private function updateCartState(): void
    {
        $this->cart = $this->cartService->getCart();
        $this->total = $this->cartService->getTotal();
    }

    private function notifySuccess(string $message): void
    {
        $this->updateCartState();
        $this->dispatch('show-notification', type: 'success', message: $message);
    }

    public function render()
    {
        return view('livewire.cart-index');
    }
}
