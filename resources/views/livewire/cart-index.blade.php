{{-- resource/views/livewire/cart-index.blade.php --}}
<div>
    <!-- Notificaciones -->
    <div x-data="{
        show: false,
        type: '',
        message: '',
        init() {
            window.addEventListener('show-notification', (event) => {
                this.show = true;
                this.type = event.detail.type;
                this.message = event.detail.message;
                setTimeout(() => this.show = false, 3000);
            });
        }
    }" class="fixed top-4 right-4 z-50">
        <div x-show="show" x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 transform translate-x-full"
            x-transition:enter-end="opacity-100 transform translate-x-0"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100 transform translate-x-0"
            x-transition:leave-end="opacity-0 transform translate-x-full"
            :class="{
                'bg-green-500': type === 'success',
                'bg-red-500': type === 'error',
                'bg-blue-500': type === 'info'
            }"
            class="text-white px-6 py-3 rounded-lg shadow-lg">
            <span x-text="message"></span>
        </div>
    </div>

    <section class="my-10 container mx-auto px-3">
        <!-- Header -->
        <div class="flex justify-between items-center mb-8">
            <div>
                <h2 class="text-3xl font-bold text-[#04050E]">Tu Carrito de Compras</h2>
                <p class="text-[#272b30]/60 mt-2">{{ count($cart) }} ARTÍCULO(S) EN EL CARRITO DE COMPRAS</p>
            </div>

            @if (count($cart) > 0)
                <button wire:click="clearCart" wire:confirm="¿Estás seguro de que quieres vaciar el carrito?"
                    class="flex items-center text-sm text-red-600 hover:text-red-800 transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                    </svg>
                    Vaciar Carrito
                </button>
            @endif
        </div>

        @if (count($cart) > 0)
            <div class="flex flex-col lg:flex-row gap-8">
                <!-- Columna izquierda - Productos -->
                <div class="lg:w-2/3">
                    <div class="bg-white rounded-2xl shadow-lg border border-[#272b30]/10 p-6">
                        @foreach ($cart as $item)
                            <div
                                class="flex flex-col sm:flex-row gap-4 p-6 border-b border-[#272b30]/10 last:border-b-0">
                                <!-- Imagen del libro -->
                                <div class="flex-shrink-0">
                                    <x-book-image :image="$item['image']" :title="$item['title']"
                                        class="w-24 h-32 object-cover rounded-lg shadow-md" />
                                </div>

                                <!-- Información del producto -->
                                <div class="flex-1 min-w-0">
                                    <!-- Badge para libros gratuitos -->
                                    @if (isset($item['is_free']) && $item['is_free'])
                                        <div
                                            class="inline-block bg-green-100 text-green-800 text-xs font-semibold px-2 py-1 rounded-full mb-2">
                                            GRATUITO
                                        </div>
                                    @endif

                                    <h3 class="font-semibold text-[#04050E] text-lg mb-2">{{ $item['title'] }}</h3>
                                    <p class="text-[#272b30]/80 text-sm mb-3">{{ $item['author'] }}</p>

                                    <!-- Precio unitario -->
                                    <div class="flex items-center gap-2 mb-3">
                                        <span class="text-[#272b30]/60 text-sm">Precio unitario:</span>
                                        @if (isset($item['is_free']) && $item['is_free'])
                                            <span class="text-green-600 font-bold">GRATIS</span>
                                        @else
                                            <span class="text-[#ea9216] font-bold">S/
                                                {{ number_format($item['price'], 2) }}</span>
                                        @endif
                                    </div>

                                    <!-- Cantidad -->
                                    <div class="flex items-center gap-4 mb-4">
                                        <span class="text-[#272b30]/60 text-sm">Cantidad:</span>
                                        <div class="flex items-center space-x-2">
                                            @if (isset($item['is_free']) && $item['is_free'])
                                                <!-- Para libros gratuitos, mostrar cantidad fija -->
                                                <span
                                                    class="w-16 text-center border border-[#272b30]/20 rounded-lg py-1 px-2 bg-gray-50">
                                                    1
                                                </span>
                                                <span class="text-xs text-gray-500">(Solo 1 por pedido)</span>
                                            @else
                                                <!-- Botones para libros pagados -->
                                                <div class="flex items-center space-x-2">
                                                    <button wire:click="decrement('{{ $item['id'] }}')"
                                                        wire:loading.attr="disabled"
                                                        class="w-8 h-8 rounded-full bg-[#272b30]/10 hover:bg-[#ea9216] text-[#04050E] flex items-center justify-center transition-colors disabled:opacity-50"
                                                        {{ $item['quantity'] <= 1 ? 'disabled' : '' }}>
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4"
                                                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2" d="M20 12H4" />
                                                        </svg>
                                                    </button>

                                                    <input type="number" value="{{ $item['quantity'] }}"
                                                        wire:change="updateQuantity('{{ $item['id'] }}', $event.target.value)"
                                                        min="1" max="5"
                                                        class="w-16 text-center border border-[#272b30]/20 rounded-lg py-1 px-2 focus:border-[#ea9216] focus:ring-2 focus:ring-[#ea9216]/20">

                                                    <button wire:click="increment('{{ $item['id'] }}')"
                                                        wire:loading.attr="disabled"
                                                        class="w-8 h-8 rounded-full bg-[#272b30]/10 hover:bg-[#ea9216] text-[#04050E] flex items-center justify-center transition-colors disabled:opacity-50"
                                                        {{ $item['quantity'] >= 5 ? 'disabled' : '' }}>
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4"
                                                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2" d="M12 4v16m8-8H4" />
                                                        </svg>
                                                    </button>
                                                </div>
                                            @endif
                                        </div>
                                    </div>

                                    <!-- Subtotal -->
                                    <div class="flex items-center gap-2 mb-4">
                                        <span class="text-[#272b30]/60 text-sm">Subtotal:</span>
                                        @if (isset($item['is_free']) && $item['is_free'])
                                            <span class="text-green-600 font-bold text-lg">GRATIS</span>
                                        @else
                                            <span class="text-[#ea9216] font-bold text-lg">
                                                S/ {{ number_format($item['price'] * $item['quantity'], 2) }}
                                            </span>
                                        @endif
                                    </div>

                                    <!-- Acciones -->
                                    <div class="flex gap-4">
                                        <button
                                            class="flex items-center text-[#052f5a] hover:text-[#041f3f] transition-colors text-sm">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                            </svg>
                                            AÑADIR A MIS DESEOS
                                        </button>

                                        <button wire:click="removeItem('{{ $item['id'] }}')"
                                            wire:confirm="¿Estás seguro de que quieres eliminar este producto?"
                                            class="flex items-center text-red-600 hover:text-red-800 transition-colors text-sm">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                            QUITAR ARTÍCULO
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Botón seguir comprando -->
                    <div class="mt-6">
                        <a href="{{ route('homebook') }}"
                            class="inline-flex items-center bg-white hover:bg-[#272b30]/5 text-[#04050E] font-semibold px-6 py-3 rounded-lg transition-all duration-300 border border-[#272b30]/20">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                            </svg>
                            Seguir Comprando
                        </a>
                    </div>
                </div>

                <!-- Columna derecha - Resumen de compra -->
                <div class="lg:w-1/3">
                    <div class="bg-white rounded-2xl shadow-lg border border-[#272b30]/10 p-6 sticky top-6">
                        <h3 class="text-xl font-bold text-[#04050E] mb-6 pb-4 border-b border-[#272b30]/10">RESUMEN DE
                            COMPRA</h3>

                        <!-- Detalles del resumen -->
                        <div class="space-y-4 mb-6">
                            <div class="flex justify-between items-center">
                                <span class="text-[#272b30]/80">Subtotal</span>
                                <span class="text-[#04050E] font-semibold">S/ {{ number_format($total, 2) }}</span>
                            </div>

                            <!-- Mostrar libros gratuitos si existen -->
                            @php
                                $freeBooksCount = count(
                                    array_filter($cart, function ($item) {
                                        return isset($item['is_free']) && $item['is_free'];
                                    }),
                                );
                            @endphp

                            @if ($freeBooksCount > 0)
                                <div class="bg-green-50 border border-green-200 rounded-lg p-3">
                                    <div class="flex items-center gap-2 text-green-800">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M5 13l4 4L19 7" />
                                        </svg>
                                        <span class="text-sm font-medium">Incluye {{ $freeBooksCount }} libro(s)
                                            gratuito(s)</span>
                                    </div>
                                </div>
                            @endif

                            <!-- Nota sobre exoneración de IGV -->
                            <div class="bg-[#052f5a]/5 border border-[#052f5a]/10 rounded-lg p-3">
                                <div class="flex items-start gap-2">
                                    <svg xmlns="http://www.w3.org/2000/svg"
                                        class="h-4 w-4 text-[#052f5a] mt-0.5 flex-shrink-0" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <p class="text-[#052f5a] text-xs">
                                        <strong>Libros exonerados del IGV</strong> según Ley N.° 31893
                                    </p>
                                </div>
                            </div>

                            <div class="flex justify-between items-center pt-4 border-t border-[#272b30]/10">
                                <span class="text-[#04050E] font-bold text-lg">Total a pagar</span>
                                <span class="text-[#ea9216] font-bold text-xl">S/
                                    {{ number_format($total, 2) }}</span>
                            </div>
                        </div>

                        <!-- Botón finalizar compra -->
                        <a href="{{ route('cart.checkout') }}"
                            class="w-full bg-gradient-to-r from-[#052f5a] to-[#041f3f] hover:from-[#041f3f] hover:to-[#052f5a] text-white font-bold py-4 px-6 rounded-lg transition-all duration-300 hover:scale-105 shadow-lg hover:shadow-xl text-center block">
                            @if ($total == 0 && $freeBooksCount > 0)
                                OBTENER LIBROS GRATIS
                            @else
                                FINALIZAR COMPRA
                            @endif
                        </a>

                        <!-- Información adicional -->
                        <div class="mt-4 text-center">
                            <p class="text-[#272b30]/60 text-xs">
                                @if ($total == 0 && $freeBooksCount > 0)
                                    * Los libros gratuitos estarán disponibles inmediatamente
                                @else
                                    * El envío se calculará en el proceso de checkout
                                @endif
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <!-- Carrito vacío -->
            <div class="text-center py-16">
                <div class="w-32 h-32 mx-auto mb-6 text-[#272b30]/20">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1"
                            d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                </div>
                <h3 class="text-2xl font-bold text-[#04050E] mb-4">Tu carrito está vacío</h3>
                <p class="text-[#272b30]/60 mb-8 max-w-md mx-auto">
                    Explora nuestra colección de libros y encuentra tu próxima lectura favorita
                </p>
                <a href="{{ route('homebook') }}"
                    class="inline-flex items-center bg-[#ea9216] hover:bg-[#d88310] text-[#04050E] font-bold px-8 py-3 rounded-lg transition-all duration-300 hover:scale-105 shadow-lg">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                    Explorar Libros
                </a>
            </div>
        @endif
    </section>
</div>
