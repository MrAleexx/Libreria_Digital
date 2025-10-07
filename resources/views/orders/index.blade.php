@extends('layouts.app')

@section('titulo', 'Mis Pedidos')

@section('contenido')
    <section class="container mx-auto px-3 md:px-4 py-6 md:py-8">
        <!-- Header mejorado para móvil -->
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 md:mb-8">
            <div class="mb-4 md:mb-0">
                <h1 class="text-2xl md:text-3xl font-bold text-[#04050E] flex items-center gap-3">
                    <div
                        class="w-8 h-8 md:w-10 md:h-10 bg-gradient-to-r from-[#ea9216] to-[#d88310] rounded-lg flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 md:h-6 md:w-6 text-white" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                        </svg>
                    </div>
                    Mis Pedidos
                </h1>
                <p class="text-[#272b30]/80 mt-1 md:mt-2 text-sm md:text-base">Revisa el estado y detalles de todos tus
                    pedidos</p>
            </div>
            <a href="{{ route('homebook') }}"
                class="w-full md:w-auto text-center bg-gradient-to-r from-[#ea9216] to-[#d88310] hover:from-[#d88310] hover:to-[#ea9216] text-[#04050E] font-bold px-4 py-2.5 md:px-6 md:py-3 rounded-xl transition-all duration-300 hover:shadow-lg transform hover:-translate-y-1 flex items-center justify-center gap-2 shadow-md text-sm md:text-base">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 md:h-5 md:w-5" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
                Explorar más libros
            </a>
        </div>

        <!-- Filtros optimizados para móvil -->
        <div class="bg-white rounded-xl md:rounded-2xl shadow-md border border-[#272b30]/10 p-3 md:p-4 mb-6 md:mb-8">
            <div class="flex flex-col gap-3">
                <div class="flex flex-wrap gap-2 justify-center md:justify-start">
                    <button
                        class="px-3 py-1.5 md:px-4 md:py-2 rounded-lg bg-[#052f5a] text-white text-xs md:text-sm font-medium transition-colors whitespace-nowrap">
                        Todos ({{ $orders->count() }})
                    </button>
                    <button
                        class="px-3 py-1.5 md:px-4 md:py-2 rounded-lg bg-[#272b30]/5 text-[#272b30] hover:bg-[#272b30]/10 text-xs md:text-sm font-medium transition-colors whitespace-nowrap">
                        Pendientes ({{ $orders->where('status', 'pending')->count() }})
                    </button>
                    <button
                        class="px-3 py-1.5 md:px-4 md:py-2 rounded-lg bg-[#272b30]/5 text-[#272b30] hover:bg-[#272b30]/10 text-xs md:text-sm font-medium transition-colors whitespace-nowrap">
                        Completados ({{ $orders->where('status', 'paid')->count() }})
                    </button>
                </div>
                <div class="relative">
                    <input type="text" placeholder="Buscar pedido..."
                        class="w-full pl-9 pr-4 py-2 rounded-lg border border-[#272b30]/20 focus:outline-none focus:ring-2 focus:ring-[#ea9216]/50 focus:border-transparent text-sm md:text-base">
                    <svg xmlns="http://www.w3.org/2000/svg"
                        class="h-4 w-4 md:h-5 md:w-5 text-[#272b30]/60 absolute left-3 top-2.5" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>
            </div>
        </div>

        <!-- Estadísticas optimizadas para móvil -->
        @if ($orders->count() > 0)
            @php
                $completed = $orders->where('status', 'paid')->count();
                $pending = $orders->where('status', 'pending')->count();
                $total = $orders->sum(function ($order) {
                    return $order->orderDetails->sum('subtotal');
                });
            @endphp

            <div class="grid grid-cols-2 gap-3 md:gap-5 mb-6 md:mb-8">
                <div
                    class="bg-gradient-to-br from-white to-[#272b30]/5 rounded-xl md:rounded-2xl shadow-md border border-[#272b30]/10 p-3 md:p-5 transition-transform duration-300 hover:scale-[1.02] col-span-2 md:col-span-1">
                    <div class="flex justify-between items-center">
                        <div>
                            <div class="text-[#272b30]/60 text-xs md:text-sm font-medium">Total Pedidos</div>
                            <div class="text-lg md:text-2xl font-bold text-[#04050E] mt-1">{{ $orders->count() }}</div>
                        </div>
                        <div class="bg-[#052f5a]/10 p-2 rounded-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 md:h-6 md:w-6 text-[#052f5a]"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                            </svg>
                        </div>
                    </div>
                </div>

                <div
                    class="bg-gradient-to-br from-white to-[#272b30]/5 rounded-xl md:rounded-2xl shadow-md border border-[#272b30]/10 p-3 md:p-5 transition-transform duration-300 hover:scale-[1.02]">
                    <div class="flex justify-between items-center">
                        <div>
                            <div class="text-[#272b30]/60 text-xs md:text-sm font-medium">Pendientes</div>
                            <div class="text-lg md:text-2xl font-bold text-[#04050E] mt-1">{{ $pending }}</div>
                        </div>
                        <div class="bg-yellow-100 p-1.5 md:p-2 rounded-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 md:h-6 md:w-6 text-yellow-600"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                    </div>
                </div>

                <div
                    class="bg-gradient-to-br from-white to-[#272b30]/5 rounded-xl md:rounded-2xl shadow-md border border-[#272b30]/10 p-3 md:p-5 transition-transform duration-300 hover:scale-[1.02]">
                    <div class="flex justify-between items-center">
                        <div>
                            <div class="text-[#272b30]/60 text-xs md:text-sm font-medium">Completados</div>
                            <div class="text-lg md:text-2xl font-bold text-[#04050E] mt-1">{{ $completed }}</div>
                        </div>
                        <div class="bg-green-100 p-1.5 md:p-2 rounded-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 md:h-6 md:w-6 text-green-600"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                    </div>
                </div>

                <div
                    class="bg-gradient-to-br from-white to-[#272b30]/5 rounded-xl md:rounded-2xl shadow-md border border-[#272b30]/10 p-3 md:p-5 transition-transform duration-300 hover:scale-[1.02] col-span-2 md:col-span-1">
                    <div class="flex justify-between items-center">
                        <div>
                            <div class="text-[#272b30]/60 text-xs md:text-sm font-medium">Gasto Total</div>
                            <div class="text-lg md:text-2xl font-bold text-[#ea9216] mt-1">S/ {{ number_format($total, 2) }}
                            </div>
                        </div>
                        <div class="bg-[#ea9216]/10 p-1.5 md:p-2 rounded-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 md:h-6 md:w-6 text-[#ea9216]"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1" />
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Lista de pedidos optimizada para móvil -->
            <div class="bg-white rounded-xl md:rounded-2xl shadow-md border border-[#272b30]/10 overflow-hidden">
                <!-- Items de pedido -->
                <div class="divide-y divide-[#272b30]/10">
                    @foreach ($orders as $order)
                        @php
                            $itemsCount = $order->orderDetails->sum('quantity');
                            $firstProduct = $order->orderDetails->first()->book->title ?? 'Producto no disponible';
                        @endphp

                        <div
                            class="order-card bg-white px-3 md:px-6 py-4 md:py-5 hover:bg-[#272b30]/3 transition-all duration-300">
                            <a href="{{ route('orders.show', $order) }}" class="block">
                                <!-- Header móvil -->
                                <div class="flex justify-between items-start mb-3 md:hidden">
                                    <div class="font-bold text-[#ea9216] text-lg">#{{ $order->id }}</div>
                                    <span
                                        class="inline-flex items-center px-2 py-1 rounded-full text-xs font-bold
                                        @if ($order->status == 'paid') bg-green-100 text-green-800
                                        @elseif($order->status == 'pending') bg-yellow-100 text-yellow-800
                                        @else bg-red-100 text-red-800 @endif">
                                        @if ($order->status == 'paid')
                                            Pagado
                                        @elseif($order->status == 'pending')
                                            Pendiente
                                        @else
                                            Cancelado
                                        @endif
                                    </span>
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-12 gap-3 md:gap-4 items-center">
                                    <!-- N° Pedido (solo desktop) -->
                                    <div class="hidden md:block col-span-2">
                                        <div class="font-bold text-[#ea9216] text-lg">#{{ $order->id }}</div>
                                    </div>

                                    <!-- Fecha -->
                                    <div class="col-span-2">
                                        <div class="text-[#272b30]/60 text-xs md:hidden font-medium mb-1">Fecha</div>
                                        <div class="text-[#04050E] font-medium text-sm md:text-base">
                                            {{ $order->created_at->format('d/m/Y') }}</div>
                                        <div class="text-xs text-[#272b30]/60">{{ $order->created_at->format('h:i A') }}
                                        </div>
                                    </div>

                                    <!-- Productos -->
                                    <div class="col-span-6 md:col-span-4">
                                        <div class="text-[#272b30]/60 text-xs md:hidden font-medium mb-1">Productos</div>
                                        <div class="flex items-center">
                                            <span
                                                class="bg-[#ea9216]/10 text-[#ea9216] rounded-full px-2 py-1 text-xs font-bold mr-2 md:mr-3">
                                                {{ $itemsCount }} {{ $itemsCount === 1 ? 'producto' : 'productos' }}
                                            </span>
                                            <span class="text-sm text-[#04050E] truncate hidden md:block">
                                                {{ Illuminate\Support\Str::limit($firstProduct, 30) }}
                                                @if ($itemsCount > 1)
                                                    + {{ $itemsCount - 1 }} más
                                                @endif
                                            </span>
                                        </div>
                                        <div class="text-xs text-[#272b30]/60 truncate mt-1 md:hidden">
                                            {{ Illuminate\Support\Str::limit($firstProduct, 40) }}
                                            @if ($itemsCount > 1)
                                                + {{ $itemsCount - 1 }} más
                                            @endif
                                        </div>
                                    </div>

                                    <!-- Estado (solo desktop) -->
                                    <div class="hidden md:block col-span-2">
                                        <span
                                            class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold
                                            @if ($order->status == 'paid') bg-green-100 text-green-800
                                            @elseif($order->status == 'pending') bg-yellow-100 text-yellow-800
                                            @else bg-red-100 text-red-800 @endif">
                                            @if ($order->status == 'paid')
                                                Pagado
                                            @elseif($order->status == 'pending')
                                                Pendiente
                                            @else
                                                Cancelado
                                            @endif
                                        </span>
                                    </div>

                                    <!-- Total -->
                                    <div class="col-span-4 md:col-span-2">
                                        <div class="text-[#272b30]/60 text-xs md:hidden font-medium mb-1">Total</div>
                                        <div class="font-bold text-[#ea9216] text-lg md:text-base text-right md:text-left">
                                            S/ {{ number_format($order->orderDetails->sum('subtotal'), 2) }}</div>
                                    </div>
                                </div>
                            </a>

                            <!-- Acciones optimizadas para móvil -->
                            <div
                                class="flex flex-col sm:flex-row justify-between items-start sm:items-center mt-3 md:mt-4 pt-3 md:pt-4 border-t border-[#272b30]/10">
                                <div class="text-xs md:text-sm text-[#272b30]/60 mb-2 sm:mb-0 flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 md:h-4 md:w-4 inline mr-1.5"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                                    </svg>
                                    {{ isset($order->payment) ? ucfirst(str_replace('_', ' ', $order->payment->payment_method)) : 'Método no especificado' }}
                                </div>
                                <div class="flex flex-wrap gap-2 w-full sm:w-auto">
                                    <a href="{{ route('orders.show', $order) }}"
                                        class="flex-1 sm:flex-none text-center bg-[#052f5a] text-white px-3 py-2 rounded-lg font-medium hover:bg-[#041f3f] transition-colors flex items-center justify-center gap-1.5 text-xs md:text-sm">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 md:h-4 md:w-4"
                                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                        Ver detalle
                                    </a>
                                    @if ($order->status == 'paid')
                                        <button
                                            class="flex-1 sm:flex-none text-center bg-[#ea9216] text-[#04050E] px-3 py-2 rounded-lg font-medium hover:bg-[#d88310] transition-colors flex items-center justify-center gap-1.5 text-xs md:text-sm"
                                            onclick="event.preventDefault(); document.getElementById('repeat-order-{{ $order->id }}').submit();">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 md:h-4 md:w-4"
                                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                            </svg>
                                            Repetir
                                        </button>
                                        <form id="repeat-order-{{ $order->id }}"
                                            action="{{ route('orders.repeat', $order) }}" method="POST" class="hidden">
                                            @csrf
                                        </form>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Paginación optimizada -->
            @if ($orders->hasPages())
                <div class="mt-6 md:mt-8 flex justify-center">
                    <div
                        class="bg-white rounded-xl md:rounded-2xl shadow-md border border-[#272b30]/10 p-3 md:p-4 w-full max-w-md">
                        {{ $orders->links() }}
                    </div>
                </div>
            @endif
        @else
            <!-- Estado vacío optimizado -->
            <div
                class="text-center py-12 md:py-16 bg-gradient-to-br from-white to-[#272b30]/5 rounded-xl md:rounded-2xl shadow-md border border-[#272b30]/10">
                <div
                    class="bg-gradient-to-r from-[#ea9216] to-[#d88310] rounded-full p-4 md:p-6 w-16 h-16 md:w-24 md:h-24 mx-auto flex items-center justify-center shadow-lg">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 md:h-12 md:w-12 text-white" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                    </svg>
                </div>
                <h3 class="text-xl md:text-2xl font-bold text-[#04050E] mt-4 md:mt-6">No tienes pedidos aún</h3>
                <p class="text-[#272b30]/70 mt-2 md:mt-3 max-w-md mx-auto text-sm md:text-base">Cuando realices tu primera
                    compra, podrás ver el detalle de todos tus pedidos aquí.</p>
                <a href="{{ route('homebook') }}"
                    class="inline-block mt-4 md:mt-6 bg-gradient-to-r from-[#ea9216] to-[#d88310] hover:from-[#d88310] hover:to-[#ea9216] text-[#04050E] font-bold px-4 py-2.5 md:px-6 md:py-3 rounded-xl transition-all duration-300 hover:shadow-lg transform hover:-translate-y-1 flex items-center gap-2 mx-auto shadow-md text-sm md:text-base w-full max-w-xs justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 md:h-5 md:w-5" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                    Explorar libros
                </a>
            </div>
        @endif
    </section>

    <!-- Sección de soporte optimizada -->
    <section class="container mx-auto px-3 md:px-4 pb-8 md:pb-12 mt-6 md:mt-8">
        <div
            class="bg-gradient-to-r from-[#052f5a] to-[#041f3f] rounded-xl md:rounded-2xl p-4 md:p-6 text-white shadow-lg">
            <div class="flex flex-col md:flex-row items-center justify-between">
                <div class="flex items-center mb-4 md:mb-0">
                    <div class="bg-white/20 rounded-full p-2 md:p-3 mr-3 md:mr-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 md:h-6 md:w-6" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192L5.636 18.364M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="font-bold text-base md:text-lg">¿Necesitas ayuda?</h3>
                        <p class="text-white/80 text-xs md:text-sm">Nuestro equipo de soporte está disponible</p>
                    </div>
                </div>
                <div class="flex flex-col sm:flex-row gap-2 w-full md:w-auto">
                    <a href="https://wa.me/51942784270?text=Hola,%20necesito%20ayuda%20con%20mis%20pedidos"
                        target="_blank"
                        class="bg-white text-[#052f5a] px-3 py-2 rounded-lg font-medium hover:bg-[#272b30]/10 transition-colors flex items-center justify-center gap-2 text-xs md:text-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24"
                            fill="currentColor">
                            <path
                                d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z" />
                        </svg>
                        WhatsApp
                    </a>
                    <a href="mailto:alextaya@hotmail.com"
                        class="bg-[#ea9216] text-[#04050E] px-3 py-2 rounded-lg font-medium hover:bg-[#d88310] transition-colors flex items-center justify-center gap-2 text-xs md:text-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 md:h-4 md:w-4" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                        Email
                    </a>
                </div>
            </div>
        </div>
    </section>

    <style>
        .order-card {
            transition: all 0.3s ease;
            border-left: 3px solid transparent;
        }

        .order-card:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(234, 145, 22, 0.15);
            border-left: 3px solid #ea9216;
        }

        /* Mejoras para la paginación en móvil */
        .pagination {
            display: flex;
            list-style: none;
            padding: 0;
            margin: 0;
            flex-wrap: wrap;
            justify-content: center;
        }

        .pagination li {
            margin: 2px;
        }

        .pagination a,
        .pagination span {
            display: block;
            padding: 6px 10px;
            border-radius: 6px;
            text-decoration: none;
            font-weight: 500;
            font-size: 0.875rem;
        }

        .pagination a {
            color: #052f5a;
            background: white;
            border: 1px solid rgba(39, 43, 48, 0.2);
        }

        .pagination a:hover {
            background: #052f5a;
            color: white;
        }

        .pagination .active span {
            background: #ea9216;
            color: #04050E;
            border: 1px solid #ea9216;
        }

        /* Mejoras específicas para móvil */
        @media (max-width: 768px) {
            .container {
                padding-left: 1rem;
                padding-right: 1rem;
            }

            .order-card {
                margin-bottom: 0.5rem;
            }
        }
    </style>
@endsection
