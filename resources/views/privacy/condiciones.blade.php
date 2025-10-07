@extends('layouts.app')

@section('titulo', 'Términos y Condiciones')

@section('contenido')
    <div class="bg-white min-h-screen py-8">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Migas de pan -->
            <nav class="mb-6 text-sm">
                <ol class="list-none p-0 inline-flex">
                    <li class="flex items-center">
                        <a href="{{ url('/') }}" class="text-[#052f5a] hover:text-[#ea9216]">Home</a>
                        <svg class="w-3 h-3 mx-2 text-[#052f5a]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </li>
                    <li class="text-[#ea9216] font-medium">Términos y Condiciones</li>
                </ol>
            </nav>

            <!-- Título principal -->
            <div class="text-center mb-8">
                <h1 class="text-2xl font-bold text-gray-900 mb-6">Términos y Condiciones</h1>
            </div>

            <!-- Contenido -->
            <div class="prose prose-lg max-w-none">
                <p class="text-gray-700 mb-6">
                    El acceso y uso de este sitio web se rige por los presentes <strong>“Términos y Condiciones”</strong>, así
                    como por la legislación vigente en la República del Perú. Al realizar una compra en este sitio, el usuario
                    declara que ha leído, comprendido y aceptado todas las disposiciones aquí establecidas.
                </p>

                <!-- Sección 1 -->
                <div class="mb-8">
                    <h2 class="text-xl font-bold text-gray-900 mb-4">1. OBJETO DEL SERVICIO</h2>
                    <p class="text-gray-700">
                        Este sitio web comercializa exclusivamente un <strong>libro electrónico (eBook)</strong> de propiedad de
                        <strong>GRUPO A&amp;T</strong>. El producto se entrega únicamente en formato digital y su acceso se realiza
                        a través de la plataforma habilitada para ello. No existen ventas físicas ni entregas mediante despacho.
                    </p>
                </div>

                <!-- Sección 2 -->
                <div class="mb-8">
                    <h2 class="text-xl font-bold text-gray-900 mb-4">2. REGISTRO DEL USUARIO</h2>
                    <p class="text-gray-700">
                        Para adquirir el eBook no es obligatorio el registro previo, sin embargo, el usuario deberá proporcionar
                        datos personales básicos y válidos al momento de realizar la compra. Toda la información brindada será tratada
                        conforme a la Ley N.º 29733, Ley de Protección de Datos Personales.
                    </p>
                </div>

                <!-- Sección 3 -->
                <div class="mb-8">
                    <h2 class="text-xl font-bold text-gray-900 mb-4">3. MEDIOS DE PAGO</h2>
                    <p class="text-gray-700">
                        El pago del eBook se realiza exclusivamente mediante <strong>transferencia o depósito bancario</strong>.
                        Para validar la compra, el usuario deberá subir en la plataforma la <strong>captura o comprobante del
                        pago</strong>. Una vez verificado el pago, se habilitará el acceso al producto digital.
                    </p>
                </div>

                <!-- Sección 4 -->
                <div class="mb-8">
                    <h2 class="text-xl font-bold text-gray-900 mb-4">4. ACCESO Y DESCARGA</h2>
                    <p class="text-gray-700">
                        Tras la confirmación del pago, el usuario tendrá derecho a acceder y/o descargar el eBook adquirido desde la
                        plataforma. El acceso es personal e intransferible y no otorga derecho de redistribución, reventa o cesión a
                        terceros.
                    </p>
                </div>

                <!-- Sección 5 -->
                <div class="mb-8">
                    <h2 class="text-xl font-bold text-gray-900 mb-4">5. DERECHOS DEL USUARIO</h2>
                    <p class="text-gray-700">
                        El usuario gozará de todos los derechos reconocidos en la legislación de protección al consumidor vigente en
                        el Perú, además de los establecidos en este documento. Asimismo, podrá ejercer en cualquier momento sus
                        derechos ARCO (Acceso, Rectificación, Cancelación y Oposición) enviando un correo electrónico a
                        <a href="mailto:alextaya@hotmail.com" class="text-[#052f5a] hover:text-[#ea9216] underline">alextaya@hotmail.com</a>.
                    </p>
                </div>

                <!-- Sección 6 -->
                <div class="mb-8">
                    <h2 class="text-xl font-bold text-gray-900 mb-4">6. POLÍTICA DE DEVOLUCIONES</h2>
                    <p class="text-gray-700">
                        Debido a la naturaleza digital del producto, no se aceptan cambios ni devoluciones una vez que el eBook ha
                        sido adquirido y puesto a disposición del usuario. Solo en caso de que el archivo presente fallas técnicas que
                        impidan su uso, GRUPO A&amp;T podrá, previa verificación, ofrecer una nueva descarga sin costo adicional.
                    </p>
                </div>

                <!-- Sección 7 -->
                <div class="mb-8">
                    <h2 class="text-xl font-bold text-gray-900 mb-4">7. PROPIEDAD INTELECTUAL</h2>
                    <p class="text-gray-700">
                        Todo el contenido del eBook, así como los textos, gráficos, imágenes y demás elementos disponibles en el
                        sitio, son propiedad de GRUPO A&amp;T y están protegidos por las normas de propiedad intelectual. Queda prohibida
                        su reproducción, distribución o uso no autorizado sin consentimiento previo y por escrito.
                    </p>
                </div>

                <!-- Sección 8 -->
                <div class="mb-8">
                    <h2 class="text-xl font-bold text-gray-900 mb-4">8. SEGURIDAD Y PRIVACIDAD</h2>
                    <p class="text-gray-700">
                        GRUPO A&amp;T garantiza que la información personal brindada por los usuarios será tratada de manera
                        confidencial y únicamente con la finalidad de procesar la compra y otorgar acceso al producto digital. El usuario podrá
                        solicitar en cualquier momento la actualización o eliminación de sus datos conforme a la Ley de Protección
                        de Datos Personales.
                    </p>
                </div>

                <!-- Sección 9 -->
                <div class="mb-8">
                    <h2 class="text-xl font-bold text-gray-900 mb-4">9. MODIFICACIONES</h2>
                    <p class="text-gray-700">
                        GRUPO A&amp;T se reserva el derecho de actualizar o modificar en cualquier momento estos Términos y
                        Condiciones, los cuales estarán disponibles en el sitio web. Se recomienda revisarlos periódicamente.
                    </p>
                </div>

                <!-- Información de contacto -->
                <div class="bg-gray-50 p-6 rounded-lg mt-10">
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">¿Tienes preguntas sobre nuestros términos?</h3>
                    <p class="text-gray-700 mb-4">Contáctanos para resolver cualquier duda</p>
                    <a href="mailto:alextaya@hotmail.com" class="inline-flex items-center px-5 py-2 bg-[#ea9216] text-white font-medium rounded-lg hover:bg-[#d9820f] transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z" />
                            <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z" />
                        </svg>
                        Contactar
                    </a>
                </div>
            </div>
        </div>
    </div>

    <style>
        .prose {
            line-height: 1.7;
        }

        .prose h2 {
            margin-top: 2rem;
            margin-bottom: 1rem;
        }

        .prose p {
            margin-bottom: 1rem;
        }
        
        .prose a {
            transition: color 0.3s ease;
        }
        
        .prose strong {
            color: #052f5a;
        }
    </style>
@endsection