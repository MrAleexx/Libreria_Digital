@extends('layouts.app')

@section('titulo', 'Pago con Plin')

@section('contenido')
    <section class="my-10 container mx-auto px-3">
        <!-- Header -->
        <div class="text-center mb-8">
            <h2 class="text-3xl font-bold text-[#04050E] mb-2">Pago con Plin</h2>
            <p class="text-[#272b30]/60">Realiza tu pago a través de Plin</p>
        </div>

        <div class="flex flex-col lg:flex-row gap-8">
            <!-- Resumen del carrito -->
            <div class="lg:w-1/2">
                <x-cart-summary :cart="$cart" :total="$total" />
            </div>

            <!-- Formulario de pago -->
            <div class="lg:w-1/2">
                <x-payment-form method="plin" methodName="Plin"
                    accountInfo='
                        <div class="space-y-2">
                            <div class="flex justify-between items-center">
                                <span>Número Plin:</span>
                                <strong class="text-lg">942784270</strong>
                            </div>
                            <div class="flex justify-between items-center">
                                <span>Titular:</span>
                                <strong>GRUPO A&T</strong>
                            </div>
                        </div>
                    '
                    :action="route('cart.process')" buttonText="Confirmar Pedido con Plin" />
            </div>
        </div>
    </section>
@endsection
