@extends('layouts.app')

@section('titulo', 'Políticas de Cookies')

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
                    <li class="text-[#ea9216] font-medium">Políticas de Cookies</li>
                </ol>
            </nav>

            <!-- Título principal -->
            <div class="text-center mb-8">
                <h1 class="text-2xl font-bold text-gray-900 mb-6">Políticas de Cookies</h1>
            </div>

            <!-- Contenido -->
            <div class="prose prose-lg max-w-none">
                <!-- Sección I -->
                <div class="mb-8">
                    <h2 class="text-xl font-bold text-gray-900 mb-4">I. INTRODUCCIÓN</h2>
                    <p class="text-gray-700 mb-4">
                        De conformidad con lo establecido en la Ley N° 29733, Ley de Protección de Datos Personales y su
                        Reglamento,
                        aprobado mediante Decreto Supremo N° 003-2013-JUS, <strong>GRUPO A&amp;T</strong>, con
                        <strong>RUC 10154316189</strong>, con domicilio en <strong>Urb. Libertad Mz. I Lt. 5 Calle las Moras
                            S/N San
                            Vicente - Cañete - Lima - Perú</strong> (en adelante, "GRUPO A&amp;T"), pone a disposición de
                        los
                        Usuarios la presente Política de Cookies (en adelante, la "Política").
                    </p>
                    <p class="text-gray-700 mb-4">
                        A través de la aceptación de la presente Política, el Usuario autoriza de manera libre, expresa,
                        previa e
                        informada sobre el uso de las cookies y el tratamiento de sus datos personales, obtenidos a través
                        de las cookies del
                        Sitio Web, los cuales serán almacenados en un banco de datos denominado "Usuarios de la Página Web".
                    </p>
                    <p class="text-gray-700 mb-4">
                        Al acceder al sitio web, el Usuario es libre de aceptar o no permitir a GRUPO A&amp;T el uso de las
                        cookies.
                        No obstante, algunas cookies (esenciales) son necesarias para un adecuado funcionamiento del sitio
                        web y, por
                        lo tanto, su bloqueo o eliminación pueden impactar en el uso del sitio, su idoneidad, funcionalidad
                        y la prestación de
                        los servicios.
                    </p>
                    <p class="text-gray-700 mb-4">
                        La finalidad de tratamiento es atender los requerimientos de compra y consultas; entregar productos;
                        así
                        como, con fines de calidad y mejora del servicio en el sitio web. Las cookies permiten a GRUPO
                        A&amp;T facilitar el
                        uso y navegación, proveer el acceso a determinadas funcionalidades y mejorar la calidad del sitio
                        web de acuerdo
                        con las preferencias del Usuario.
                    </p>
                    <p class="text-gray-700 mb-4">
                        GRUPO A&amp;T utiliza cookies necesarias y esenciales para que el sitio web funcione de forma
                        idónea.
                        Asimismo, se informa al Usuario que otras cookies sirven para mejorar el rendimiento y su
                        experiencia en el sitio web,
                        las cuales podrán ser aceptadas o configuradas en la sección de "Configuración de Cookies".
                    </p>
                    <p class="text-gray-700">
                        Utilizamos cookies propias y de terceros y, de ser el caso, el tratamiento de datos personales que
                        puedan
                        ser recolectados (como nombre, correo electrónico e información de contacto), puede ser objeto de
                        flujo
                        transfronterizo a servidores ubicados en el extranjero para fines de hosting y servicios en la nube.
                    </p>
                </div>

                <!-- Sección II -->
                <div class="mb-8">
                    <h2 class="text-xl font-bold text-gray-900 mb-4">II. ¿QUÉ SON LAS COOKIES?</h2>
                    <p class="text-gray-700 mb-4">
                        Las cookies son pequeños fragmentos de datos que se envían a su computadora cuando visita un sitio
                        web. En
                        visitas posteriores, estos datos permiten reconocer sus preferencias y mejorar su experiencia y
                        facilidad en el uso
                        del sitio web, lo que nos permite brindarle un mejor servicio.
                    </p>
                    <p class="text-gray-700">
                        Si su navegador web está configurado para rechazar las cookies de nuestro sitio web, no podrá
                        completar una
                        compra o aprovechar ciertas características del mismo, como almacenar artículos en su carrito de
                        compras o recibir
                        recomendaciones personalizadas. Como resultado, le recomendamos que configure su navegador web para
                        aceptar
                        cookies de nuestro sitio web.
                    </p>
                </div>

                <!-- Sección III -->
                <div class="mb-8">
                    <h2 class="text-xl font-bold text-gray-900 mb-4">III. ¿QUÉ TIPO DE COOKIES UTILIZAMOS?</h2>

                    <h3 class="text-lg font-semibold text-gray-800 mb-3">Según el tiempo de actividad:</h3>
                    <ul class="list-disc pl-6 mb-6 text-gray-700">
                        <li class="mb-2"><strong>Cookies de Sesión:</strong> se utilizan mientras el usuario navega y se
                            eliminan automáticamente
                            una vez que cierra su navegador.</li>
                        <li><strong>Cookies Persistentes o Permanentes:</strong> permanecen almacenadas en el navegador del
                            usuario
                            por un tiempo determinado, incluso después de cerrar la sesión, y permiten reconocer su
                            dispositivo
                            cuando vuelva a ingresar al sitio.</li>
                    </ul>

                    <h3 class="text-lg font-semibold text-gray-800 mb-3">Según su finalidad:</h3>
                    <ul class="list-disc pl-6 mb-6 text-gray-700">
                        <li class="mb-2"><strong>Cookies Técnicas o Necesarias:</strong> esenciales para el funcionamiento
                            básico del sitio web.</li>
                        <li class="mb-2"><strong>Cookies de Preferencias:</strong> permiten recordar configuraciones y
                            elecciones del usuario.</li>
                        <li class="mb-2"><strong>Cookies Estadísticas o de Análisis:</strong> ayudan a comprender cómo
                            interactúan los visitantes con el sitio.</li>
                        <li><strong>Cookies de Marketing:</strong> utilizadas para mostrar publicidad relevante para el
                            usuario.</li>
                    </ul>

                    <h3 class="text-lg font-semibold text-gray-800 mb-3">Según su titularidad:</h3>
                    <ul class="list-disc pl-6 text-gray-700">
                        <li class="mb-2"><strong>Cookies Propias:</strong> gestionadas directamente por GRUPO A&amp;T.
                        </li>
                        <li><strong>Cookies de Terceros:</strong> gestionadas por servicios externos que utilizamos.</li>
                    </ul>
                </div>

                <!-- Sección IV -->
                <div class="mb-8">
                    <h2 class="text-xl font-bold text-gray-900 mb-4">IV. EJERCICIO DE DERECHOS ARCO</h2>
                    <p class="text-gray-700 mb-4">
                        GRUPO A&amp;T reconoce y garantiza los derechos de acceso, rectificación, cancelación y oposición de
                        sus
                        datos personales obtenidos a través de las cookies del Sitio Web, así como la revocación de la
                        autorización
                        previamente otorgada.
                    </p>
                    <p class="text-gray-700">
                        Para ejercerlos, puede enviar un correo electrónico a:
                        <a href="mailto:alextaya@hotmail.com"
                            class="text-[#052f5a] hover:text-[#ea9216] underline">alextaya@hotmail.com</a>.
                    </p>
                </div>

                <!-- Sección V -->
                <div class="mb-8">
                    <h2 class="text-xl font-bold text-gray-900 mb-4">V. CONFIGURACIÓN DE COOKIES</h2>
                    <p class="text-gray-700 mb-4">
                        El usuario puede gestionar sus preferencias de cookies en cualquier momento a través de la
                        herramienta de
                        configuración disponible en nuestro sitio web. Puede aceptar o rechazar categorías específicas de
                        cookies,
                        excepto las cookies técnicas necesarias para el funcionamiento del sitio.
                    </p>
                    <p class="text-gray-700">
                        También puede configurar su navegador web para bloquear las cookies o recibir alertas cuando se
                        envíen
                        cookies. Consulte la sección de ayuda de su navegador para obtener instrucciones sobre cómo
                        gestionar
                        las cookies.
                    </p>
                </div>

                <!-- Información de contacto -->
                <div class="bg-gray-50 p-6 rounded-lg mt-10">
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">¿Tienes preguntas sobre nuestras cookies?</h3>
                    <p class="text-gray-700 mb-4">Contáctanos para resolver cualquier duda sobre el uso de cookies</p>
                    <a href="mailto:alextaya@hotmail.com"
                        class="inline-flex items-center px-5 py-2 bg-[#ea9216] text-white font-medium rounded-lg hover:bg-[#d9820f] transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20"
                            fill="currentColor">
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

        .prose h3 {
            margin-top: 1.5rem;
            margin-bottom: 0.75rem;
        }

        .prose p {
            margin-bottom: 1rem;
        }

        .prose ul {
            margin-bottom: 1rem;
        }

        .prose li {
            margin-bottom: 0.5rem;
        }

        .prose a {
            transition: color 0.3s ease;
        }

        .prose strong {
            color: #052f5a;
        }
    </style>
@endsection
