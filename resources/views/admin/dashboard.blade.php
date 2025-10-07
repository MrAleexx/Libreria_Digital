@extends('admin.layout')

@section('title', 'Dashboard')
@section('subtitle', 'Resumen general del sistema')

@section('content')
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Total de Libros -->
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 bg-blue-100 rounded-full">
                    <span class="text-blue-600 text-2xl">📚</span>
                </div>
                <div class="ml-4">
                    <h3 class="text-sm font-medium text-gray-600">Total de Libros</h3>
                    <p class="text-2xl font-bold text-gray-900">{{ $stats['total_books'] }}</p>
                </div>
            </div>
        </div>

        <!-- Total de Usuarios -->
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 bg-green-100 rounded-full">
                    <span class="text-green-600 text-2xl">👥</span>
                </div>
                <div class="ml-4">
                    <h3 class="text-sm font-medium text-gray-600">Total de Usuarios</h3>
                    <p class="text-2xl font-bold text-gray-900">{{ $stats['total_users'] }}</p>
                </div>
            </div>
        </div>

        <!-- Total de Órdenes -->
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 bg-orange-100 rounded-full">
                    <span class="text-orange-600 text-2xl">🛒</span>
                </div>
                <div class="ml-4">
                    <h3 class="text-sm font-medium text-gray-600">Total de Órdenes</h3>
                    <p class="text-2xl font-bold text-gray-900">{{ $stats['total_orders'] }}</p>
                </div>
            </div>
        </div>

        <!-- Órdenes Pendientes -->
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 bg-red-100 rounded-full">
                    <span class="text-red-600 text-2xl">⏳</span>
                </div>
                <div class="ml-4">
                    <h3 class="text-sm font-medium text-gray-600">Órdenes Pendientes</h3>
                    <p class="text-2xl font-bold text-gray-900">{{ $stats['pending_orders'] }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Órdenes Recientes -->
    <div class="bg-white rounded-lg shadow p-6">
        <h3 class="text-lg font-semibold mb-4">Órdenes Recientes</h3>

        @if ($stats['recent_orders']->count() > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">ID</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Usuario</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Fecha</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Estado</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach ($stats['recent_orders'] as $order)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <a href="{{ route('admin.orders.show', $order) }}"
                                        class="text-blue-600 hover:text-blue-900">
                                        #{{ $order->id }}
                                    </a>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $order->user->name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $order->order_date->format('d/m/Y') }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span
                                        class="px-2 py-1 text-xs font-semibold rounded-full
                            {{ $order->status === 'paid'
                                ? 'bg-green-100 text-green-800'
                                : ($order->status === 'pending'
                                    ? 'bg-yellow-100 text-yellow-800'
                                    : 'bg-gray-100 text-gray-800') }}">
                                        {{ ucfirst($order->status) }}
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <p class="text-gray-600">No hay órdenes recientes.</p>
        @endif
    </div>
@endsection
