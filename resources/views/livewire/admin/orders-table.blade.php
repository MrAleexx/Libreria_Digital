<div class="bg-white rounded-lg shadow overflow-hidden">
    <!-- Header con Filtros -->
    <div class="px-6 py-4 border-b border-gray-200">
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
            <div>
                <h3 class="text-lg font-semibold">Gestión de Órdenes</h3>
                <p class="text-sm text-gray-600 mt-1">
                    Total: {{ $totalOrders }}
                    @if ($search || $statusFilter || $paymentFilter || $dateFrom || $dateTo)
                        | Filtradas: {{ $filteredCount }}
                    @endif
                </p>
            </div>

            <!-- Botón Clear Filters -->
            @if ($search || $statusFilter || $paymentFilter || $dateFrom || $dateTo)
                <button wire:click="clearFilters"
                    class="px-3 py-1 text-sm text-gray-600 border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">
                    🗑️ Limpiar filtros
                </button>
            @endif
        </div>

        <!-- Filtros -->
        <div class="mt-4 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-6 gap-4">
            <!-- Búsqueda general -->
            <div class="lg:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-1">Buscar</label>
                <input type="text" wire:model.live.debounce.300ms="search"
                    placeholder="ID orden, nombre cliente, email..."
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-orange-500">
            </div>

            <!-- Filtro por estado -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Estado</label>
                <select wire:model.live="statusFilter"
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-orange-500">
                    <option value="">Todos los estados</option>
                    @foreach ($statuses as $key => $value)
                        <option value="{{ $key }}">{{ $value }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Filtro por estado de pago -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Estado Pago</label>
                <select wire:model.live="paymentFilter"
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-orange-500">
                    <option value="">Todos los pagos</option>
                    @foreach ($paymentStatuses as $key => $value)
                        <option value="{{ $key }}">{{ $value }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Filtro por fecha desde -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Desde</label>
                <input type="date" wire:model.live="dateFrom"
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-orange-500">
            </div>

            <!-- Filtro por fecha hasta -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Hasta</label>
                <input type="date" wire:model.live="dateTo"
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-orange-500">
            </div>
        </div>

        <!-- Items por página -->
        <div class="mt-4 flex items-center justify-between">
            <div class="flex items-center gap-2">
                <label class="text-sm font-medium text-gray-700">Items por página:</label>
                <select wire:model.live="perPage"
                    class="px-3 py-1 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-orange-500">
                    <option value="10">10</option>
                    <option value="25">25</option>
                    <option value="50">50</option>
                    <option value="100">100</option>
                </select>
            </div>
        </div>
    </div>

    <!-- Tabla -->
    <div class="overflow-x-auto">
        @if ($orders->count() > 0)
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Orden ID
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Cliente
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Fecha
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Total
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Estado
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Pago
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Acciones
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach ($orders as $order)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <a href="{{ route('admin.orders.show', $order) }}"
                                    class="text-blue-600 hover:text-blue-900 font-semibold transition-colors">
                                    #{{ $order->id }}
                                </a>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div
                                        class="w-8 h-8 bg-orange-500 rounded-full flex items-center justify-center text-white text-xs font-semibold mr-2">
                                        {{ strtoupper(substr($order->user->name, 0, 1)) }}
                                    </div>
                                    <div>
                                        <div class="font-medium">{{ $order->user->name }}</div>
                                        <div class="text-sm text-gray-500">{{ $order->user->email }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $order->order_date->format('d/m/Y') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-900">
                                S/ {{ number_format($order->orderDetails->sum('subtotal'), 2) }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span
                                    class="px-2 py-1 text-xs font-semibold rounded-full 
                                    {{ $order->status === 'paid'
                                        ? 'bg-green-100 text-green-800'
                                        : ($order->status === 'pending'
                                            ? 'bg-yellow-100 text-yellow-800'
                                            : ($order->status === 'cancelled'
                                                ? 'bg-red-100 text-red-800'
                                                : 'bg-blue-100 text-blue-800')) }}">
                                    {{ $statuses[$order->status] ?? ucfirst($order->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if ($order->payment)
                                    <span
                                        class="px-2 py-1 text-xs font-semibold rounded-full
                                        {{ $order->payment->status === 'confirmed'
                                            ? 'bg-green-100 text-green-800'
                                            : ($order->payment->status === 'pending'
                                                ? 'bg-yellow-100 text-yellow-800'
                                                : 'bg-red-100 text-red-800') }}">
                                        {{ $paymentStatuses[$order->payment->status] ?? ucfirst($order->payment->status) }}
                                    </span>
                                @else
                                    <span
                                        class="px-2 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-800">
                                        Sin pago
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <a href="{{ route('admin.orders.show', $order) }}"
                                    class="text-blue-600 hover:text-blue-900 mr-3 transition-colors"
                                    title="Ver detalles">
                                    👁️
                                </a>
                                <a href="{{ route('admin.orders.edit', $order) }}"
                                    class="text-green-600 hover:text-green-900 mr-3 transition-colors"
                                    title="Editar orden">
                                    ✏️
                                </a>
                                <form action="{{ route('admin.orders.destroy', $order) }}" method="POST"
                                    class="inline" onsubmit="return confirm('¿Estás seguro de eliminar esta orden?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900 transition-colors"
                                        title="Eliminar orden">
                                        🗑️
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <div class="p-6 text-center text-gray-600">
                @if ($search || $statusFilter || $paymentFilter || $dateFrom || $dateTo)
                    <p>No se encontraron órdenes con los filtros aplicados.</p>
                    <button wire:click="clearFilters"
                        class="mt-2 px-4 py-2 text-sm text-orange-600 hover:text-orange-800 transition-colors">
                        Limpiar filtros
                    </button>
                @else
                    <p>No hay órdenes registradas.</p>
                @endif
            </div>
        @endif
    </div>

    <!-- Paginación -->
    @if ($hasPages)
        <div class="px-6 py-4 bg-white-50 border-t border-gray-200">
            {{ $orders->links() }}
        </div>
    @endif
</div>
