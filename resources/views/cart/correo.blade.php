@extends('layouts.app')

@section('titulo', 'Confirmar Pedido por Correo')

@section('contenido')
    <section class="my-10 container mx-auto px-3">
        <div class="text-center mb-8">
            <h2 class="text-3xl font-bold text-[#04050E] mb-2">Confirmar Pedido por Correo</h2>
            <p class="text-[#272b30]/60">Recibirás la confirmación de tu pedido por correo electrónico</p>
        </div>

        <div class="flex flex-col lg:flex-row gap-8">
            <div class="lg:w-1/2">
                <x-cart-summary :cart="$cart" :total="$total" />
            </div>

            <div class="lg:w-1/2">
                <x-payment-form method="email" methodName="Correo" :action="route('cart.enviarCorreo')" buttonText="Enviar Pedido por Correo"
                    :showUserInfo="true" />
            </div>
        </div>
    </section>
@endsection
