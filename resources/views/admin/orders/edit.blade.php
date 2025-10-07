@extends('admin.layout')

@section('title', 'Editar Orden')
@section('subtitle', 'Modificar información de la orden')

@section('content')
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <!-- Header con acciones -->
        <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
            <div>
                <h3 class="text-lg font-semibold">Editar Orden #{{ $order->id }}</h3>
                <p class="text-sm text-gray-500">{{ $order->order_date->format('d/m/Y H:i') }}</p>
            </div>
            <div class="flex space-x-2">
                <a href="{{ route('admin.orders.show', $order) }}"
                    class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 transition-colors duration-200 flex items-center">
                    <i class="fas fa-eye mr-2"></i>
                    Ver Detalles
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
                <!-- Columna Principal: Formularios de Edición -->
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
                                    {{ $order->status === 'paid' ? 'Pagado' : ($order->status === 'pending' ? 'Pendiente' : 'Cancelado') }}
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
                                        {{ $order->payment->status === 'confirmed' ? 'Confirmado' : ($order->payment->status === 'pending' ? 'Pendiente' : 'Rechazado') }}
                                    </span>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Formulario de Edición -->
                    <div class="bg-white border border-gray-200 rounded-lg">
                        <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                            <h4 class="text-lg font-semibold flex items-center">
                                <i class="fas fa-edit text-orange-500 mr-2"></i>
                                Actualizar Estado de la Orden
                            </h4>
                        </div>

                        <div class="p-6">
                            <form action="{{ route('admin.orders.update', $order) }}" method="POST">
                                @csrf
                                @method('PUT')

                                <div class="mb-6">
                                    <label for="status"
                                        class="block text-sm font-medium text-gray-700 mb-2 flex items-center">
                                        <i class="fas fa-tag text-gray-400 mr-2"></i>
                                        Estado de la Orden *
                                    </label>
                                    <select id="status" name="status" required
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-colors duration-200">
                                        <option value="pending"
                                            {{ old('status', $order->status) == 'pending' ? 'selected' : '' }}>
                                            <span class="text-yellow-600">⏳ Pendiente</span>
                                        </option>
                                        <option value="paid"
                                            {{ old('status', $order->status) == 'paid' ? 'selected' : '' }}>
                                            <span class="text-green-600">✅ Pagado</span>
                                        </option>
                                        <option value="cancelled"
                                            {{ old('status', $order->status) == 'cancelled' ? 'selected' : '' }}>
                                            <span class="text-red-600">❌ Cancelado</span>
                                        </option>
                                    </select>
                                    @error('status')
                                        <p class="text-red-500 text-sm mt-2 flex items-center">
                                            <i class="fas fa-exclamation-circle mr-1"></i>
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>

                                <button type="submit"
                                    class="w-full bg-orange-500 text-white px-6 py-3 rounded-lg hover:bg-orange-600 transition-colors duration-200 flex items-center justify-center font-semibold">
                                    <i class="fas fa-save mr-2"></i>
                                    Actualizar Estado
                                </button>
                            </form>
                        </div>
                    </div>

                    <!-- Gestión de Pago -->
                    @if ($order->payment)
                        <div class="bg-white border border-gray-200 rounded-lg">
                            <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                                <h4 class="text-lg font-semibold flex items-center">
                                    <i class="fas fa-credit-card text-green-500 mr-2"></i>
                                    Gestión de Pago
                                </h4>
                            </div>

                            <div class="p-6">
                                <form action="{{ route('admin.orders.updatePaymentStatus', $order) }}" method="POST">
                                    @csrf

                                    <div class="mb-6">
                                        <label for="payment_status"
                                            class="block text-sm font-medium text-gray-700 mb-2 flex items-center">
                                            <i class="fas fa-money-check text-gray-400 mr-2"></i>
                                            Estado del Pago *
                                        </label>
                                        <select id="payment_status" name="payment_status" required
                                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-colors duration-200">
                                            <option value="pending"
                                                {{ old('payment_status', $order->payment->status) == 'pending' ? 'selected' : '' }}>
                                                <span class="text-yellow-600">⏳ Pendiente</span>
                                            </option>
                                            <option value="confirmed"
                                                {{ old('payment_status', $order->payment->status) == 'confirmed' ? 'selected' : '' }}>
                                                <span class="text-green-600">✅ Aprobado</span>
                                            </option>
                                            <option value="rejected"
                                                {{ old('payment_status', $order->payment->status) == 'rejected' ? 'selected' : '' }}>
                                                <span class="text-red-600">❌ Rechazado</span>
                                            </option>
                                        </select>
                                        @error('payment_status')
                                            <p class="text-red-500 text-sm mt-2 flex items-center">
                                                <i class="fas fa-exclamation-circle mr-1"></i>
                                                {{ $message }}
                                            </p>
                                        @enderror
                                    </div>

                                    <button type="submit"
                                        class="w-full bg-green-500 text-white px-6 py-3 rounded-lg hover:bg-green-600 transition-colors duration-200 flex items-center justify-center font-semibold">
                                        <i class="fas fa-check-circle mr-2"></i>
                                        Actualizar Estado de Pago
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endif

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
                    <!-- Comprobantes de Pago -->
                    @include('admin.orders.partials.payment-voucher')
                </div>
            </div>
        </div>
    </div>
@endsection
