@extends('layouts.app')

@section('titulo', 'Transferencia Bancaria')

@section('contenido')
    <section class="my-10 container mx-auto px-3">
        <!-- Header -->
        <div class="text-center mb-8">
            <h2 class="text-3xl font-bold text-[#04050E] mb-2">Transferencia Bancaria</h2>
            <p class="text-[#272b30]/60">Realiza tu transferencia a nuestra cuenta BCP</p>
        </div>

        <div class="flex flex-col lg:flex-row gap-8">
            <!-- Resumen del carrito -->
            <div class="lg:w-1/2">
                <x-cart-summary :cart="$cart" :total="$total" />
            </div>

            <!-- Formulario de pago -->
            <div class="lg:w-1/2">
                <x-payment-form method="bank_transfer" methodName="Transferencia Bancaria"
                    accountInfo='
                        <div class="space-y-2">
                            <div class="flex justify-between items-center">
                                <span>Banco:</span>
                                <strong>BCP</strong>
                            </div>
                            <div class="flex justify-between items-center">
                                <span>N° de Cuenta:</span>
                                <strong class="text-lg">25593579417098</strong>
                            </div>
                            <div class="flex justify-between items-center">
                                <span>CCI:</span>
                                <strong>00225519357941709881</strong>
                            </div>
                            <div class="flex justify-between items-center">
                                <span>Titular:</span>
                                <strong>GRUPO A&T</strong>
                            </div>
                        </div>
                    '
                    :action="route('cart.process')" buttonText="Confirmar Transferencia" />
            </div>
        </div>
    </section>
@endsection
