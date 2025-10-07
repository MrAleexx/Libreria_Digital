@extends('layouts.app')

@section('titulo', 'Políticas de Privacidad')

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
                    <li class="text-[#ea9216] font-medium">Políticas de Privacidad</li>
                </ol>
            </nav>

            <!-- Título principal -->
            <div class="text-center mb-8">
                <h1 class="text-2xl font-bold text-gray-900 mb-6">Políticas de Privacidad</h1>
            </div>
            <!-- Contenido -->
            <div class="prose prose-lg max-w-none">
                <p class="text-gray-700 mb-6">
                    La presente Política de Privacidad establece los términos y condiciones que rigen el uso de la
                    información
                    personal que usted nos proporciona a través de este sitio web. Al aceptar la presente Política de
                    Privacidad, se considerará que usted ha brindado adecuadamente su consentimiento para que <strong>GRUPO
                        A&amp;T</strong>, con <strong>RUC 10154316189</strong> y con dirección en <strong>Urb. Libertad Mz.
                        I
                        Lt. 5 Calle las Moras S/N San Vicente - Cañete - Lima - Perú</strong>, en adelante “GRUPO A&amp;T”,
                    pueda realizar el tratamiento de su información bajo los siguientes términos y condiciones:
                </p>

                <!-- Sección 1 -->
                <div class="mb-8">
                    <h2 class="text-xl font-bold text-gray-900 mb-4">1. ¿Qué información recopilamos?</h2>
                    <p class="text-gray-700 mb-4">
                        Recolectamos información personal por medio de formularios virtuales contenidos en nuestra página
                        web. Esta información será almacenada en nuestro banco de datos denominado "Clientes"; "Libro de
                        Reclamaciones" o "Usuarios del sitio web", según sea el caso.
                    </p>
                    <p class="text-gray-700">
                        Nuestros bancos de datos se encuentran debidamente informados ante la Autoridad Nacional de
                        Protección de Datos Personales, según lo exige la normativa vigente actualmente. Su información
                        personal será almacenada por un término de 10 años o hasta que usted solicite su cancelación.
                    </p>
                </div>

                <!-- Sección 2 -->
                <div class="mb-8">
                    <h2 class="text-xl font-bold text-gray-900 mb-4">2. Consentimiento</h2>
                    <p class="text-gray-700">
                        GGRUPO A&amp;T requiere del consentimiento libre, previo, expreso, inequívoco e informado del
                        titular de los
                        datos personales para el tratamiento de los mismos, salvo en los casos de excepción expresamente
                        establecidos por Ley. GRUPO A&amp;T no requiere consentimiento para tratar sus datos personales
                        obtenidos de
                        fuentes accesibles al público, gratuitas o no; así mismo, podrá tratar sus datos personales o de
                        fuentes no
                        públicas, siempre que dichas fuentes cuenten con su consentimiento para tratar y transferir dichos
                        datos
                        personales.
                    </p>
                    <p class="text-gray-700">
                        En caso no se proporcione el consentimiento para el tratamiento de sus datos
                        personales o, de ser el
                        caso, se
                        revoque o cancele dicho consentimiento, GRUPO A&amp;T no podrá prestar los servicios solicitados o
                        seguir
                        prestándolos, según sea el caso. Ello sin perjuicio de poder completar el servicio solicitado de
                        forma
                        previa a la cancelación o revocación o en caso alguna autoridad o Ley requiera su conservación.</p>
                </div>

                <!-- Sección 3 -->
                <div class="mb-8">
                    <h2 class="text-xl font-bold text-gray-900 mb-4">3. Finalidad del Tratamiento de Datos</h2>
                    <p class="text-gray-700">
                        (i.)Registrarse como usuario de nuestra página web.
                        (ii.)Comprar artículos ofrecidos en nuestra
                        página web y
                        gestionar sus compras.
                        (iii.)Establecer un canal de comunicación con usted.
                        (iv.)Atender sus
                        consultas,
                        reclamos y sugerencias.
                    </p>
                </div>

                <!-- Sección 4 -->
                <div class="mb-8">
                    <h2 class="text-xl font-bold text-gray-900 mb-4">4. Seguridad de la Información</h2>
                    <p class="text-gray-700">
                        GRUPO A&amp;T cuenta con medidas técnicas, legales y organizacionales necesarias para garantizar la
                        seguridad y confidencialidad de sus datos personales; así como para evitar cualquier manipulación
                        indebida, pérdida accidental, destrucción o acceso no autorizado de terceros. Su información no será
                        vendida, transferida ni compartida sin su autorización y para fines ajenos a los que se describen en
                        esta política.
                    </p>
                </div>

                <!-- Sección 5 -->
                <div class="mb-8">
                    <h2 class="text-xl font-bold text-gray-900 mb-4">5. Derechos del Titular</h2>
                    <p class="text-gray-700 mb-4">
                        GRUPO A&amp;T reconoce y garantiza el ejercicio de los derechos de acceso, rectificación,
                        cancelación, oposición, información o revocación que por ley le asisten. Para tal fin, puede dirigir
                        un correo electrónico a: <a href="mailto:alextaya@hotmail.com">alextaya@hotmail.com</a>.
                    </p>
                    <p class="text-gray-700">
                        El ejercicio de estos derechos es gratuito y será atendido en un plazo máximo de 20 días hábiles.
                    </p>
                </div>

                <!-- Sección 6 -->
                <div class="mb-8">
                    <h2 class="text-xl font-bold text-gray-900 mb-4">6. Transferencia Internacional de Datos</h2>
                    <p class="text-gray-700">
                        GRUPO A&amp;T trata su información de forma directa o por medio de terceros designados por éste.
                        Usted nos autoriza a que podamos compartir y encargar el tratamiento de su información personal a
                        terceros que nos prestan servicios para mejorar nuestras actividades. En estos casos, GRUPO A&amp;T
                        garantizará que el tratamiento de sus datos se limite a las finalidades antes autorizadas, que se
                        mantenga confidencial y se implementen las medidas de seguridad adecuadas.
                    </p>
                </div>

                <!-- Sección 7 -->
                <div class="mb-8">
                    <h2 class="text-xl font-bold text-gray-900 mb-4">7. Modificaciones a la Política</h2>
                    <p class="text-gray-700">
                        GRUPO A&T se reserva el derecho de modificar la presente Política de Privacidad para adaptarla a
                        novedades legislativas o jurisprudenciales. Cualquier modificación será publicada en esta página web
                        con antelación a su entrada en vigor.
                    </p>
                </div>

                <!-- Información de contacto -->
                <div class="bg-gray-50 p-6 rounded-lg mt-10">
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Para ejercer sus derechos ARCO</h3>
                    <p class="text-gray-700 mb-1">Puede contactarnos a través de:</p>
                    <p class="text-gray-700">- Nuestro Libro de Reclamaciones virtual</p>
                    <p class="text-gray-700">- Correo electrónico: heldesk@GrupoA&T.com</p>
                    <p class="text-gray-700">- Teléfono: (01) 123-4567</p>
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
        </style>
    @endsection
