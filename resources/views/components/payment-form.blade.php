@props([
    'method' => 'email',
    'accountInfo' => '',
    'action' => '',
    'buttonText' => 'Confirmar Pedido',
    'methodName' => 'Correo',
    'showUserInfo' => false,
])

<div class="bg-white rounded-2xl shadow-lg border border-[#272b30]/10 p-6" x-data="voucherPreview()">
    <div class="flex items-center gap-3 mb-6 pb-4 border-b border-[#272b30]/10">
        <div class="w-12 h-12 bg-[#052f5a] rounded-lg flex items-center justify-center">
            @if ($showUserInfo)
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                </svg>
            @else
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                </svg>
            @endif
        </div>
        <div>
            <h3 class="text-xl font-bold text-[#04050E]">
                {{ $showUserInfo ? 'Confirmación por Correo' : 'Pago con ' . $methodName }}</h3>
            <p class="text-[#272b30]/60 text-sm">
                {{ $showUserInfo ? 'Te enviaremos los detalles de tu pedido' : 'Confirma tu pedido subiendo el comprobante' }}
            </p>
        </div>
    </div>

    @if ($accountInfo)
        <div class="mb-6 p-4 bg-[#052f5a] text-white rounded-lg">
            <h4 class="font-semibold mb-2">Información de la cuenta:</h4>
            <div class="text-sm">{!! $accountInfo !!}</div>
        </div>
    @endif

    <form action="{{ $action }}" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="payment_method" value="{{ $method }}">

        <div class="space-y-4">
            @if ($showUserInfo)
                <!-- Información del usuario (solo para email) -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-[#04050E] font-semibold mb-2">Usuario</label>
                        <div class="p-3 bg-[#272b30]/5 rounded-lg border border-[#272b30]/10">
                            <span class="text-[#04050E]">{{ Auth::user()->name }}</span>
                        </div>
                    </div>
                    <div>
                        <label class="block text-[#04050E] font-semibold mb-2">Correo</label>
                        <div class="p-3 bg-[#272b30]/5 rounded-lg border border-[#272b30]/10">
                            <span class="text-[#04050E]">{{ Auth::user()->email }}</span>
                        </div>
                    </div>
                </div>

                <div>
                    <label class="block text-[#04050E] font-semibold mb-2">Estado del pedido</label>
                    <div class="p-3 bg-[#ea9216]/10 rounded-lg border border-[#ea9216]/20">
                        <span class="text-[#ea9216] font-medium">Pendiente de confirmación</span>
                    </div>
                </div>
            @endif

            <!-- Comprobante de pago (común para todos) -->
            <div>
                <label class="block text-[#04050E] font-semibold mb-3">Comprobante de pago</label>
                <div class="relative">
                    <div x-show="!voucherPreview"
                        class="border-2 border-dashed border-[#272b30]/20 rounded-xl p-6 text-center hover:border-[#ea9216] hover:bg-[#ea9216]/5 transition-all duration-300 cursor-pointer"
                        @click="$refs.voucherInput.click()">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-[#272b30]/40 mx-auto mb-3"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                        </svg>

                        <input type="file" name="voucher" x-ref="voucherInput" @change="handleFileSelect"
                            accept="image/*" class="hidden" required>

                        <p class="text-[#272b30]/60 mb-1" x-text="uploadText"></p>
                        <p class="text-[#272b30]/40 text-xs">Formatos: JPEG, PNG, JPG, GIF (Máx. 2MB)</p>
                    </div>

                    <!-- Vista previa -->
                    <div x-show="voucherPreview" x-transition
                        class="border-2 border-green-500 bg-green-50 rounded-xl p-4">
                        <div class="flex items-center justify-between mb-3">
                            <span class="text-[#04050E] font-medium text-sm flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1 text-green-600"
                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7" />
                                </svg>
                                Comprobante {{ $showUserInfo ? 'listo para enviar' : 'seleccionado' }}
                            </span>
                            <button type="button" @click="removeVoucher"
                                class="text-red-500 hover:text-red-700 transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>

                        <div class="flex flex-col md:flex-row gap-4 items-center">
                            <div class="flex-shrink-0">
                                <img :src="voucherPreview" alt="Vista previa del comprobante"
                                    class="w-32 h-32 object-contain rounded-lg border border-[#272b30]/10">
                            </div>
                            <div class="flex-1">
                                <p class="text-[#04050E] font-medium text-sm mb-1" x-text="fileName"></p>
                                <p class="text-[#272b30]/60 text-xs mb-3">
                                    {{ $showUserInfo ? 'Esta imagen se adjuntará al correo de confirmación' : 'Verifica que la imagen sea clara y legible' }}
                                </p>
                                <button type="button" @click="$refs.voucherInput.click()"
                                    class="text-[#052f5a] hover:text-[#ea9216] text-sm font-medium transition-colors">
                                    Cambiar comprobante
                                </button>
                            </div>
                        </div>

                        @if (!$showUserInfo)
                            <div class="mt-3 p-3 bg-blue-50 rounded-lg border border-blue-200">
                                <p class="text-[#052f5a] text-xs">
                                    <strong>Importante:</strong> Asegúrate de que el comprobante muestre claramente:
                                    número de operación, monto y fecha.
                                </p>
                            </div>
                        @endif
                    </div>
                </div>

                @error('voucher')
                    <p class="text-red-600 text-sm mt-2 flex items-center gap-1">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        {{ $message }}
                    </p>
                @enderror
            </div>

            <button type="submit" :disabled="!voucherPreview"
                class="w-full bg-[#ea9216] hover:bg-[#d4820d] text-white font-bold py-4 px-6 rounded-xl transition-all duration-300 hover:shadow-lg hover:shadow-[#ea9216]/20 transform hover:-translate-y-1 disabled:opacity-50 disabled:cursor-not-allowed disabled:transform-none disabled:hover:shadow-none">
                {{ $buttonText }}
            </button>
        </div>
    </form>

    <!-- Información de seguridad -->
    @if (!$showUserInfo)
        <div class="mt-4 pt-4 border-t border-[#272b30]/10">
            <div class="flex items-center justify-center gap-2 text-[#272b30]/60 text-xs">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-green-600" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                </svg>
                <span>Transacción segura y encriptada</span>
            </div>
        </div>
    @endif
</div>

<script>
    function voucherPreview() {
        return {
            voucherPreview: null,
            fileName: '',
            uploadText: 'Haz clic para subir tu comprobante',
            loading: false,

            handleFileSelect(event) {
                const file = event.target.files[0];
                if (!file) return;

                if (file.size > 2 * 1024 * 1024) {
                    alert('El archivo es demasiado grande. Máximo 2MB permitido.');
                    this.removeVoucher();
                    return;
                }

                const validTypes = ['image/jpeg', 'image/png', 'image/jpg', 'image/gif'];
                if (!validTypes.includes(file.type)) {
                    alert('Formato no válido. Solo se permiten imágenes JPEG, PNG, JPG o GIF.');
                    this.removeVoucher();
                    return;
                }

                this.loading = true;
                this.fileName = file.name;
                this.uploadText = 'Imagen seleccionada: ' + file.name;

                const reader = new FileReader();
                reader.onload = (e) => {
                    this.voucherPreview = e.target.result;
                    this.loading = false;
                };
                reader.readAsDataURL(file);
            },

            removeVoucher() {
                this.voucherPreview = null;
                this.fileName = '';
                this.uploadText = 'Haz clic para subir tu comprobante';
                this.$refs.voucherInput.value = '';
            }
        }
    }
</script>
