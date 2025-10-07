<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::where('user_id', Auth::id())
            ->with('orderDetails.book', 'payment')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }

        $order->load('orderDetails.book', 'payment');

        // Verificar si el comprobante existe y obtener la URL correcta
        if ($order->payment && $order->payment->voucher_image) {
            // Verificar en ambas ubicaciones posibles
            $storagePath = storage_path('app/public/' . $order->payment->voucher_image);
            $publicPath = public_path('storage/' . $order->payment->voucher_image);

            if (file_exists($storagePath)) {
                // Si existe en storage, usar Storage::url()
                $order->payment->voucher_url = Storage::url($order->payment->voucher_image);
                $order->payment->voucher_exists = true;
            } elseif (file_exists($publicPath)) {
                // Si existe en public/storage, usar ruta directa
                $order->payment->voucher_url = asset('storage/' . $order->payment->voucher_image);
                $order->payment->voucher_exists = true;
            } else {
                $order->payment->voucher_exists = false;
            }
        }

        return view('orders.show', compact('order'));
    }

    public function repeat(Order $order)
    {
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }

        $cart = Session::get('cart', []);

        foreach ($order->orderDetails as $detail) {
            if (isset($cart[$detail->book_id])) {
                // No exceder el máximo de 5 unidades
                $newQuantity = min($cart[$detail->book_id]['quantity'] + $detail->quantity, 5);
                $cart[$detail->book_id]['quantity'] = $newQuantity;
            } else {
                $cart[$detail->book_id] = [
                    'id' => $detail->book_id,
                    'title' => $detail->book->title,
                    'author' => $detail->book->author,
                    'price' => $detail->book->price,
                    'image' => $detail->book->image,
                    'quantity' => min($detail->quantity, 5) // Máximo 5
                ];
            }
        }

        Session::put('cart', $cart);

        return redirect()->route('cart.index')->with('success', 'Productos añadidos al carrito');
    }
}
