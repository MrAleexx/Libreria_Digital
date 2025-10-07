<!--resource/views/admin/ordes/invoice-preview.blade.php -->
@extends('admin.layout')
@section('title', 'Vista Previa de Boleta')
@section('subtitle', 'Boleta de Venta Electrónica')
@section('content')
    <div class="max-w-4xl mx-auto">
        <!-- Barra de acciones -->
        <div class="bg-white rounded-lg shadow-lg mb-4 p-4 flex justify-between items-center">
            <a href="{{ route('admin.orders.show', $order) }}"
                class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600 transition-colors duration-200">
                ← Volver a la Orden
            </a>
            <div class="flex space-x-2">
                <a href="{{ route('admin.orders.downloadInvoicePdf', $order) }}" target="_blank"
                    class="bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700 transition-colors duration-200 flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    Descargar PDF
                </a>
                <button onclick="sendWhatsApp()"
                    class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition-colors duration-200 flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 24 24">
                        <path
                            d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z" />
                    </svg>
                    Enviar WhatsApp
                </button>
                <form action="{{ route('admin.orders.sendInvoiceEmail', $order) }}" method="POST" class="inline">
                    @csrf
                    <button type="submit"
                        class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors duration-200 flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                        Enviar Email
                    </button>
                </form>
            </div>
        </div>

        @if (session('success'))
            <p class="text-center block p-4 bg-green-200 font-bold mb-2 uppercase text-green-800 rounded-lg" id="success">
                {{ session('success') }}
            </p>
        @endif

        @if (session('error'))
            <p class="text-center block p-4 bg-red-200 font-bold mb-2 uppercase text-red-800 rounded-lg" id="error">
                {{ session('error') }}
            </p>
        @endif

        <script>
            setTimeout(() => {
                let success = document.getElementById('success');
                let error = document.getElementById('error');
                if (success) {
                    success.style.transition = "opacity 0.5s ease";
                    success.style.opacity = "0";
                    setTimeout(() => success.remove(), 500);
                }
                if (error) {
                    error.style.transition = "opacity 0.5s ease";
                    error.style.opacity = "0";
                    setTimeout(() => error.remove(), 500);
                }
            }, 3000);
        </script>

        <!-- Contenedor de la boleta -->
        <div id="invoice-content" class="bg-white rounded-lg shadow-lg p-8">
            <!-- Encabezado -->
            <div class="border-2 border-gray-800 p-6 mb-6">
                <div class="flex justify-between items-start mb-4">
                    <div>
                        <h1 class="text-3xl font-bold text-gray-800">GRUPOA&T</h1>
                        <p class="text-sm text-gray-600">RUC: 10154316189</p>
                        <p class="text-sm text-gray-600">Urb. Libertad Mz. I Lt. 5 Calle las Moras S/N San Vicente</p>
                        <p class="text-sm text-gray-600">Teléfono: 942784270</p>
                        <p class="text-sm text-gray-600">Email: alextaya@hotmail.com</p>
                    </div>
                    <div class="text-center border-2 border-gray-800 p-4">
                        <p class="text-lg font-bold">BOLETA DE VENTA</p>
                        <p class="text-lg font-bold">ELECTRÓNICA</p>
                        <p class="text-xl font-bold mt-2">B001-{{ str_pad($order->id, 8, '0', STR_PAD_LEFT) }}</p>
                    </div>
                </div>
            </div>

            <!-- Datos del cliente -->
            <div class="mb-6">
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <p class="text-sm"><span class="font-semibold">Cliente:</span>
                            {{ $order->user->name }} {{ $order->user->last_name }}</p>
                        <p class="text-sm"><span class="font-semibold">DNI:</span> {{ $order->user->dni }}</p>
                    </div>
                    <div>
                        <p class="text-sm"><span class="font-semibold">Fecha de Emisión:</span>
                            {{ $order->created_at->format('d/m/Y') }}</p>
                        <p class="text-sm"><span class="font-semibold">Hora:</span>
                            {{ $order->created_at->format('H:i:s') }}</p>
                    </div>
                </div>
            </div>

            <!-- Tabla de productos -->
            <table class="w-full mb-6">
                <thead class="bg-gray-800 text-white">
                    <tr>
                        <th class="py-2 px-4 text-left">Código</th>
                        <th class="py-2 px-4 text-left">Descripción</th>
                        <th class="py-2 px-4 text-center">Cant.</th>
                        <th class="py-2 px-4 text-right">P. Unit.</th>
                        <th class="py-2 px-4 text-right">Total</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach ($order->orderDetails as $detail)
                        <tr>
                            <td class="py-3 px-4">LIB{{ str_pad($detail->book_id, 5, '0', STR_PAD_LEFT) }}</td>
                            <td class="py-3 px-4">
                                <p class="font-semibold">{{ $detail->book->title }}</p>
                                <p class="text-sm text-gray-600">{{ $detail->book->author }}</p>
                            </td>
                            <td class="py-3 px-4 text-center">{{ $detail->quantity }}</td>
                            <td class="py-3 px-4 text-right">S/
                                {{ number_format($detail->subtotal / $detail->quantity, 2) }}</td>
                            <td class="py-3 px-4 text-right font-semibold">S/ {{ number_format($detail->subtotal, 2) }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <!-- Totales -->
            <div class="flex justify-end mb-6">
                <div class="w-1/2">
                    <div class="flex justify-between py-2 border-b">
                        <span class="font-semibold">OP. EXONERADAS:</span>
                        <span>S/ {{ number_format($order->orderDetails->sum('subtotal'), 2) }}</span>
                    </div>
                    <div class="flex justify-between py-2 border-b">
                        <span class="font-semibold">OP. GRAVADAS:</span>
                        <span>S/ 0.00</span>
                    </div>
                    <div class="flex justify-between py-2 border-b">
                        <span class="font-semibold">IGV (18%):</span>
                        <span>S/ 0.00</span>
                    </div>
                    <div class="flex justify-between py-3 border-t-2 border-gray-800 bg-gray-100 px-4">
                        <span class="text-xl font-bold">TOTAL:</span>
                        <span class="text-xl font-bold text-green-600">S/
                            {{ number_format($order->orderDetails->sum('subtotal'), 2) }}</span>
                    </div>
                </div>
            </div>

            <!-- Total en letras -->
            <div class="bg-gray-100 p-4 mb-6 rounded">
                <p class="text-sm"><span class="font-semibold">Son:</span>
                    {{ $data['legends'][0]['value'] }}</p>
            </div>

            <!-- Método de pago -->
            <div class="mb-6">
                <p class="text-sm"><span class="font-semibold">Forma de Pago:</span> Contado</p>
                <p class="text-sm"><span class="font-semibold">Método:</span>
                    {{ strtoupper(str_replace('_', ' ', $order->payment->payment_method)) }}</p>
            </div>

            <!-- Notas -->
            <!-- Notas Legales - Minimalista Mejorado -->
            <div class="border-t border-gray-300 pt-4 mt-6">
                <div class="text-center space-y-3">
                    <p class="text-xs text-gray-700 font-semibold">
                        EXONERADO IGV - LEY N° 31893
                    </p>
                    <p class="text-xs text-gray-600 leading-relaxed">
                        Los libros se encuentran exonerados del Impuesto General a las Ventas según
                        Decreto Supremo N.° 058-2024-EF
                    </p>
                    <div class="text-xs text-gray-500">
                        <span class="font-medium">Documento electrónico</span> •
                        alextaya@hotmail.com •
                        942784270
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function sendWhatsApp() {
            const phone = '{{ $order->user->phone }}';
            const orderNumber = '{{ str_pad($order->id, 8, '0', STR_PAD_LEFT) }}';
            const total = '{{ number_format($order->orderDetails->sum('subtotal'), 2) }}';
            const pdfUrl = '{{ route('admin.orders.downloadInvoicePdf', $order) }}';

            const message = ¡Hola!👋\n\ nTu boleta electrónica está lista: \n\ n + 📄Boleta N°: B001 - $ {
                orderNumber
            }\
            n + 💰Total: S / $ {
                total
            }\
            n\ n +
                Puedes descargarla desde: $ {
                    pdfUrl
                }\
            n\ n + ¡Gracias por tu compra!📚;

            const whatsappUrl = https: //wa.me/51${phone}?text=${encodeURIComponent(message)};
                window.open(whatsappUrl, '_blank');
        }
    </script>
@endsection
