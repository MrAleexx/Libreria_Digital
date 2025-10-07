@props(['cart', 'total'])

<div class="bg-white rounded-2xl shadow-lg border border-[#272b30]/10 p-6">
    <h3 class="text-xl font-bold text-[#04050E] mb-6 pb-4 border-b border-[#272b30]/10">Resumen de tu Pedido</h3>

    <!-- Lista de productos -->
    <div class="space-y-4 mb-6">
        @foreach ($cart as $item)
            <div class="flex items-center gap-4 p-4 border border-[#272b30]/10 rounded-lg">
                <x-book-image :image="$item['image']" :title="$item['title']" class="w-16 h-20 object-cover rounded-md" />
                <div class="flex-1 min-w-0">
                    <h4 class="font-semibold text-[#04050E] text-sm line-clamp-2">{{ $item['title'] }}</h4>
                    <p class="text-[#272b30]/60 text-xs">{{ $item['author'] }}</p>
                    <div class="flex justify-between items-center mt-2">
                        <span class="text-[#272b30]/80 text-sm">Cantidad: {{ $item['quantity'] }}</span>
                        <span class="text-[#ea9216] font-bold">S/
                            {{ number_format($item['price'] * $item['quantity'], 2) }}</span>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Totales -->
    <div class="border-t border-[#272b30]/10 pt-4 space-y-2">
        <div class="flex justify-between items-center">
            <span class="text-[#272b30]/80">Subtotal</span>
            <span class="text-[#04050E] font-semibold">S/ {{ number_format($total, 2) }}</span>
        </div>

        <!-- Nota sobre exoneración de IGV -->
        <div class="bg-[#052f5a]/5 border border-[#052f5a]/10 rounded-lg p-3">
            <div class="flex items-start gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-[#052f5a] mt-0.5 flex-shrink-0"
                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <p class="text-[#052f5a] text-xs">
                    <strong>Libros exonerados del IGV</strong> según Ley Peruana
                </p>
            </div>
        </div>

        <div class="flex justify-between items-center pt-2 border-t border-[#272b30]/10">
            <span class="text-[#04050E] font-bold text-lg">Total a pagar</span>
            <span class="text-[#ea9216] font-bold text-xl">S/ {{ number_format($total, 2) }}</span>
        </div>
    </div>
</div>
