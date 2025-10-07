<?php

namespace App\Http\Controllers;

use App\Http\Requests\CheckoutRequest;
use App\Services\CartService;
use App\Services\OrderService;
use App\Mail\PedidoConfirmado;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class CartController extends Controller
{
    public function __construct(
        private CartService $cartService,
        private OrderService $orderService
    ) {}

    // ✅ AGREGAR ESTE MÉTODO QUE FALTA
    public function index()
    {
        return view('cart.index', [
            'cart' => $this->cartService->getCart(),
            'total' => $this->cartService->getTotal()
        ]);
    }

    // ✅ AGREGAR ESTOS MÉTODOS QUE TAMBIÉN FALTAN
    public function update(Request $request, $id)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1|max:5'
        ]);

        $this->cartService->updateQuantity($id, $request->quantity);

        return redirect()->route('cart.index')->with('success', 'Cantidad actualizada');
    }

    public function remove($id)
    {
        if ($itemTitle = $this->cartService->removeItem($id)) {
            return redirect()->route('cart.index')->with('success', "{$itemTitle} eliminado del carrito");
        }

        return redirect()->route('cart.index')->with('error', 'Item no encontrado en el carrito');
    }

    public function add(Request $request, $book)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1|max:5'
        ]);

        $bookModel = \App\Models\Book::findOrFail($book);

        $this->cartService->addItem([
            'id' => $bookModel->id,
            'title' => $bookModel->title,
            'author' => $bookModel->author,
            'price' => $bookModel->price,
            'image' => $bookModel->image,
            'is_free' => $bookModel->is_free // ✅ AGREGAR ESTA LÍNEA
        ], $request->quantity);

        $message = $bookModel->is_free
            ? 'Libro gratuito añadido al carrito'
            : 'Libro añadido al carrito';

        return redirect()->back()->with('success', $message);
    }

    public function checkout()
    {
        if ($this->cartService->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Tu carrito está vacío');
        }

        // Si solo tiene libros gratuitos, procesar directamente
        if ($this->cartService->isCartFreeOnly()) {
            return $this->processFreeOrder();
        }

        return view('cart.checkout', [
            'cart' => $this->cartService->getCart(),
            'total' => $this->cartService->getTotal(),
            'hasFreeBooks' => $this->cartService->hasFreeBooks(),
            'freeBooks' => $this->cartService->getFreeBooks(),
            'paidBooks' => $this->cartService->getPaidBooks()
        ]);
    }

    private function processFreeOrder()
    {
        try {
            $cart = $this->cartService->getCart();

            // Crear orden gratuita
            $order = $this->orderService->createOrder($cart, 'free');

            // Enviar email de confirmación
            try {
                Mail::to(auth()->user()->email)
                    ->send(new PedidoConfirmado($cart, auth()->user(), null, 0));
            } catch (\Exception $emailException) {
                \Log::error('Error al enviar email para orden gratuita: ' . $emailException->getMessage());
            }

            $this->cartService->clearCart();

            return redirect()->route('orders.show', $order->id)
                ->with('success', '¡Libros gratuitos adquiridos exitosamente! Ya puedes acceder a ellos.');
        } catch (\Exception $e) {
            \Log::error('ERROR en processFreeOrder: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Error al procesar los libros gratuitos.');
        }
    }

    public function processCheckout(CheckoutRequest $request)
    {
        if ($this->cartService->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Tu carrito está vacío');
        }

        // Validar que si hay libros pagados, se suba voucher
        $hasPaidBooks = $this->cartService->hasPaidBooks();

        if ($hasPaidBooks && !$request->hasFile('voucher')) {
            return redirect()->back()->with('error', 'Para libros pagados, debes subir un comprobante.');
        }

        $cart = $this->cartService->getCart();
        $voucherPath = $hasPaidBooks ? $request->file('voucher')->store('vouchers', 'public') : null;

        $order = $this->orderService->createOrder(
            $cart,
            $request->payment_method,
            $voucherPath
        );

        $this->cartService->clearCart();

        $message = $hasPaidBooks
            ? '¡Pedido realizado con éxito! Espera la confirmación de tu pago.'
            : '¡Libros gratuitos adquiridos exitosamente! Ya puedes acceder a ellos.';

        return redirect()->route('orders.show', $order->id)->with('success', $message);
    }

    public function enviarCorreo(CheckoutRequest $request)
    {
        if ($this->cartService->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Tu carrito está vacío');
        }

        try {
            \Log::info('=== INICIANDO ENVIAR CORREO ===');

            $cart = $this->cartService->getCart();
            \Log::info('Carrito obtenido:', ['items_count' => count($cart)]);

            $voucherPath = $request->file('voucher')->store('vouchers', 'public');
            \Log::info('Voucher guardado:', ['path' => $voucherPath]);

            // Crear la orden
            $order = $this->orderService->createOrder($cart, 'email', $voucherPath);

            \Log::info('Orden creada:', [
                'order_id' => $order->id ?? 'NO_ID',
                'order_class' => get_class($order),
                'order_data' => $order->toArray()
            ]);

            if (!$order || !$order->id) {
                \Log::error('ERROR: La orden no tiene ID');
                return redirect()->route('cart.index')
                    ->with('error', 'Error al crear la orden. Por favor, contacta al soporte.');
            }

            // Calcular total para el email
            $total = $this->cartService->getTotal();

            // Intentar enviar email (pero no fallar si hay error)
            try {
                \Log::info('Enviando email...');
                Mail::to(auth()->user()->email)
                    ->send(new PedidoConfirmado($cart, auth()->user(), $voucherPath, $total));
                \Log::info('Email enviado exitosamente');
            } catch (\Exception $emailException) {
                \Log::error('Error al enviar email, pero continuando con el proceso: ' . $emailException->getMessage());
                // No re-lanzamos la excepción, continuamos con el proceso
            }

            $this->cartService->clearCart();
            \Log::info('Carrito limpiado, redirigiendo a orders.show');

            return redirect()->route('orders.show', $order->id)
                ->with('success', '¡Pedido realizado con éxito! ' .
                    (isset($emailException) ? 'El pedido se creó pero hubo un error al enviar el correo.' : 'Revisa tu correo para la confirmación.'));
        } catch (\Exception $e) {
            \Log::error('ERROR en enviarCorreo: ' . $e->getMessage());
            \Log::error('TRACE: ' . $e->getTraceAsString());

            return redirect()->back()
                ->with('error', 'Error al procesar el pedido: ' . $e->getMessage());
        }
    }

    // Métodos de visualización
    public function yape()
    {
        return $this->showPaymentView('yape');
    }

    public function plin()
    {
        return $this->showPaymentView('plin');
    }

    public function bank()
    {
        return $this->showPaymentView('bank');
    }

    public function correo()
    {
        return $this->showPaymentView('correo');
    }

    private function showPaymentView(string $method)
    {
        if ($this->cartService->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Tu carrito está vacío');
        }

        return view("cart.{$method}", [
            'cart' => $this->cartService->getCart(),
            'total' => $this->cartService->getTotal()
        ]);
    }
}
