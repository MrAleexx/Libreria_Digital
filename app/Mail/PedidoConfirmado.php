<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PedidoConfirmado extends Mailable
{
    use Queueable, SerializesModels;

    public $cart;
    public $user;
    public $voucherPath;
    public $total;

    public function __construct($cart, $user, $voucherPath, $total)
    {
        $this->cart = $cart;
        $this->user = $user;
        $this->voucherPath = $voucherPath;
        $this->total = $total;
    }

    public function build()
    {
        return $this->subject('Confirmación de Pedido - ' . config('app.name'))
            ->view('emails.pedido-confirmado');
    }
}
