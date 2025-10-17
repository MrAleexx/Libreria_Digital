{{-- resources/views/admin/books/form/show-physical.blade.php --}}
<div class="space-y-6">
    <!-- Resumen de ejemplares -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <div class="bg-white p-6 rounded-lg border text-center">
            <div class="text-2xl font-bold text-gray-900">{{ $book->total_physical_copies }}</div>
            <div class="text-sm text-gray-600">Total Ejemplares</div>
        </div>
        <div class="bg-white p-6 rounded-lg border text-center">
            <div class="text-2xl font-bold text-green-600">{{ $book->available_physical_copies }}</div>
            <div class="text-sm text-gray-600">Disponibles</div>
        </div>
        <div class="bg-white p-6 rounded-lg border text-center">
            <div class="text-2xl font-bold text-blue-600">{{ $book->total_loans }}</div>
            <div class="text-sm text-gray-600">Préstamos Totales</div>
        </div>
        <div class="bg-white p-6 rounded-lg border text-center">
            @php
                $reserved = $book
                    ->reservations()
                    ->whereIn('status', ['pending', 'ready_for_pickup'])
                    ->count();
            @endphp
            <div class="text-2xl font-bold text-orange-600">{{ $reserved }}</div>
            <div class="text-sm text-gray-600">Reservas Activas</div>
        </div>
    </div>

    <!-- Acciones rápidas -->
    <div class="bg-white p-6 rounded-lg border">
        <h4 class="text-lg font-medium text-gray-900 mb-4">Acciones Rápidas</h4>
        <div class="flex flex-wrap gap-3">
            <a href="{{ route('admin.physical-copies.index', ['book_id' => $book->id]) }}"
                class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700">
                <i class="fas fa-boxes mr-2"></i>
                Gestionar Ejemplares
            </a>
            <a href="{{ route('admin.loans.create', ['book_id' => $book->id]) }}"
                class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700">
                <i class="fas fa-hand-holding mr-2"></i>
                Nuevo Préstamo
            </a>
            <a href="{{ route('admin.reservations.create', ['book_id' => $book->id]) }}"
                class="inline-flex items-center px-4 py-2 bg-orange-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-orange-700">
                <i class="fas fa-calendar-check mr-2"></i>
                Nueva Reserva
            </a>
        </div>
    </div>

    <!-- Información de depósito legal -->
    @if ($book->details && ($book->details->deposito_legal || $book->details->edition))
        <div class="bg-white p-6 rounded-lg border">
            <h4 class="text-lg font-medium text-gray-900 mb-4">Información Física</h4>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                @if ($book->details->deposito_legal)
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Depósito Legal</label>
                        <p class="mt-1 text-sm text-gray-900">{{ $book->details->deposito_legal }}</p>
                    </div>
                @endif

                @if ($book->details->edition)
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Edición</label>
                        <p class="mt-1 text-sm text-gray-900">{{ $book->details->edition }}</p>
                    </div>
                @endif
            </div>
        </div>
    @endif

    <!-- Lista de ejemplares recientes -->
    @php
        $recentCopies = $book
            ->physicalCopies()
            ->with([
                'loans' => function ($query) {
                    $query->where('status', 'active');
                },
            ])
            ->latest()
            ->take(5)
            ->get();
    @endphp

    <div class="bg-white p-6 rounded-lg border">
        <h4 class="text-lg font-medium text-gray-900 mb-4">Ejemplares Recientes</h4>

        @if ($recentCopies->count() > 0)
            <div class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 rounded-lg">
                <table class="min-w-full divide-y divide-gray-300">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Código
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Estado
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Ubicación
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Préstamo
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach ($recentCopies as $copy)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">{{ $copy->barcode }}</div>
                                    <div class="text-sm text-gray-500">Ej. #{{ $copy->copy_number }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                        @if ($copy->status === 'available') bg-green-100 text-green-800
                                        @elseif($copy->status === 'loaned') bg-blue-100 text-blue-800
                                        @elseif($copy->status === 'reserved') bg-orange-100 text-orange-800
                                        @else bg-yellow-100 text-yellow-800 @endif">
                                        {{ $copy->status === 'available'
                                            ? 'Disponible'
                                            : ($copy->status === 'loaned'
                                                ? 'Prestado'
                                                : ($copy->status === 'reserved'
                                                    ? 'Reservado'
                                                    : 'Mantenimiento')) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $copy->location ?? 'Sin ubicación' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    @if ($copy->loans->count() > 0)
                                        <span class="text-red-600">Prestado</span>
                                    @else
                                        <span class="text-green-600">Disponible</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="text-center py-8">
                <i class="fas fa-box-open text-4xl text-gray-300 mb-4"></i>
                <p class="text-gray-500">No hay ejemplares físicos registrados para este libro.</p>
                <a href="{{ route('admin.physical-copies.create', ['book_id' => $book->id]) }}"
                    class="mt-4 inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700">
                    <i class="fas fa-plus mr-2"></i>
                    Agregar Primer Ejemplar
                </a>
            </div>
        @endif
    </div>
</div>
