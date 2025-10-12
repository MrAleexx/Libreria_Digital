{{-- resources/views/admin/users/download-history.blade.php --}}
@extends('admin.layout')

@section('title', 'Historial de Descargas')
@section('subtitle', 'Registro completo de descargas del usuario')

@section('content')
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <!-- Header -->
        <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
            <div>
                <h3 class="text-lg font-semibold">Historial de Descargas</h3>
                <p class="text-gray-600 text-sm">{{ $user->name }} {{ $user->last_name }}</p>
            </div>
            <div class="flex space-x-2">
                <a href="{{ route('admin.users.show', $user) }}"
                    class="bg-gray-300 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-400 transition-colors duration-200 flex items-center">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Volver al Usuario
                </a>
                <a href="{{ route('admin.users.index') }}"
                    class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 transition-colors duration-200 flex items-center">
                    <i class="fas fa-users mr-2"></i>
                    Todos los Usuarios
                </a>
            </div>
        </div>

        <!-- Estadísticas Rápidas -->
        <div class="px-6 py-4 bg-gray-50 border-b border-gray-200">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <div class="text-center">
                    <div class="text-2xl font-bold text-blue-600">{{ $downloads->total() }}</div>
                    <div class="text-sm text-blue-500">Total Descargas</div>
                </div>
                <div class="text-center">
                    <div class="text-2xl font-bold text-green-600">
                        {{ $downloads->where('downloaded_at', '>=', today())->count() }}</div>
                    <div class="text-sm text-green-500">Hoy</div>
                </div>
                <div class="text-center">
                    <div class="text-2xl font-bold text-purple-600">
                        {{ $downloads->where('downloaded_at', '>=', now()->subDays(7))->count() }}</div>
                    <div class="text-sm text-purple-500">Últimos 7 días</div>
                </div>
                <div class="text-center">
                    <div class="text-2xl font-bold text-orange-600">{{ $user->downloads_today }}/5</div>
                    <div class="text-sm text-orange-500">Límite Hoy</div>
                </div>
            </div>
        </div>

        <!-- Filtros -->
        <div class="px-6 py-4 bg-white border-b border-gray-200">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between space-y-4 md:space-y-0">
                <div class="flex items-center space-x-4">
                    <h4 class="font-semibold text-gray-700">Filtrar por:</h4>
                    <a href="{{ request()->fullUrlWithQuery(['filter' => 'today']) }}"
                        class="px-3 py-1 text-sm rounded-full {{ request('filter') == 'today' ? 'bg-blue-100 text-blue-800' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">
                        Hoy
                    </a>
                    <a href="{{ request()->fullUrlWithQuery(['filter' => 'week']) }}"
                        class="px-3 py-1 text-sm rounded-full {{ request('filter') == 'week' ? 'bg-blue-100 text-blue-800' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">
                        Esta Semana
                    </a>
                    <a href="{{ request()->fullUrlWithQuery(['filter' => '']) }}"
                        class="px-3 py-1 text-sm rounded-full {{ !request('filter') ? 'bg-blue-100 text-blue-800' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">
                        Todos
                    </a>
                </div>

                <div class="flex items-center space-x-2">
                    <span class="text-sm text-gray-600">Mostrando {{ $downloads->count() }} de {{ $downloads->total() }}
                        registros</span>
                </div>
            </div>
        </div>

        <!-- Lista de Descargas -->
        <div class="px-6 py-4">
            @if ($downloads->count() > 0)
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Libro
                                </th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Fecha y Hora
                                </th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Dirección IP
                                </th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Información
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($downloads as $download)
                                <tr class="hover:bg-gray-50 transition-colors duration-150">
                                    <td class="px-4 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div
                                                class="flex-shrink-0 h-10 w-10 bg-orange-100 rounded-lg flex items-center justify-center">
                                                <i class="fas fa-book text-orange-600"></i>
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-medium text-gray-900">
                                                    {{ $download->book->title }}
                                                </div>
                                                <div class="text-sm text-gray-500">
                                                    {{ $download->book->publisher }}
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-4 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900 font-medium">
                                            {{ $download->downloaded_at->format('d/m/Y') }}
                                        </div>
                                        <div class="text-sm text-gray-500">
                                            {{ $download->downloaded_at->format('H:i:s') }}
                                        </div>
                                    </td>
                                    <td class="px-4 py-4 whitespace-nowrap">
                                        <div class="text-sm font-mono text-gray-900">
                                            {{ $download->ip_address }}
                                        </div>
                                        <div class="text-xs text-gray-500">
                                            {{ $download->created_at->diffForHumans() }}
                                        </div>
                                    </td>
                                    <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-500">
                                        @if ($download->downloaded_at->isToday())
                                            <span
                                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                <i class="fas fa-circle mr-1" style="font-size: 6px;"></i>
                                                Hoy
                                            </span>
                                        @elseif($download->downloaded_at->isYesterday())
                                            <span
                                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                Ayer
                                            </span>
                                        @endif

                                        @if ($download->downloaded_at->gt(now()->subDays(7)))
                                            <span
                                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800 ml-1">
                                                Reciente
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Paginación -->
                @if ($downloads->hasPages())
                    <div class="px-4 py-4 border-t border-gray-200">
                        {{ $downloads->links() }}
                    </div>
                @endif
            @else
                <div class="text-center py-12">
                    <div class="mx-auto w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                        <i class="fas fa-download text-gray-400 text-2xl"></i>
                    </div>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">No hay descargas registradas</h3>
                    <p class="text-gray-500 max-w-md mx-auto">
                        {{ $user->name }} aún no ha descargado ningún libro del sistema.
                    </p>
                    <div class="mt-6">
                        <a href="{{ route('admin.users.show', $user) }}"
                            class="inline-flex items-center px-4 py-2 bg-orange-500 text-white rounded-lg hover:bg-orange-600 transition-colors duration-200">
                            <i class="fas fa-arrow-left mr-2"></i>
                            Volver al perfil del usuario
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <!-- Información Adicional -->
    <div class="mt-6 bg-blue-50 border border-blue-200 rounded-lg p-6">
        <h4 class="font-semibold text-blue-800 mb-3 flex items-center">
            <i class="fas fa-info-circle mr-2"></i>
            Información sobre el Límite de Descargas
        </h4>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm text-blue-700">
            <div>
                <p class="font-semibold">Límite Actual:</p>
                <p>{{ $user->downloads_today }} de 5 descargas usadas hoy</p>
            </div>
            <div>
                <p class="font-semibold">Próximo Reset:</p>
                <p>El contador se reinicia cada día a las 00:00</p>
            </div>
        </div>
    </div>
@endsection
