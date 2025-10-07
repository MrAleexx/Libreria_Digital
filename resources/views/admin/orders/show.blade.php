{{-- resources/views/admin/orders/show.blade.php --}}
@extends('admin.layout')

@section('title', 'Detalles de la Orden')
@section('subtitle', 'Información completa de la orden')

@section('content')
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <!-- Header con acciones -->
        <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
            <div>
                <h3 class="text-lg font-semibold">Orden #{{ $order->id }}</h3>
                <p class="text-sm text-gray-500">{{ $order->order_date->format('d/m/Y H:i') }}</p>
            </div>
            <div class="flex space-x-2">
                <a href="{{ route('admin.orders.edit', $order) }}"
                    class="bg-green-500 text-white px-4 py-2 rounded-lg hover:bg-green-600 transition-colors duration-200 flex items-center">
                    <i class="fas fa-edit mr-2"></i>
                    Gestionar
                </a>
                <a href="{{ route('admin.orders.index') }}"
                    class="bg-gray-300 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-400 transition-colors duration-200 flex items-center">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Volver
                </a>
            </div>
        </div>

        <div class="px-6 py-4">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Columna Principal: Información de la Orden y Productos -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Tarjeta de Estado y Resumen -->
                    <div class="bg-white border border-gray-200 rounded-lg p-6">
                        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                            <!-- Estado -->
                            <div class="text-center p-4 bg-gray-50 rounded-lg">
                                <div class="text-sm font-medium text-gray-500 mb-2">Estado</div>
                                <span
                                    class="px-3 py-1 text-sm rounded-full
                                    {{ $order->status === 'paid'
                                        ? 'bg-green-100 text-green-800 border border-green-200'
                                        : ($order->status === 'pending'
                                            ? 'bg-yellow-100 text-yellow-800 border border-yellow-200'
                                            : 'bg-red-100 text-red-800 border border-red-200') }}">
                                    {{ ucfirst($order->status) }}
                                </span>
                            </div>

                            <!-- Total -->
                            <div class="text-center p-4 bg-gray-50 rounded-lg">
                                <div class="text-sm font-medium text-gray-500 mb-2">Total</div>
                                <div class="text-lg font-semibold text-green-600">
                                    S/ {{ number_format($order->orderDetails->sum('subtotal'), 2) }}
                                </div>
                            </div>

                            <!-- Items -->
                            <div class="text-center p-4 bg-gray-50 rounded-lg">
                                <div class="text-sm font-medium text-gray-500 mb-2">Items</div>
                                <div class="text-lg font-semibold">
                                    {{ $order->orderDetails->count() }}
                                </div>
                            </div>

                            <!-- Estado de Pago -->
                            @if ($order->payment)
                                <div class="text-center p-4 bg-gray-50 rounded-lg">
                                    <div class="text-sm font-medium text-gray-500 mb-2">Pago</div>
                                    <span
                                        class="px-3 py-1 text-sm rounded-full
                                    {{ $order->payment->status === 'confirmed'
                                        ? 'bg-green-100 text-green-800 border border-green-200'
                                        : ($order->payment->status === 'pending'
                                            ? 'bg-yellow-100 text-yellow-800 border border-yellow-200'
                                            : 'bg-red-100 text-red-800 border border-red-200') }}">
                                        {{ ucfirst($order->payment->status) }}
                                    </span>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Productos de la Orden -->
                    <div class="bg-white border border-gray-200 rounded-lg">
                        <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                            <h4 class="text-lg font-semibold flex items-center">
                                <i class="fas fa-shopping-cart text-blue-500 mr-2"></i>
                                Productos de la Orden
                            </h4>
                        </div>

                        <div class="p-6">
                            @foreach ($order->orderDetails as $detail)
                                <div
                                    class="flex items-center justify-between py-4 {{ !$loop->last ? 'border-b border-gray-100' : '' }}">
                                    <div class="flex items-center flex-1">
                                        @if ($detail->book->image)
                                            <x-book-image :image="$detail->book->image" :title="$detail->book->title"
                                                class="w-16 h-20 object-cover rounded-lg mr-4 shadow-sm" />
                                        @else
                                            <div
                                                class="w-16 h-20 bg-gradient-to-br from-gray-100 to-gray-200 rounded-lg flex items-center justify-center mr-4 shadow-sm">
                                                <i class="fas fa-book text-gray-400 text-xl"></i>
                                            </div>
                                        @endif
                                        <div class="flex-1">
                                            <h5 class="font-semibold text-gray-900">{{ $detail->book->title }}</h5>
                                            <p class="text-sm text-gray-600">{{ $detail->book->author }}</p>
                                            <div class="flex items-center space-x-4 mt-1">
                                                <span class="text-sm text-gray-500">Cantidad:
                                                    {{ $detail->quantity }}</span>
                                                <span class="text-sm text-gray-500">|</span>
                                                <span class="text-sm text-gray-500">S/
                                                    {{ number_format($detail->subtotal / $detail->quantity, 2) }}
                                                    c/u</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <p class="font-semibold text-lg text-gray-900">S/
                                            {{ number_format($detail->subtotal, 2) }}</p>
                                    </div>
                                </div>
                            @endforeach

                            <!-- Total General -->
                            <div class="flex justify-between items-center pt-4 mt-4 border-t border-gray-200">
                                <span class="text-lg font-semibold text-gray-900">Total General</span>
                                <span class="text-xl font-bold text-green-600">
                                    S/ {{ number_format($order->orderDetails->sum('subtotal'), 2) }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Columna Lateral: Información del Cliente y Comprobantes -->
                <div class="lg:col-span-1 space-y-6">
                    <!-- Información del Cliente -->
                    <div class="bg-white border border-gray-200 rounded-lg">
                        <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                            <h4 class="text-lg font-semibold flex items-center">
                                <i class="fas fa-user text-blue-500 mr-2"></i>
                                Información del Cliente
                            </h4>
                        </div>

                        <div class="p-6">
                            <div class="flex items-center mb-4">
                                <div
                                    class="w-12 h-12 bg-gradient-to-br from-orange-500 to-orange-600 rounded-full flex items-center justify-center text-white font-semibold mr-3 shadow-sm">
                                    {{ strtoupper(substr($order->user->name, 0, 1)) }}
                                </div>
                                <div>
                                    <h5 class="font-semibold text-gray-900">{{ $order->user->name }}
                                        {{ $order->user->last_name }}</h5>
                                    <p class="text-sm text-gray-600">{{ $order->user->email }}</p>
                                </div>
                            </div>

                            <div class="space-y-3">
                                <div class="flex justify-between items-center py-2 border-b border-gray-100">
                                    <span class="text-sm text-gray-600 flex items-center">
                                        <i class="fas fa-id-card text-gray-400 mr-2"></i>
                                        DNI:
                                    </span>
                                    <span class="font-semibold text-gray-900">{{ $order->user->dni }}</span>
                                </div>
                                <div class="flex justify-between items-center py-2 border-b border-gray-100">
                                    <span class="text-sm text-gray-600 flex items-center">
                                        <i class="fas fa-phone text-gray-400 mr-2"></i>
                                        Teléfono:
                                    </span>
                                    <span class="font-semibold text-gray-900">{{ $order->user->phone }}</span>
                                </div>
                                <div class="flex justify-between items-center py-2">
                                    <span class="text-sm text-gray-600 flex items-center">
                                        <i class="fas fa-shopping-bag text-gray-400 mr-2"></i>
                                        Total Órdenes:
                                    </span>
                                    <span class="font-semibold text-gray-900">{{ $order->user->orders->count() }}</span>
                                </div>
                            </div>

                            <div class="mt-6 space-y-3">
                                <a href="{{ route('admin.users.show', $order->user) }}"
                                    class="w-full bg-blue-500 text-white px-4 py-3 rounded-lg hover:bg-blue-600 transition-colors duration-200 flex items-center justify-center">
                                    <i class="fas fa-eye mr-2"></i>
                                    Ver Perfil del Cliente
                                </a>

                                @if ($order->payment && $order->status === 'paid' && $order->payment->status === 'confirmed')
                                    <a href="{{ route('admin.orders.generateInvoice', $order) }}"
                                        class="w-full bg-green-500 text-white px-4 py-3 rounded-lg hover:bg-green-600 transition-colors duration-200 flex items-center justify-center">
                                        <i class="fas fa-receipt mr-2"></i>
                                        Visualizar Boleta
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Información de Pago Consolidada -->
                    @if ($order->payment)
                        <div class="bg-white border border-gray-200 rounded-lg">
                            <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                                <h4 class="text-lg font-semibold flex items-center">
                                    <i class="fas fa-credit-card text-green-500 mr-2"></i>
                                    Información de Pago
                                </h4>
                            </div>

                            <div class="p-6">
                                <div class="space-y-4">
                                    <div class="flex justify-between items-center py-2 border-b border-gray-100">
                                        <span class="text-sm text-gray-600 flex items-center">
                                            <i class="fas fa-wallet text-gray-400 mr-2"></i>
                                            Método:
                                        </span>
                                        <span
                                            class="font-semibold text-gray-900">{{ ucfirst($order->payment->payment_method) }}</span>
                                    </div>
                                    <div class="flex justify-between items-center py-2 border-b border-gray-100">
                                        <span class="text-sm text-gray-600 flex items-center">
                                            <i class="fas fa-money-bill-wave text-gray-400 mr-2"></i>
                                            Monto:
                                        </span>
                                        <span class="font-semibold text-gray-900">S/
                                            {{ number_format($order->payment->amount, 2) }}</span>
                                    </div>
                                    <div class="flex justify-between items-center py-2 border-b border-gray-100">
                                        <span class="text-sm text-gray-600 flex items-center">
                                            <i class="fas fa-calendar text-gray-400 mr-2"></i>
                                            Fecha Pago:
                                        </span>
                                        <span
                                            class="font-semibold text-gray-900">{{ $order->payment->payment_date->format('d/m/Y H:i') }}</span>
                                    </div>
                                    <div class="flex justify-between items-center py-2">
                                        <span class="text-sm text-gray-600 flex items-center">
                                            <i class="fas fa-info-circle text-gray-400 mr-2"></i>
                                            Estado:
                                        </span>
                                        <span class="font-semibold">
                                            <span
                                                class="px-3 py-1 text-sm rounded-full
                                            {{ $order->payment->status === 'confirmed'
                                                ? 'bg-green-100 text-green-800 border border-green-200'
                                                : ($order->payment->status === 'pending'
                                                    ? 'bg-yellow-100 text-yellow-800 border border-yellow-200'
                                                    : 'bg-red-100 text-red-800 border border-red-200') }}">
                                                {{ ucfirst($order->payment->status) }}
                                            </span>
                                        </span>
                                    </div>
                                </div>

                                <!-- Comprobante del Cliente -->
                                @if ($order->payment->voucher_image)
                                    <div class="mt-6 pt-4 border-t border-gray-200">
                                        <h5 class="text-sm font-medium text-gray-700 mb-3 flex items-center">
                                            <i class="fas fa-file-upload text-blue-500 mr-2"></i>
                                            Comprobante del Cliente
                                        </h5>
                                        <div class="border border-blue-200 rounded-lg p-3 bg-blue-50">
                                            @if (in_array(pathinfo($order->payment->voucher_image, PATHINFO_EXTENSION), ['pdf']))
                                                <div class="flex items-center justify-center p-4 bg-white rounded border">
                                                    <i class="fas fa-file-pdf text-red-500 text-3xl mr-3"></i>
                                                    <div>
                                                        <p class="text-sm font-medium text-gray-700">Documento PDF</p>
                                                        <p class="text-xs text-gray-500">Comprobante del cliente</p>
                                                    </div>
                                                </div>
                                            @else
                                                <img src="{{ asset('storage/' . $order->payment->voucher_image) }}"
                                                    alt="Comprobante de pago del cliente"
                                                    class="w-full h-32 object-contain rounded">
                                            @endif
                                            <a href="{{ asset('storage/' . $order->payment->voucher_image) }}"
                                                target="_blank"
                                                class="mt-3 w-full bg-blue-500 text-white px-3 py-2 rounded text-sm hover:bg-blue-600 transition-colors duration-200 flex items-center justify-center">
                                                <i class="fas fa-expand mr-2"></i>
                                                Ver Comprobante Completo
                                            </a>
                                        </div>
                                    </div>
                                @endif

                                <!-- Comprobante Interno -->
                                @if ($order->payment->internal_voucher)
                                    <div class="mt-6 pt-4 border-t border-gray-200">
                                        <h5 class="text-sm font-medium text-gray-700 mb-3 flex items-center">
                                            <i class="fas fa-file-invoice text-green-500 mr-2"></i>
                                            Comprobante Interno
                                        </h5>
                                        <div class="border border-green-200 rounded-lg p-3 bg-green-50">
                                            <div class="mb-3">
                                                <div class="flex items-center justify-between">
                                                    <div class="flex items-center">
                                                        <i class="fas fa-building text-green-500 mr-2"></i>
                                                        <span class="text-sm font-medium text-gray-700">Comprobante interno
                                                            de la empresa</span>
                                                    </div>
                                                    <span class="text-xs text-gray-500 bg-white px-2 py-1 rounded">
                                                        {{ $order->payment->internal_voucher_uploaded_at->format('d/m/Y H:i') }}
                                                    </span>
                                                </div>
                                                <p class="text-xs text-gray-500 mt-1">
                                                    Subido por:
                                                    {{ $order->payment->internalVoucherUploader->name ?? 'Sistema' }}
                                                </p>
                                            </div>

                                            @if (pathinfo($order->payment->internal_voucher, PATHINFO_EXTENSION) === 'pdf')
                                                <div
                                                    class="flex items-center justify-center p-4 bg-white rounded border mb-3">
                                                    <i class="fas fa-file-pdf text-red-500 text-3xl mr-3"></i>
                                                    <div>
                                                        <p class="text-sm font-medium text-gray-700">Documento PDF Interno
                                                        </p>
                                                        <p class="text-xs text-gray-500">Comprobante de la empresa</p>
                                                    </div>
                                                </div>
                                            @else
                                                <img src="{{ asset('storage/' . $order->payment->internal_voucher) }}"
                                                    alt="Comprobante interno de pago"
                                                    class="w-full h-32 object-contain rounded mb-3">
                                            @endif

                                            <a href="{{ asset('storage/' . $order->payment->internal_voucher) }}"
                                                target="_blank"
                                                class="w-full bg-green-500 text-white px-3 py-2 rounded text-sm hover:bg-green-600 transition-colors duration-200 flex items-center justify-center">
                                                <i class="fas fa-eye mr-2"></i>
                                                Ver Comprobante Interno
                                            </a>
                                        </div>
                                    </div>
                                @else
                                    <div class="mt-6 pt-4 border-t border-gray-200">
                                        <h5 class="text-sm font-medium text-gray-700 mb-3 flex items-center">
                                            <i class="fas fa-file-invoice text-gray-400 mr-2"></i>
                                            Comprobante Interno
                                        </h5>
                                        <div class="border border-gray-200 rounded-lg p-4 bg-gray-50 text-center">
                                            <i class="fas fa-file-upload text-gray-400 text-2xl mb-2"></i>
                                            <p class="text-sm text-gray-600">No hay comprobante interno cargado</p>
                                            <p class="text-xs text-gray-500 mt-1">
                                                Puede subirlo desde la vista de edición
                                            </p>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endif

                    <!-- Acciones Rápidas -->
                    <div class="bg-white border border-gray-200 rounded-lg">
                        <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                            <h4 class="text-lg font-semibold flex items-center">
                                <i class="fas fa-bolt text-orange-500 mr-2"></i>
                                Acciones Rápidas
                            </h4>
                        </div>
                        <div class="p-6 space-y-3">
                            <a href="{{ route('admin.orders.edit', $order) }}"
                                class="w-full bg-orange-500 text-white px-4 py-3 rounded-lg hover:bg-orange-600 transition-colors duration-200 flex items-center justify-center">
                                <i class="fas fa-cog mr-2"></i>
                                Gestionar Orden y Pagos
                            </a>

                            @if ($order->payment && $order->payment->internal_voucher)
                                <form action="{{ route('admin.orders.deleteInternalVoucher', $order) }}" method="POST"
                                    onsubmit="return confirm('¿Estás seguro de eliminar el comprobante interno?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="w-full bg-red-500 text-white px-4 py-3 rounded-lg hover:bg-red-600 transition-colors duration-200 flex items-center justify-center">
                                        <i class="fas fa-trash mr-2"></i>
                                        Eliminar Comprobante Interno
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
