{{-- resources/views/orders/show.blade.php --}}
@extends('layouts.app')

@section('titulo', 'Detalle del Pedido #' . $order->id)

@section('contenido')
    <section class="container mx-auto px-4 sm:px-6 py-6 md:py-8 lg:py-10">
        <!-- Header mejorado con gradientes corporativos -->
        <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-4 mb-6 md:mb-8">
            <div class="flex items-center gap-3 md:gap-4">
                <div
                    class="w-12 h-12 bg-gradient-to-r from-[#ea9216] to-[#d88310] rounded-xl flex items-center justify-center shadow-lg">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                </div>
                <div>
                    <h1 class="text-2xl sm:text-3xl font-bold text-[#04050E] leading-tight">Pedido #{{ $order->id }}</h1>
                    <p class="text-[#272b30]/80 text-sm sm:text-base mt-1">Detalles completos de tu compra</p>
                </div>
            </div>
            <a href="{{ route('orders.index') }}"
                class="bg-white text-[#052f5a] border border-[#052f5a] hover:bg-[#052f5a] hover:text-white px-4 py-3 rounded-lg font-medium transition-all duration-300 flex items-center gap-2 shadow-sm hover:shadow-md w-full lg:w-auto justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Volver a mis pedidos
            </a>
        </div>

        <!-- Grid principal -->
        <div class="grid grid-cols-1 xl:grid-cols-3 gap-6 lg:gap-8">
            <!-- Columna izquierda - Información principal -->
            <div class="xl:col-span-2 space-y-6 lg:space-y-8">
                <!-- Tarjeta de información del pedido -->
                <div
                    class="bg-white rounded-2xl shadow-sm border border-[#272b30]/10 p-5 sm:p-6 hover:shadow-md transition-shadow duration-300">
                    <div class="flex items-center gap-3 mb-4 sm:mb-6">
                        <div class="bg-[#052f5a]/10 p-2 rounded-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-[#052f5a]" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <h2 class="text-xl sm:text-2xl font-bold text-[#04050E]">Información del Pedido</h2>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        @php
                            $statusConfig = [
                                'paid' => [
                                    'color' => 'bg-green-100 text-green-800',
                                    'icon' => 'M5 13l4 4L19 7',
                                    'text' => 'Pagado',
                                ],
                                'pending' => [
                                    'color' => 'bg-yellow-100 text-yellow-800',
                                    'icon' => 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z',
                                    'text' => 'Pendiente',
                                ],
                                'cancelled' => [
                                    'color' => 'bg-red-100 text-red-800',
                                    'icon' => 'M6 18L18 6M6 6l12 12',
                                    'text' => 'Cancelado',
                                ],
                            ];
                            $currentStatus = $statusConfig[$order->status] ?? $statusConfig['pending'];
                        @endphp

                        <div class="bg-gradient-to-br from-[#272b30]/5 to-white rounded-xl p-4 border border-[#272b30]/10">
                            <div class="text-[#272b30]/60 text-sm font-medium mb-1">Fecha y Hora</div>
                            <div class="text-[#04050E] font-semibold">{{ $order->created_at->format('d/m/Y') }}</div>
                            <div class="text-[#272b30]/80 text-sm">{{ $order->created_at->format('h:i A') }}</div>
                        </div>

                        <div class="bg-gradient-to-br from-[#272b30]/5 to-white rounded-xl p-4 border border-[#272b30]/10">
                            <div class="text-[#272b30]/60 text-sm font-medium mb-1">Estado del Pedido</div>
                            <span
                                class="inline-flex items-center px-3 py-1 rounded-full text-sm font-bold {{ $currentStatus['color'] }}">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 mr-1.5" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="{{ $currentStatus['icon'] }}" />
                                </svg>
                                {{ $currentStatus['text'] }}
                            </span>
                        </div>

                        <div class="bg-gradient-to-br from-[#272b30]/5 to-white rounded-xl p-4 border border-[#272b30]/10">
                            <div class="text-[#272b30]/60 text-sm font-medium mb-1">Método de Pago</div>
                            <div class="text-[#04050E] font-semibold capitalize">
                                {{ $order->payment->payment_method ?? ($order->status === 'paid' ? 'Gratuito' : 'Email') }}
                            </div>
                        </div>

                        <div class="bg-gradient-to-br from-[#272b30]/5 to-white rounded-xl p-4 border border-[#272b30]/10">
                            <div class="text-[#272b30]/60 text-sm font-medium mb-1">Estado de Pago</div>
                            @php
                                $paymentStatus =
                                    $order->payment->status ?? ($order->status === 'paid' ? 'confirmed' : 'pending');
                                $paymentConfig = [
                                    'confirmed' => ['color' => 'bg-green-100 text-green-800', 'text' => 'Confirmado'],
                                    'pending' => ['color' => 'bg-yellow-100 text-yellow-800', 'text' => 'Pendiente'],
                                    'rejected' => ['color' => 'bg-red-100 text-red-800', 'text' => 'Rechazado'],
                                ];
                                $currentPayment = $paymentConfig[$paymentStatus] ?? $paymentConfig['pending'];
                            @endphp
                            <span
                                class="inline-flex items-center px-3 py-1 rounded-full text-sm font-bold {{ $currentPayment['color'] }}">
                                {{ $currentPayment['text'] }}
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Tarjeta de productos -->
                <div
                    class="bg-white rounded-2xl shadow-sm border border-[#272b30]/10 p-5 sm:p-6 hover:shadow-md transition-shadow duration-300">
                    <div class="flex items-center gap-3 mb-4 sm:mb-6">
                        <div class="bg-[#ea9216]/10 p-2 rounded-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-[#ea9216]" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                            </svg>
                        </div>
                        <h2 class="text-xl sm:text-2xl font-bold text-[#04050E]">Productos del Pedido</h2>
                    </div>

                    <div class="space-y-4">
                        @php
                            $hasFreeBooks = false;
                        @endphp
                        @foreach ($order->orderDetails as $detail)
                            @php
                                if ($detail->subtotal == 0) {
                                    $hasFreeBooks = true;
                                }
                            @endphp
                            <div
                                class="flex flex-col sm:flex-row items-start sm:items-center justify-between p-4 rounded-xl border border-[#272b30]/10 hover:bg-[#272b30]/3 transition-all duration-300 gap-4 sm:gap-6">
                                <div class="flex items-center gap-4 flex-1 min-w-0">
                                    <x-book-image :image="$detail->book->image ?? ''" :title="$detail->book->title ?? 'Libro'"
                                        class="w-16 h-20 sm:w-20 sm:h-24 object-cover rounded-lg shadow-sm flex-shrink-0" />
                                    <div class="min-w-0 flex-1">
                                        <div class="flex items-center gap-2">
                                            <h3 class="font-semibold text-[#04050E] text-base truncate">
                                                {{ $detail->book->title ?? 'Libro' }}</h3>
                                            @if ($detail->subtotal == 0)
                                                <span
                                                    class="bg-green-100 text-green-800 text-xs font-semibold px-2 py-0.5 rounded-full">
                                                    GRATUITO
                                                </span>
                                            @endif
                                        </div>
                                        <p class="text-[#272b30]/60 text-sm mt-1">Cantidad: {{ $detail->quantity }}</p>
                                        @if ($detail->subtotal == 0)
                                            <p class="text-green-600 font-bold text-base mt-2">GRATIS</p>
                                        @else
                                            <p class="text-[#ea9216] font-bold text-base mt-2">S/
                                                {{ number_format($detail->subtotal, 2) }}</p>
                                        @endif
                                    </div>
                                </div>
                                <div class="text-right sm:text-left">
                                    @if ($detail->subtotal == 0)
                                        <span class="text-green-600 text-sm block font-medium">GRATIS</span>
                                    @else
                                        <span class="text-[#272b30]/60 text-sm block">S/
                                            {{ number_format($detail->book->price ?? $detail->subtotal / $detail->quantity, 2) }}
                                            c/u</span>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Total -->
                    <div class="mt-6 pt-6 border-t border-[#272b30]/10">
                        <div class="flex justify-between items-center">
                            <span class="text-lg sm:text-xl font-bold text-[#04050E]">Total del Pedido:</span>
                            @if ($hasFreeBooks && $order->orderDetails->sum('subtotal') == 0)
                                <span class="text-2xl sm:text-3xl font-bold text-green-600">GRATIS</span>
                            @else
                                <span class="text-2xl sm:text-3xl font-bold text-[#ea9216]">S/
                                    {{ number_format($order->orderDetails->sum('subtotal'), 2) }}</span>
                            @endif
                        </div>
                        @if ($hasFreeBooks)
                            <p class="text-green-600 text-sm mt-2 text-center">
                                ✅ Incluye libros gratuitos - Acceso inmediato
                            </p>
                        @endif
                    </div>
                </div>

                <!-- PROGRESO DEL PEDIDO - AHORA EN LA COLUMNA IZQUIERDA -->
                <div class="bg-white rounded-2xl shadow-sm border border-[#272b30]/10 p-5 sm:p-6">
                    <h3 class="font-bold text-[#04050E] mb-4 flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-[#ea9216]" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                        Progreso del Pedido
                    </h3>
                    <div class="space-y-4">
                        @php
                            $steps = [
                                [
                                    'icon' => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z',
                                    'text' => 'Pedido Recibido',
                                    'active' => true,
                                ],
                                [
                                    'icon' => 'M9 12l2 2 4-4',
                                    'text' => 'Pago Verificado',
                                    'active' =>
                                        ($order->payment && $order->payment->status === 'confirmed') ||
                                        $order->status === 'paid',
                                ],
                                [
                                    'icon' => 'M5 13l4 4L19 7',
                                    'text' => 'Libros Entregados',
                                    'active' => $order->status === 'completed' || $order->status === 'paid',
                                ],
                            ];
                        @endphp

                        @foreach ($steps as $index => $step)
                            <div class="flex items-center gap-3">
                                <div
                                    class="flex-shrink-0 w-8 h-8 rounded-full flex items-center justify-center 
                            {{ $step['active'] ? 'bg-[#ea9216] text-white' : 'bg-[#272b30]/10 text-[#272b30]/40' }}">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="{{ $step['icon'] }}" />
                                    </svg>
                                </div>
                                <span
                                    class="text-sm {{ $step['active'] ? 'text-[#04050E] font-medium' : 'text-[#272b30]/60' }}">
                                    {{ $step['text'] }}
                                </span>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Columna derecha - Comprobantes y acciones -->
            <div class="space-y-6 lg:space-y-8">
                <!-- Comprobantes de Pago -->
                <div
                    class="bg-white rounded-2xl shadow-sm border border-[#272b30]/10 p-5 sm:p-6 hover:shadow-md transition-shadow duration-300">
                    <div class="flex items-center gap-3 mb-4 sm:mb-6">
                        <div class="bg-green-100 p-2 rounded-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-600" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <h2 class="text-xl sm:text-2xl font-bold text-[#04050E]">
                            @if ($hasFreeBooks && (!$order->payment || !$order->payment->voucher_image))
                                Estado del Pedido
                            @else
                                Comprobantes de Pago
                            @endif
                        </h2>
                    </div>

                    <div class="space-y-6">
                        @if ($hasFreeBooks && (!$order->payment || !$order->payment->voucher_image))
                            <!-- Estado para pedidos gratuitos -->
                            <div class="border border-green-200 rounded-xl p-6 bg-green-50 text-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-green-500 mx-auto mb-3"
                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7" />
                                </svg>
                                <h3 class="font-bold text-green-800 text-lg mb-2">¡Pedido Gratuito Confirmado!</h3>
                                <p class="text-green-700 text-sm mb-4">
                                    Tus libros gratuitos están disponibles inmediatamente en tu biblioteca.
                                </p>
                                <a href="{{ route('book.index') }}"
                                    class="inline-flex items-center bg-green-600 text-white font-semibold py-2 px-4 rounded-lg hover:bg-green-700 transition-all duration-300">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                    </svg>
                                    Ir a Mi Biblioteca
                                </a>
                            </div>
                        @else
                            <!-- Comprobante del Cliente -->
                            @if ($order->payment && $order->payment->voucher_image)
                                <div class="border border-blue-200 rounded-xl p-4 bg-blue-50">
                                    <div class="flex items-center gap-2 mb-3">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-600"
                                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                        </svg>
                                        <h3 class="font-semibold text-blue-900">Tu Comprobante</h3>
                                    </div>

                                    @if (in_array(pathinfo($order->payment->voucher_image, PATHINFO_EXTENSION), ['pdf']))
                                        <div
                                            class="flex items-center justify-center p-4 bg-white rounded-lg border border-blue-200 mb-3">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-red-500 mr-3"
                                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                            </svg>
                                            <div>
                                                <p class="text-sm font-medium text-gray-700">Documento PDF</p>
                                                <p class="text-xs text-gray-500">Comprobante que subiste</p>
                                            </div>
                                        </div>
                                    @else
                                        <img src="{{ asset('storage/' . $order->payment->voucher_image) }}"
                                            alt="Comprobante de pago"
                                            class="w-full rounded-lg shadow-sm hover:shadow-md transition-shadow duration-300 cursor-zoom-in mb-3"
                                            onclick="openModal('{{ asset('storage/' . $order->payment->voucher_image) }}')">
                                    @endif

                                    <a href="{{ asset('storage/' . $order->payment->voucher_image) }}" target="_blank"
                                        class="w-full bg-blue-600 text-white font-semibold py-2 px-4 rounded-lg hover:bg-blue-700 transition-all duration-300 flex items-center justify-center gap-2 text-sm">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                        Ver Comprobante Completo
                                    </a>
                                </div>
                            @endif

                            <!-- Comprobante Interno de la Empresa -->
                            @if ($order->payment && $order->payment->internal_voucher)
                                <div class="border border-green-200 rounded-xl p-4 bg-green-50">
                                    <div class="flex items-center gap-2 mb-3">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-600"
                                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                        </svg>
                                        <h3 class="font-semibold text-green-900">Comprobante de la Empresa</h3>
                                    </div>

                                    <div class="mb-3">
                                        <p class="text-sm text-green-800 mb-2">
                                            Comprobante oficial emitido por nuestra empresa
                                        </p>
                                        <p class="text-xs text-green-700">
                                            Emitido el:
                                            {{ $order->payment->internal_voucher_uploaded_at->format('d/m/Y H:i') }}
                                        </p>
                                    </div>

                                    @if (pathinfo($order->payment->internal_voucher, PATHINFO_EXTENSION) === 'pdf')
                                        <div
                                            class="flex items-center justify-center p-4 bg-white rounded-lg border border-green-200 mb-3">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-red-500 mr-3"
                                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                            </svg>
                                            <div>
                                                <p class="text-sm font-medium text-gray-700">Comprobante PDF Oficial</p>
                                                <p class="text-xs text-gray-500">Documento interno de la empresa</p>
                                            </div>
                                        </div>
                                    @else
                                        <img src="{{ Storage::url($order->payment->internal_voucher) }}"
                                            alt="Comprobante interno de pago"
                                            class="w-full rounded-lg shadow-sm hover:shadow-md transition-shadow duration-300 cursor-zoom-in mb-3"
                                            onclick="openModal('{{ Storage::url($order->payment->internal_voucher) }}')">
                                    @endif

                                    <a href="{{ Storage::url($order->payment->internal_voucher) }}" target="_blank"
                                        class="w-full bg-green-600 text-white font-semibold py-2 px-4 rounded-lg hover:bg-green-700 transition-all duration-300 flex items-center justify-center gap-2 text-sm">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                        </svg>
                                        Ver Comprobante Oficial
                                    </a>
                                </div>
                            @elseif(!$hasFreeBooks)
                                <!-- Estado cuando no hay comprobante interno -->
                                <div class="border border-gray-200 rounded-xl p-4 bg-gray-50 text-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-gray-400 mx-auto mb-2"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                    <p class="text-sm text-gray-600">Comprobante interno en proceso</p>
                                    <p class="text-xs text-gray-500 mt-1">La empresa emitirá el comprobante oficial pronto
                                    </p>
                                </div>
                            @endif
                        @endif
                    </div>

                    <!-- Botones de acción -->
                    @if ($order->payment && $order->payment->voucher_image && !$hasFreeBooks)
                        <div class="mt-6 pt-4 border-t border-[#272b30]/10">
                            <p class="text-[#272b30]/70 text-sm mb-4 text-center">
                                Comprobante verificado. Ya puedes reclamar tus libros.
                            </p>

                            @php
                                $phone = '51942784270';
                                $email = 'alextaya@hotmail.com';
                                $bookNames = $order->orderDetails->pluck('book.title')->join(', ');
                                $whatsappMessage = urlencode(
                                    "Hola, he completado mi pago y quiero reclamar los siguientes libros: {$bookNames}. Número de pedido: #{$order->id}",
                                );
                                $emailSubject = urlencode("Reclamación de Pedido #{$order->id}");
                                $emailBody = urlencode(
                                    "Hola,\n\nHe completado mi pago y quiero reclamar los siguientes libros:\n\n- " .
                                        $order->orderDetails->pluck('book.title')->join("\n- ") .
                                        "\n\nNúmero de pedido: #{$order->id}\nTotal pagado: S/ " .
                                        number_format($order->orderDetails->sum('subtotal'), 2) .
                                        "\n\nAdjunto comprobante de pago.\n\nSaludos cordiales",
                                );
                            @endphp

                            <div class="space-y-3">
                                <a href="https://wa.me/{{ $phone }}?text={{ $whatsappMessage }}" target="_blank"
                                    class="w-full bg-gradient-to-r from-green-600 to-green-700 hover:from-green-700 hover:to-green-800 text-white font-semibold py-3 px-4 rounded-xl transition-all duration-300 hover:shadow-lg transform hover:-translate-y-0.5 flex items-center justify-center gap-2 shadow-md text-sm sm:text-base">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                        viewBox="0 0 24 24" fill="currentColor">
                                        <path
                                            d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z" />
                                    </svg>
                                    Reclamar por WhatsApp
                                </a>

                                <a href="mailto:{{ $email }}?subject={{ $emailSubject }}&body={{ $emailBody }}"
                                    target="_blank"
                                    class="w-full bg-gradient-to-r from-[#052f5a] to-[#041f3f] hover:from-[#041f3f] hover:to-[#052f5a] text-white font-semibold py-3 px-4 rounded-xl transition-all duration-300 hover:shadow-lg transform hover:-translate-y-0.5 flex items-center justify-center gap-2 shadow-md text-sm sm:text-base">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                    </svg>
                                    Reclamar por Email
                                </a>
                            </div>

                            <p class="text-xs text-[#272b30]/60 mt-4 text-center">
                                También puedes enviar un correo directamente a:
                                <strong class="text-[#052f5a]">alextaya@hotmail.com</strong>
                            </p>
                        </div>
                    @endif
                </div>

                <!-- Información de contacto -->
                <div class="bg-gradient-to-br from-[#052f5a] to-[#041f3f] rounded-2xl p-5 sm:p-6 text-white shadow-lg">
                    <h3 class="font-bold text-lg mb-3 flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192L5.636 18.364M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        ¿Necesitas ayuda?
                    </h3>
                    <p class="text-white/80 text-sm mb-4">Estamos aquí para ayudarte con tu pedido</p>

                    <div class="space-y-3 text-sm">
                        <div class="flex items-center gap-3 p-2 bg-white/10 rounded-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 flex-shrink-0" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                            </svg>
                            <span>+51 942 784 270</span>
                        </div>
                        <div class="flex items-center gap-3 p-2 bg-white/10 rounded-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 flex-shrink-0" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                            <span>alextaya@hotmail.com</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Modal para imagen del comprobante -->
    <div id="imageModal" class="fixed inset-0 bg-black/80 z-50 hidden items-center justify-center p-4 backdrop-blur-sm">
        <div class="bg-white rounded-2xl max-w-4xl w-full max-h-[90vh] overflow-hidden transform transition-all duration-300 scale-95 opacity-0"
            id="modalContent">
            <div class="flex justify-between items-center p-4 border-b border-[#272b30]/10">
                <h3 class="text-lg font-semibold text-[#04050E]">Comprobante de Pago</h3>
                <button onclick="closeModal()"
                    class="text-[#272b30]/60 hover:text-[#272b30] text-2xl transition-colors duration-200">&times;</button>
            </div>
            <div class="p-4 max-h-[calc(90vh-80px)] overflow-auto">
                <img id="modalImage" src="" alt="Comprobante de pago" class="w-full rounded-lg shadow-sm">
            </div>
        </div>
    </div>

    <style>
        /* Mejoras de animación y hover */
        .hover-lift:hover {
            transform: translateY(-2px);
            transition: transform 0.2s ease;
        }

        .smooth-transition {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        /* Scroll personalizado */
        .custom-scrollbar::-webkit-scrollbar {
            width: 6px;
        }

        .custom-scrollbar::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 3px;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #c1c1c1;
            border-radius: 3px;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: #a8a8a8;
        }
    </style>

    <script>
        function openModal(imageSrc) {
            const modal = document.getElementById('imageModal');
            const modalContent = document.getElementById('modalContent');
            const modalImage = document.getElementById('modalImage');

            modalImage.src = imageSrc;
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            document.body.style.overflow = 'hidden';

            // Animación de entrada
            setTimeout(() => {
                modalContent.classList.remove('scale-95', 'opacity-0');
                modalContent.classList.add('scale-100', 'opacity-100');
            }, 10);
        }

        function closeModal() {
            const modal = document.getElementById('imageModal');
            const modalContent = document.getElementById('modalContent');

            // Animación de salida
            modalContent.classList.remove('scale-100', 'opacity-100');
            modalContent.classList.add('scale-95', 'opacity-0');

            setTimeout(() => {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
                document.body.style.overflow = 'auto';
            }, 300);
        }

        // Cerrar modal con ESC
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') closeModal();
        });

        // Cerrar modal haciendo click fuera
        document.getElementById('imageModal').addEventListener('click', function(e) {
            if (e.target === this) closeModal();
        });

        // Efectos de hover mejorados
        document.addEventListener('DOMContentLoaded', function() {
            const cards = document.querySelectorAll('.bg-white');
            cards.forEach(card => {
                card.addEventListener('mouseenter', function() {
                    this.classList.add('hover-lift');
                });
                card.addEventListener('mouseleave', function() {
                    this.classList.remove('hover-lift');
                });
            });
        });
    </script>
@endsection
