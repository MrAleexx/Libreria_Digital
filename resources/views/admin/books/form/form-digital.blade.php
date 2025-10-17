{{-- resources/views/admin/books/form/form-digital.blade.php --}}
@props(['book' => null])

<div class="space-y-6" x-data="fileUpload()">
    <!-- Archivos: Portada y PDF con archivos existentes -->
    @include('admin.books.partials.existing-files', ['book' => $book])

    <!-- Resto del formulario digital se mantiene igual -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Nivel de Acceso -->
        <div>
            <label for="access_level" class="block text-sm font-medium text-gray-700 mb-1">
                Nivel de Acceso *
            </label>
            <select name="access_level" id="access_level" required
                class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
                <option value="free"
                    {{ old('access_level', $book->access_level ?? 'free') == 'free' ? 'selected' : '' }}>Gratuito
                </option>
                <option value="premium"
                    {{ old('access_level', $book->access_level ?? '') == 'premium' ? 'selected' : '' }}>Premium</option>
                <option value="institutional"
                    {{ old('access_level', $book->access_level ?? '') == 'institutional' ? 'selected' : '' }}>
                    Institucional</option>
            </select>
            @error('access_level')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Estado de Copyright -->
        <div>
            <label for="copyright_status" class="block text-sm font-medium text-gray-700 mb-1">
                Estado de Copyright *
            </label>
            <select name="copyright_status" id="copyright_status" required
                class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500"
                x-on:change="toggleLicenseField($event.target.value)">
                <option value="copyrighted"
                    {{ old('copyright_status', $book->copyright_status ?? 'copyrighted') == 'copyrighted' ? 'selected' : '' }}>
                    Con Copyright</option>
                <option value="public_domain"
                    {{ old('copyright_status', $book->copyright_status ?? '') == 'public_domain' ? 'selected' : '' }}>
                    Dominio Público</option>
                <option value="creative_commons"
                    {{ old('copyright_status', $book->copyright_status ?? '') == 'creative_commons' ? 'selected' : '' }}>
                    Creative Commons</option>
            </select>
            @error('copyright_status')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>
    </div>

    <!-- Campo condicional para Licencia -->
    <div id="license_field"
        style="{{ old('copyright_status', $book->copyright_status ?? 'copyrighted') != 'creative_commons' ? 'display: none;' : '' }}">
        <label for="license_type" class="block text-sm font-medium text-gray-700 mb-1">
            Tipo de Licencia Creative Commons
        </label>
        <select name="license_type" id="license_type"
            class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
            <option value="">Selecciona una licencia</option>
            <option value="CC BY" {{ old('license_type', $book->license_type ?? '') == 'CC BY' ? 'selected' : '' }}>CC
                BY - Atribución</option>
            <option value="CC BY-SA"
                {{ old('license_type', $book->license_type ?? '') == 'CC BY-SA' ? 'selected' : '' }}>CC BY-SA -
                Atribución-CompartirIgual</option>
            <option value="CC BY-ND"
                {{ old('license_type', $book->license_type ?? '') == 'CC BY-ND' ? 'selected' : '' }}>CC BY-ND -
                Atribución-SinDerivadas</option>
            <option value="CC BY-NC"
                {{ old('license_type', $book->license_type ?? '') == 'CC BY-NC' ? 'selected' : '' }}>CC BY-NC -
                Atribución-NoComercial</option>
            <option value="CC BY-NC-SA"
                {{ old('license_type', $book->license_type ?? '') == 'CC BY-NC-SA' ? 'selected' : '' }}>CC BY-NC-SA -
                Atribución-NoComercial-CompartirIgual</option>
            <option value="CC BY-NC-ND"
                {{ old('license_type', $book->license_type ?? '') == 'CC BY-NC-ND' ? 'selected' : '' }}>CC BY-NC-ND -
                Atribución-NoComercial-SinDerivadas</option>
        </select>
        @error('license_type')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <!-- Checkboxes de Estado -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <label class="flex items-center">
            <input type="checkbox" name="is_active" value="1"
                {{ old('is_active', $book->is_active ?? true) ? 'checked' : '' }}
                class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-500 focus:ring-blue-500">
            <span class="ml-2 text-sm text-gray-700">Libro Activo</span>
        </label>

        <label class="flex items-center">
            <input type="checkbox" name="downloadable" value="1"
                {{ old('downloadable', $book->downloadable ?? true) ? 'checked' : '' }}
                class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-500 focus:ring-blue-500">
            <span class="ml-2 text-sm text-gray-700">Descargable</span>
        </label>

        <label class="flex items-center">
            <input type="checkbox" name="featured" value="1"
                {{ old('featured', $book->featured ?? false) ? 'checked' : '' }}
                class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-500 focus:ring-blue-500">
            <span class="ml-2 text-sm text-gray-700">Destacado</span>
        </label>
    </div>

    <!-- Información adicional -->
    <div class="bg-blue-50 p-4 rounded-lg">
        <div class="flex">
            <div class="flex-shrink-0">
                <i class="fas fa-info-circle text-blue-400 mt-1"></i>
            </div>
            <div class="ml-3">
                <h3 class="text-sm font-medium text-blue-800">Configuración Digital</h3>
                <div class="mt-2 text-sm text-blue-700">
                    <ul class="list-disc list-inside space-y-1">
                        <li><strong>Gratuito:</strong> Acceso libre para todos los usuarios</li>
                        <li><strong>Premium:</strong> Requiere suscripción o pago</li>
                        <li><strong>Institucional:</strong> Solo para usuarios de instituciones específicas</li>
                        <li><strong>Creative Commons:</strong> Selecciona la licencia específica para contenido abierto
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script>
        function toggleLicenseField(copyrightStatus) {
            const licenseField = document.getElementById('license_field');
            if (copyrightStatus === 'creative_commons') {
                licenseField.style.display = 'block';
            } else {
                licenseField.style.display = 'none';
                document.getElementById('license_type').value = '';
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            const copyrightStatus = document.getElementById('copyright_status');
            if (copyrightStatus) {
                toggleLicenseField(copyrightStatus.value);
            }
        });
    </script>
@endpush
