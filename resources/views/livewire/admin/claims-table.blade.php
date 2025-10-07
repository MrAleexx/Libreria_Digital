<div class="bg-white rounded-lg shadow overflow-hidden">
    <!-- Header con Filtros -->
    <div class="px-6 py-4 border-b border-gray-200">
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
            <div>
                <h3 class="text-lg font-semibold">Libro de Reclamaciones</h3>
                <p class="text-sm text-gray-600 mt-1">
                    Total: {{ $totalClaims }}
                    @if ($search || $tipoFilter || $dateFilter)
                        | Filtrados: {{ $filteredCount }}
                    @endif
                </p>
            </div>

            <!-- Botón Clear Filters -->
            @if ($search || $tipoFilter || $dateFilter)
                <button wire:click="clearFilters"
                    class="px-3 py-1 text-sm text-gray-600 border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">
                    🗑️ Limpiar filtros
                </button>
            @endif
        </div>

        <!-- Filtros -->
        <div class="mt-4 grid grid-cols-1 md:grid-cols-4 gap-4">
            <!-- Búsqueda general -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Buscar</label>
                <input type="text" wire:model.live.debounce.300ms="search" placeholder="Nombre, email, DNI, asunto..."
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-orange-500">
            </div>

            <!-- Filtro por tipo -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Tipo de reclamo</label>
                <select wire:model.live="tipoFilter"
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-orange-500">
                    <option value="">Todos los tipos</option>
                    @foreach ($tipos as $key => $value)
                        <option value="{{ $key }}">{{ $value }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Filtro por fecha -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Fecha</label>
                <select wire:model.live="dateFilter"
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-orange-500">
                    <option value="">Todas las fechas</option>
                    <option value="today">Hoy</option>
                    <option value="week">Esta semana</option>
                    <option value="month">Este mes</option>
                </select>
            </div>

            <!-- Items por página -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Items por página</label>
                <select wire:model.live="perPage"
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-orange-500">
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
        @if ($claims->count() > 0)
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer"
                            wire:click="sortBy('id')">
                            ID
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Nombre
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            DNI
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Email
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Tipo
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Asunto
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Fecha
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Acciones
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach ($claims as $claim)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                #{{ $claim->id }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $claim->name }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                {{ $claim->dni }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                {{ $claim->email }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                <span
                                    class="px-2 py-1 text-xs rounded-full 
                                    @if ($claim->tipo_reclamo === 'problema_descarga') bg-blue-100 text-blue-800
                                    @elseif($claim->tipo_reclamo === 'cobro_indebido') bg-red-100 text-red-800
                                    @elseif($claim->tipo_reclamo === 'acceso_cuenta') bg-yellow-100 text-yellow-800
                                    @else bg-gray-100 text-gray-800 @endif">
                                    {{ $tipos[$claim->tipo_reclamo] ?? $claim->tipo_reclamo }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-600 max-w-xs truncate" title="{{ $claim->subject }}">
                                {{ $claim->subject }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $claim->created_at->format('d/m/Y H:i') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <a href="{{ route('admin.claims.show', $claim) }}"
                                    class="text-blue-600 hover:text-blue-900 mr-3 transition-colors">
                                    👁️ Ver
                                </a>
                                <form action="{{ route('admin.claims.destroy', $claim) }}" method="POST"
                                    class="inline" onsubmit="return confirm('¿Estás seguro de eliminar este reclamo?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900 transition-colors">
                                        🗑️ Eliminar
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <div class="p-6 text-center text-gray-600">
                @if ($search || $tipoFilter || $dateFilter)
                    <p>No se encontraron reclamos con los filtros aplicados.</p>
                    <button wire:click="clearFilters"
                        class="mt-2 px-4 py-2 text-sm text-orange-600 hover:text-orange-800 transition-colors">
                        Limpiar filtros
                    </button>
                @else
                    <p>No se han encontrado reclamos.</p>
                @endif
            </div>
        @endif
    </div>

    <!-- Paginación -->
    @if ($hasPages)
        <div class="px-6 py-4 bg-gray-50 border-t border-gray-200">
            {{ $claims->links() }}
        </div>
    @endif
</div>
