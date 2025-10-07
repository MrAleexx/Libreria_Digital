{{-- resources/views/admin/orders/partials/payment-voucher.blade.php --}}
<div class="bg-white rounded-lg border border-gray-200 p-6">
    <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
        <i class="fas fa-receipt text-green-500 mr-2"></i>
        Comprobantes de Pago
    </h3>

    <!-- SECCIÓN 1: Comprobante del Cliente -->
    <div class="mb-6 pb-4 border-b border-gray-200">
        <h4 class="text-md font-semibold text-gray-700 mb-3 flex items-center">
            <i class="fas fa-user-upload text-blue-500 mr-2"></i>
            Comprobante del Cliente
        </h4>

        @if ($order->payment && $order->payment->voucher_url)
            <div class="border border-blue-200 rounded-lg p-4 bg-blue-50">
                <div class="flex items-center justify-between mb-3">
                    <div class="flex items-center">
                        <i class="fas fa-file-image text-blue-500 text-2xl mr-3"></i>
                        <div>
                            <p class="text-sm font-medium text-gray-900">Comprobante del cliente</p>
                            <p class="text-xs text-gray-500">
                                {{ $order->payment->payment_method }} -
                                {{ $order->payment->payment_date->format('d/m/Y H:i') }}
                            </p>
                        </div>
                    </div>
                    <a href="{{ $order->payment->voucher_url }}" target="_blank"
                        class="bg-blue-500 text-white px-3 py-1 rounded-lg text-sm hover:bg-blue-600 transition-colors duration-200 flex items-center">
                        <i class="fas fa-eye mr-1"></i>
                        Ver
                    </a>
                </div>
            </div>
        @else
            <div class="p-4 bg-yellow-50 border border-yellow-200 rounded-lg text-center">
                <i class="fas fa-exclamation-triangle text-yellow-500 text-xl mb-2"></i>
                <p class="text-sm text-yellow-700">El cliente no ha subido comprobante</p>
            </div>
        @endif
    </div>

    <!-- SECCIÓN 2: Comprobante Interno de la Empresa -->
    <div>
        <h4 class="text-md font-semibold text-gray-700 mb-3 flex items-center">
            <i class="fas fa-building text-green-500 mr-2"></i>
            Comprobante Interno
        </h4>

        @if ($order->payment && $order->payment->internal_voucher)
            <!-- Comprobante Interno Actual -->
            <div class="mb-6">
                <div class="border border-green-200 rounded-lg p-4 bg-green-50">
                    <div class="flex items-center justify-between mb-4">
                        <div class="flex items-center">
                            <i class="fas fa-file-invoice text-green-500 text-2xl mr-3"></i>
                            <div>
                                <p class="text-sm font-medium text-gray-900">Comprobante interno</p>
                                <p class="text-xs text-gray-500">
                                    Subido por: {{ $order->payment->internalVoucherUploader->name ?? 'Sistema' }} -
                                    {{ $order->payment->internal_voucher_uploaded_at->format('d/m/Y H:i') }}
                                </p>
                            </div>
                        </div>
                        <div class="flex space-x-2">
                            <a href="{{ asset('storage/' . $order->payment->internal_voucher) }}" target="_blank"
                                class="bg-green-500 text-white px-3 py-1 rounded-lg text-sm hover:bg-green-600 transition-colors duration-200 flex items-center">
                                <i class="fas fa-eye mr-1"></i>
                                Ver
                            </a>
                            <form action="{{ route('admin.orders.deleteInternalVoucher', $order) }}" method="POST"
                                class="inline"
                                onsubmit="return confirm('¿Estás seguro de eliminar el comprobante interno?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="bg-red-500 text-white px-3 py-1 rounded-lg text-sm hover:bg-red-600 transition-colors duration-200 flex items-center">
                                    <i class="fas fa-trash mr-1"></i>
                                    Eliminar
                                </button>
                            </form>
                        </div>
                    </div>

                    <!-- Solo indicador de tipo de archivo -->
                    @if (pathinfo($order->payment->internal_voucher, PATHINFO_EXTENSION) === 'pdf')
                        <div class="flex items-center justify-center p-3 bg-white rounded border">
                            <i class="fas fa-file-pdf text-red-500 text-2xl mr-2"></i>
                            <span class="text-sm font-medium text-gray-700">Documento PDF</span>
                        </div>
                    @else
                        <div class="flex items-center justify-center p-3 bg-white rounded border">
                            <i class="fas fa-file-image text-blue-500 text-2xl mr-2"></i>
                            <span class="text-sm font-medium text-gray-700">Imagen</span>
                        </div>
                    @endif
                </div>
            </div>
        @else
            <!-- Sin comprobante interno -->
            <div class="mb-6 p-4 bg-gray-100 border border-gray-200 rounded-lg text-center">
                <i class="fas fa-file-upload text-gray-400 text-xl mb-2"></i>
                <p class="text-sm text-gray-600">No hay comprobante interno cargado</p>
            </div>
        @endif

        <!-- Formulario para subir comprobante interno -->
        <form action="{{ route('admin.orders.uploadInternalVoucher', $order) }}" method="POST"
            enctype="multipart/form-data" class="border-t border-gray-200 pt-4">
            @csrf
            @method('PUT')

            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-3">
                        {{ $order->payment && $order->payment->internal_voucher ? 'Actualizar Comprobante Interno' : 'Subir Comprobante Interno' }}
                    </label>

                    <div class="flex items-center mb-2">
                        <input type="file" id="internal_voucher" name="internal_voucher" class="hidden"
                            accept="image/jpeg,image/png,image/jpg,application/pdf">

                        <button type="button" id="fileSelectButton"
                            class="px-4 py-2 bg-gray-100 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-200 transition-colors duration-200 flex items-center">
                            <i class="fas fa-paperclip mr-2"></i>
                            Seleccionar archivo
                        </button>

                        <span id="fileStatus" class="ml-3 text-sm text-gray-500">Sin archivo seleccionado</span>
                    </div>

                    <p class="text-xs text-gray-500 flex items-center">
                        <i class="fas fa-info-circle mr-1"></i>
                        Formatos aceptados: JPG, PNG, PDF (máximo 5MB)
                    </p>

                    @error('internal_voucher')
                        <p class="text-red-500 text-sm mt-1 flex items-center">
                            <i class="fas fa-exclamation-circle mr-1"></i>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <button type="submit" id="submitButton"
                    class="w-full bg-green-500 text-white px-4 py-2 rounded-lg hover:bg-green-600 transition-colors duration-200 flex items-center justify-center disabled:bg-gray-400 disabled:cursor-not-allowed"
                    disabled>
                    <i class="fas fa-save mr-2"></i>
                    {{ $order->payment && $order->payment->internal_voucher ? 'Actualizar Comprobante' : 'Guardar Comprobante Interno' }}
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const fileInput = document.getElementById('internal_voucher');
        const fileSelectButton = document.getElementById('fileSelectButton');
        const fileStatus = document.getElementById('fileStatus');
        const submitButton = document.getElementById('submitButton');

        // Abrir selector de archivos al hacer clic en el botón
        fileSelectButton.addEventListener('click', function() {
            fileInput.click();
        });

        // Manejar cambio de archivo
        fileInput.addEventListener('change', function() {
            if (this.files && this.files[0]) {
                const file = this.files[0];
                const fileSize = file.size / 1024 / 1024; // MB
                const fileType = file.type;

                // Validar tamaño
                if (fileSize > 5) {
                    alert('El archivo es demasiado grande. El tamaño máximo permitido es 5MB.');
                    this.value = '';
                    resetFileSelection();
                    return;
                }

                // Validar tipo
                const validTypes = ['image/jpeg', 'image/png', 'image/jpg', 'application/pdf'];
                if (!validTypes.includes(fileType)) {
                    alert('Formato de archivo no válido. Solo se permiten JPG, PNG y PDF.');
                    this.value = '';
                    resetFileSelection();
                    return;
                }

                // Mostrar información del archivo
                fileStatus.textContent = file.name;

                // Habilitar botón de envío
                submitButton.disabled = false;
            }
        });

        function resetFileSelection() {
            fileInput.value = '';
            fileStatus.textContent = 'Sin archivo seleccionado';
            submitButton.disabled = true;
        }
    });
</script>
