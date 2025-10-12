{{-- resources/views/admin/users/show.blade.php --}}
@extends('admin.layout')

@section('title', 'Detalles del Usuario')
@section('subtitle', 'Información completa del usuario')

@section('content')
    <div class="space-y-6">
        <!-- Header -->
        <div class="bg-white rounded-lg shadow overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
                <h3 class="text-lg font-semibold">Detalles del Usuario</h3>
                <div class="flex space-x-2">
                    <a href="{{ route('admin.users.download-history', $user) }}"
                        class="bg-purple-500 text-white px-4 py-2 rounded-lg hover:bg-purple-600 transition-colors duration-200 flex items-center">
                        <i class="fas fa-download mr-2"></i>
                        Historial Descargas
                    </a>
                    <a href="{{ route('admin.users.edit', $user) }}"
                        class="bg-green-500 text-white px-4 py-2 rounded-lg hover:bg-green-600 transition-colors duration-200 flex items-center">
                        <i class="fas fa-edit mr-2"></i>
                        Editar
                    </a>
                    <a href="{{ route('admin.users.index') }}"
                        class="bg-gray-300 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-400 transition-colors duration-200 flex items-center">
                        <i class="fas fa-arrow-left mr-2"></i>
                        Volver
                    </a>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Columna Principal -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Información del Usuario -->
                @include('admin.users.partials.user-card')

                <!-- Estadísticas de Descargas -->
                @include('admin.users.partials.download-stats')

                <!-- Órdenes del Usuario -->
                <div class="bg-white border border-gray-200 rounded-lg">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h4 class="text-lg font-semibold flex items-center">
                            <i class="fas fa-shopping-cart mr-2"></i>
                            Historial de Órdenes
                        </h4>
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
                                                        class="text-blue-600 hover:text-blue-900 font-mono">
                                                        #{{ $order->id }}
                                                    </a>
                                                </td>
                                                <td class="px-4 py-2">{{ $order->order_date->format('d/m/Y H:i') }}</td>
                                                <td class="px-4 py-2 font-semibold">
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
                            <p class="text-gray-600 text-center py-4">
                                <i class="fas fa-shopping-cart text-2xl text-gray-300 mb-2"></i><br>
                                El usuario no tiene órdenes registradas.
                            </p>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                <!-- Información de Cuenta -->
                <div class="bg-white p-6 rounded-lg border border-gray-200">
                    <h4 class="text-lg font-semibold mb-4 flex items-center">
                        <i class="fas fa-info-circle mr-2"></i>
                        Información de Cuenta
                    </h4>
                    <div class="space-y-3">
                        <div class="flex justify-between items-center">
                            <span class="text-gray-600">Estado:</span>
                            <span class="font-semibold {{ $user->is_active ? 'text-green-600' : 'text-red-600' }}">
                                {{ $user->is_active ? 'Activo' : 'Inactivo' }}
                            </span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-gray-600">Contraseña:</span>
                            <span
                                class="font-semibold {{ $user->is_temp_password ? 'text-yellow-600' : 'text-green-600' }}">
                                {{ $user->is_temp_password ? 'Temporal' : 'Permanente' }}
                            </span>
                        </div>
                        @if ($user->is_temp_password && $user->temp_password_expires_at)
                            <div class="flex justify-between items-center">
                                <span class="text-gray-600">Expira:</span>
                                <span class="font-semibold text-orange-600">
                                    {{ $user->temp_password_expires_at->format('d/m/Y') }}
                                </span>
                            </div>
                        @endif
                        <div class="flex justify-between items-center">
                            <span class="text-gray-600">Miembro desde:</span>
                            <span class="font-semibold">{{ $user->created_at->format('d/m/Y') }}</span>
                        </div>
                        @if ($user->creator)
                            <div class="flex justify-between items-center">
                                <span class="text-gray-600">Creado por:</span>
                                <span class="font-semibold">{{ $user->creator->name }}</span>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Acciones Rápidas -->
                <div class="bg-white p-6 rounded-lg border border-gray-200">
                    <h4 class="text-lg font-semibold mb-4 flex items-center">
                        <i class="fas fa-bolt mr-2"></i>
                        Acciones Rápidas
                    </h4>
                    <div class="space-y-2">
                        <a href="{{ route('admin.orders.index', ['user_id' => $user->id]) }}"
                            class="w-full bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 transition-colors duration-200 block text-center flex items-center justify-center">
                            <i class="fas fa-list mr-2"></i>
                            Ver Todas las Órdenes
                        </a>

                        @if ($user->id !== auth()->id())
                            <form action="{{ route('admin.users.toggle-status', $user) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <button type="submit"
                                    class="w-full bg-orange-500 text-white px-4 py-2 rounded-lg hover:bg-orange-600 transition-colors duration-200 flex items-center justify-center">
                                    <i class="fas {{ $user->is_active ? 'fa-toggle-off' : 'fa-toggle-on' }} mr-2"></i>
                                    {{ $user->is_active ? 'Desactivar' : 'Activar' }} Usuario
                                </button>
                            </form>

                            <form action="{{ route('admin.users.destroy', $user) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="w-full bg-red-500 text-white px-4 py-2 rounded-lg hover:bg-red-600 transition-colors duration-200 flex items-center justify-center"
                                    onclick="return confirm('¿Estás seguro de eliminar este usuario? Esta acción no se puede deshacer.')">
                                    <i class="fas fa-trash mr-2"></i>
                                    Eliminar Usuario
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
