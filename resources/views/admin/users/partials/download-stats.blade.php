{{-- resources/views/admin/users/partials/download-stats.blade.php --}}
<div class="bg-white border border-gray-200 rounded-lg">
    <div class="px-6 py-4 border-b border-gray-200">
        <h4 class="text-lg font-semibold flex items-center">
            <i class="fas fa-chart-line mr-2"></i>
            Estadísticas de Descargas
        </h4>
    </div>
    <div class="p-6">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
            <div class="bg-blue-50 p-4 rounded-lg text-center">
                <div class="text-2xl font-bold text-blue-600">{{ $downloadStats['today'] ?? 0 }}</div>
                <div class="text-sm text-blue-500">Hoy</div>
            </div>
            <div class="bg-green-50 p-4 rounded-lg text-center">
                <div class="text-2xl font-bold text-green-600">{{ $downloadStats['remaining'] ?? 5 }}</div>
                <div class="text-sm text-green-500">Disponibles</div>
            </div>
            <div class="bg-purple-50 p-4 rounded-lg text-center">
                <div class="text-2xl font-bold text-purple-600">{{ $downloadStats['total'] ?? 0 }}</div>
                <div class="text-sm text-purple-500">Total</div>
            </div>
            <div class="bg-orange-50 p-4 rounded-lg text-center">
                <div class="text-2xl font-bold text-orange-600">{{ $user->downloads_today }}/5</div>
                <div class="text-sm text-orange-500">Usadas Hoy</div>
            </div>
        </div>

        @if (isset($downloadStats['recent_downloads']) && $downloadStats['recent_downloads']->count() > 0)
            <h5 class="font-semibold mb-3 text-gray-700">Descargas Recientes</h5>
            <div class="space-y-2">
                @foreach ($downloadStats['recent_downloads'] as $download)
                    <div class="flex justify-between items-center p-3 bg-gray-50 rounded-lg">
                        <div class="flex-1">
                            <div class="font-medium text-sm">{{ $download->book->title }}</div>
                            <div class="text-xs text-gray-500">{{ $download->downloaded_at->format('d/m/Y H:i') }}</div>
                        </div>
                        <div class="text-xs text-gray-400">{{ $download->ip_address }}</div>
                    </div>
                @endforeach
            </div>
        @else
            <p class="text-gray-500 text-center py-4">No hay descargas recientes</p>
        @endif
    </div>
</div>
