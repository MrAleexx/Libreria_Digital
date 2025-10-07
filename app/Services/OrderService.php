<?php

namespace App\Services;

use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Payment;
use App\Models\Book;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderService
{
    public function createOrder(array $cart, string $paymentMethod, ?string $voucherPath = null): Order
    {
        return DB::transaction(function () use ($cart, $paymentMethod, $voucherPath) {
            // Determinar el estado inicial basado en el contenido del carrito
            $initialStatus = $this->determineInitialStatus($cart);
            $total = $this->calculateTotal($cart);

            // Crear la orden
            $order = Order::create([
                'user_id' => Auth::id(),
                'order_date' => now(),
                'status' => $initialStatus
            ]);

            // Crear detalles de la orden
            $this->createOrderDetails($order, $cart);

            // Crear pago solo si hay libros pagados
            if ($total > 0) {
                $this->createPayment($order, $total, $paymentMethod, $voucherPath);
            }

            return $order;
        });
    }

    private function determineInitialStatus(array $cart): string
    {
        $total = $this->calculateTotal($cart);

        // Si el total es 0 (solo libros gratuitos), marcar como pagado automáticamente
        return $total == 0 ? 'paid' : 'pending';
    }

    private function createOrderDetails(Order $order, array $cart): void
    {
        foreach ($cart as $item) {
            $book = Book::find($item['id']);
            $isFree = $book && $book->is_free;

            OrderDetail::create([
                'order_id' => $order->id,
                'book_id' => $item['id'],
                'quantity' => $item['quantity'],
                'subtotal' => $isFree ? 0 : $item['price'] * $item['quantity'],
            ]);
        }
    }

    private function createPayment(Order $order, float $total, string $paymentMethod, ?string $voucherPath): void
    {

        Payment::create([
            'order_id' => $order->id,
            'payment_method' => $paymentMethod,
            'amount' => $total,
            'payment_date' => now(),
            'voucher_image' => $voucherPath,
            'status' => 'pending'
        ]);
    }

    public function calculateTotal(array $cart): float
    {
        return array_reduce($cart, function ($total, $item) {
            // Solo sumar al total si no es gratuito
            if (!isset($item['is_free']) || !$item['is_free']) {
                return $total + ($item['price'] * $item['quantity']);
            }
            return $total;
        }, 0);
    }
}
