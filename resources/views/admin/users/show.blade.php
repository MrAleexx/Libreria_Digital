@extends('admin.layout')

@section('title', 'Detalles del Usuario')
@section('subtitle', 'Información completa del usuario')

@section('content')
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
            <h3 class="text-lg font-semibold">Detalles del Usuario</h3>
            <div class="flex space-x-2">
                <a href="{{ route('admin.users.edit', $user) }}"
                    class="bg-green-500 text-white px-4 py-2 rounded-lg hover:bg-green-600 transition-colors duration-200">
                    ✏️ Editar
                </a>
                <a href="{{ route('admin.users.index') }}"
                    class="bg-gray-300 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-400 transition-colors duration-200">
                    ← Volver
                </a>
            </div>
        </div>

        <div class="px-6 py-4">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Información Principal -->
                <div class="md:col-span-2">
                    <div class="bg-gray-50 p-6 rounded-lg mb-6">
                        <div class="flex items-center mb-4">
                            <div
                                class="w-16 h-16 bg-orange-500 rounded-full flex items-center justify-center text-white text-2xl font-semibold mr-4">
                                {{ strtoupper(substr($user->name, 0, 1)) }}
                            </div>
                            <div>
                                <h2 class="text-2xl font-bold text-gray-900">{{ $user->name }} {{ $user->last_name }}</h2>
                                <p class="text-gray-600">{{ $user->email }}</p>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <h4 class="text-sm font-medium text-gray-500">DNI</h4>
                                <p class="text-lg font-semibold">{{ $user->dni }}</p>
                            </div>
                            <div>
                                <h4 class="text-sm font-medium text-gray-500">Teléfono</h4>
                                <p class="text-lg font-semibold">{{ $user->phone }}</p>
                            </div>
                            <div>
                                <h4 class="text-sm font-medium text-gray-500">Rol</h4>
                                <p class="text-lg font-semibold">
                                    <span
                                        class="px-2 py-1 text-xs rounded-full 
                                    {{ $user->role === 'admin' ? 'bg-purple-100 text-purple-800' : 'bg-blue-100 text-blue-800' }}">
                                        {{ ucfirst($user->role) }}
                                    </span>
                                </p>
                            </div>
                            <div>
                                <h4 class="text-sm font-medium text-gray-500">Estado</h4>
                                <p class="text-lg font-semibold text-green-600">Activo</p>
                            </div>
                        </div>
                    </div>

                    <!-- Órdenes del Usuario -->
                    <div class="bg-white border border-gray-200 rounded-lg">
                        <div class="px-6 py-4 border-b border-gray-200">
                            <h4 class="text-lg font-semibold">Historial de Órdenes</h4>
                        </div>

                        <div class="p-6">
                            @if ($user->orders->count() > 0)
                                <div class="overflow-x-auto">
                                    <table class="min-w-full divide-y divide-gray-200">
                                        <thead class="bg-gray-50">
                                            <tr>
                                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">
                                                    Orden ID</th>
                                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">
                                                    Fecha</th>
                                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">
                                                    Total</th>
                                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">
                                                    Estado</th>
                                            </tr>
                                        </thead>
                                        <tbody class="divide-y divide-gray-200">
                                            @foreach ($user->orders as $order)
                                                <tr>
                                                    <td class="px-4 py-2">
                                                        <a href="{{ route('admin.orders.show', $order) }}"
                                                            class="text-blue-600 hover:text-blue-900">
                                                            #{{ $order->id }}
                                                        </a>
                                                    </td>
                                                    <td class="px-4 py-2">{{ $order->order_date->format('d/m/Y') }}</td>
                                                    <td class="px-4 py-2">
                                                        S/ {{ number_format($order->orderDetails->sum('subtotal'), 2) }}
                                                    </td>
                                                    <td class="px-4 py-2">
                                                        <span
                                                            class="px-2 py-1 text-xs rounded-full 
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
                                <p class="text-gray-600 text-center py-4">El usuario no tiene órdenes registradas.</p>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Información Adicional -->
                <div class="md:col-span-1">
                    <div class="bg-gray-50 p-6 rounded-lg mb-6">
                        <h4 class="text-lg font-semibold mb-4">Estadísticas</h4>

                        <div class="space-y-3">
                            <div class="flex justify-between items-center">
                                <span class="text-gray-600">Total de Órdenes:</span>
                                <span class="font-semibold">{{ $user->orders->count() }}</span>
                            </div>

                            <div class="flex justify-between items-center">
                                <span class="text-gray-600">Órdenes Pagadas:</span>
                                <span class="font-semibold text-green-600">
                                    {{ $user->orders->where('status', 'paid')->count() }}
                                </span>
                            </div>

                            <div class="flex justify-between items-center">
                                <span class="text-gray-600">Órdenes Pendientes:</span>
                                <span class="font-semibold text-yellow-600">
                                    {{ $user->orders->where('status', 'pending')->count() }}
                                </span>
                            </div>

                            <div class="flex justify-between items-center">
                                <span class="text-gray-600">Miembro desde:</span>
                                <span class="font-semibold">{{ $user->created_at->format('d/m/Y') }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="bg-gray-50 p-6 rounded-lg">
                        <h4 class="text-lg font-semibold mb-4">Acciones Rápidas</h4>

                        <div class="space-y-2">
                            <a href="{{ route('admin.orders.index', ['user_id' => $user->id]) }}"
                                class="w-full bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 transition-colors duration-200 block text-center">
                                Ver Todas las Órdenes
                            </a>

                            @if ($user->id !== auth()->id())
                                <form action="{{ route('admin.users.destroy', $user) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="w-full bg-red-500 text-white px-4 py-2 rounded-lg hover:bg-red-600 transition-colors duration-200"
                                        onclick="return confirm('¿Estás seguro de eliminar este usuario?')">
                                        🗑️ Eliminar Usuario
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
