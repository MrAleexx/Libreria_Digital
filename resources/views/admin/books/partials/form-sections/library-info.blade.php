{{-- resources/views/admin/books/partials/form-sections/library-info.blade.php --}}
<div class="bg-white rounded-lg border border-gray-200 p-6">
    <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
        <i class="fas fa-book-reader text-purple-500 mr-2"></i>
        Configuración de Biblioteca
    </h3>

    <div class="space-y-6">
        <!-- Nivel de Acceso y Destacado -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label for="access_level" class="block text-sm font-medium text-gray-700 mb-2 flex items-center">
                    <i class="fas fa-lock text-gray-400 mr-2 text-xs"></i>
                    Nivel de Acceso *
                </label>
                <select id="access_level" name="access_level" required
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500">
                    <option value="free"
                        {{ old('access_level', $book->access_level ?? 'free') == 'free' ? 'selected' : '' }}>
                        <span class="flex items-center">
                            <i class="fas fa-unlock text-green-500 mr-2"></i>
                            Gratuito - Acceso público
                        </span>
                    </option>
                    <option value="premium"
                        {{ old('access_level', $book->access_level ?? 'free') == 'premium' ? 'selected' : '' }}>
                        <span class="flex items-center">
                            <i class="fas fa-crown text-yellow-500 mr-2"></i>
                            Premium - Requiere suscripción
                        </span>
                    </option>
                    <option value="institutional"
                        {{ old('access_level', $book->access_level ?? 'free') == 'institutional' ? 'selected' : '' }}>
                        <span class="flex items-center">
                            <i class="fas fa-building text-purple-500 mr-2"></i>
                            Institucional - Solo instituciones
                        </span>
                    </option>
                </select>
                <div class="mt-2 text-xs text-gray-500 space-y-1">
                    <div class="flex items-center">
                        <i class="fas fa-unlock text-green-500 mr-1"></i>
                        <span><strong>Gratuito:</strong> Disponible para todos los usuarios</span>
                    </div>
                    <div class="flex items-center">
                        <i class="fas fa-crown text-yellow-500 mr-1"></i>
                        <span><strong>Premium:</strong> Solo usuarios con suscripción activa</span>
                    </div>
                    <div class="flex items-center">
                        <i class="fas fa-building text-purple-500 mr-1"></i>
                        <span><strong>Institucional:</strong> Acceso mediante afiliación institucional</span>
                    </div>
                </div>
            </div>

            <!-- Libro Destacado -->
            <div class="flex items-center justify-between p-4 bg-purple-50 rounded-lg border border-purple-200">
                <div>
                    <label for="featured" class="block text-sm font-medium text-purple-700 mb-1 flex items-center">
                        <i class="fas fa-star text-yellow-500 mr-2"></i>
                        Libro Destacado
                    </label>
                    <p class="text-xs text-purple-600">
                        Aparecerá en la sección principal de la biblioteca
                    </p>
                </div>
                <label class="relative inline-flex items-center cursor-pointer">
                    <input type="checkbox" id="featured" name="featured" value="1" class="sr-only peer"
                        {{ old('featured', $book->featured ?? false) ? 'checked' : '' }}>
                    <div
                        class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-yellow-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-yellow-600">
                    </div>
                </label>
            </div>
        </div>

        <!-- Estadísticas (solo en edición) -->
        @if (isset($book) && $book->exists)
            <div class="mt-6 p-4 bg-gray-50 rounded-lg border border-gray-200">
                <h4 class="font-semibold text-gray-700 mb-3 flex items-center">
                    <i class="fas fa-chart-bar text-blue-500 mr-2"></i>
                    Estadísticas de Uso
                </h4>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    <div class="text-center p-3 bg-white rounded-lg border border-gray-200">
                        <div class="text-2xl font-bold text-blue-600">{{ $book->total_views }}</div>
                        <div class="text-xs text-blue-500 font-medium">Total Vistas</div>
                    </div>
                    <div class="text-center p-3 bg-white rounded-lg border border-gray-200">
                        <div class="text-2xl font-bold text-green-600">{{ $book->total_downloads }}</div>
                        <div class="text-xs text-green-500 font-medium">Total Descargas</div>
                    </div>
                    <div class="text-center p-3 bg-white rounded-lg border border-gray-200">
                        <div class="text-2xl font-bold text-purple-600">
                            {{ $book->total_views > 0 ? round(($book->total_downloads / $book->total_views) * 100, 1) : 0 }}%
                        </div>
                        <div class="text-xs text-purple-500 font-medium">Tasa Conversión</div>
                    </div>
                    <div class="text-center p-3 bg-white rounded-lg border border-gray-200">
                        <div class="text-2xl font-bold text-orange-600">{{ $book->downloads_count ?? 0 }}</div>
                        <div class="text-xs text-orange-500 font-medium">Descargas Únicas</div>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
