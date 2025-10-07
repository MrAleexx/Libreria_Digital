<?php

namespace App\Services;

use App\Models\Book;
use Illuminate\Support\Facades\Session;

class CartService
{
    private const MAX_QUANTITY = 5;
    private const MIN_QUANTITY = 1;

    public function getCart(): array
    {
        return Session::get('cart', []);
    }

    public function addItem(array $book, int $quantity): void
    {
        $cart = $this->getCart();
        $bookId = $book['id'];

        // Verificar si el libro es gratuito
        $bookModel = Book::find($bookId);
        $isFree = $bookModel && $bookModel->is_free;

        if ($isFree) {
            // Para libros gratuitos, solo permitir 1 unidad
            $quantity = 1;

            // Eliminar otros libros gratuitos del carrito (solo 1 gratis a la vez)
            $cart = $this->removeOtherFreeBooks($cart, $bookId);
        }

        if (isset($cart[$bookId])) {
            $cart[$bookId]['quantity'] = min(
                $cart[$bookId]['quantity'] + $quantity,
                self::MAX_QUANTITY
            );
        } else {
            $cart[$bookId] = [
                'id' => $book['id'],
                'title' => $book['title'],
                'author' => $book['author'],
                'price' => $book['price'],
                'image' => $book['image'],
                'quantity' => min($quantity, self::MAX_QUANTITY),
                'is_free' => $isFree
            ];
        }

        Session::put('cart', $cart);
    }

    public function updateQuantity(int $itemId, int $quantity): void
    {
        $cart = $this->getCart();

        if (isset($cart[$itemId])) {
            $cart[$itemId]['quantity'] = max(
                self::MIN_QUANTITY,
                min($quantity, self::MAX_QUANTITY)
            );
            Session::put('cart', $cart);
        }
    }

    public function removeItem(int $itemId): ?string
    {
        $cart = $this->getCart();

        if (isset($cart[$itemId])) {
            $itemTitle = $cart[$itemId]['title'];
            unset($cart[$itemId]);
            Session::put('cart', $cart);
            return $itemTitle;
        }

        return null;
    }

    public function clearCart(): void
    {
        Session::forget('cart');
    }

    public function getTotal(): float
    {
        return array_reduce($this->getCart(), function ($total, $item) {
            // Solo sumar al total si no es gratuito
            if (!isset($item['is_free']) || !$item['is_free']) {
                return $total + ($item['price'] * $item['quantity']);
            }
            return $total;
        }, 0);
    }

    public function isEmpty(): bool
    {
        return empty($this->getCart());
    }

    // Métodos para libros gratuitos
    public function hasFreeBooks(): bool
    {
        $cart = $this->getCart();

        foreach ($cart as $item) {
            if (isset($item['is_free']) && $item['is_free']) {
                return true;
            }
        }

        return false;
    }

    public function hasPaidBooks(): bool
    {
        $cart = $this->getCart();

        foreach ($cart as $item) {
            if (!isset($item['is_free']) || !$item['is_free']) {
                return true;
            }
        }

        return false;
    }

    public function getFreeBooks(): array
    {
        $cart = $this->getCart();
        $freeBooks = [];

        foreach ($cart as $item) {
            if (isset($item['is_free']) && $item['is_free']) {
                $freeBooks[] = $item;
            }
        }

        return $freeBooks;
    }

    public function getPaidBooks(): array
    {
        $cart = $this->getCart();
        $paidBooks = [];

        foreach ($cart as $item) {
            if (!isset($item['is_free']) || !$item['is_free']) {
                $paidBooks[] = $item;
            }
        }

        return $paidBooks;
    }

    public function isCartFreeOnly(): bool
    {
        return $this->hasFreeBooks() && !$this->hasPaidBooks();
    }

    private function removeOtherFreeBooks(array $cart, int $currentBookId): array
    {
        foreach ($cart as $bookId => $item) {
            if (isset($item['is_free']) && $item['is_free'] && $bookId != $currentBookId) {
                unset($cart[$bookId]);
            }
        }
        return $cart;
    }
}
