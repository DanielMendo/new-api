<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bloogol</title>

    <!-- Open Graph -->
    <meta property="og:title" content="Bloogol" />
    <meta property="og:type" content="website" />
    <meta property="og:url" content="{{ url()->current() }}" />
    <meta property="og:image"
        content="https://images.unsplash.com/photo-1525026198548-4baa812f1183?q=80&w=1468&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D" />
    <meta property="og:description"
        content="Únete a la comunidad Bloogol: comparte ideas, historias y momentos inolvidables" />
    <meta property="og:site_name" content="{{ config('app.name', 'Mi Sitio') }}" />

    <!-- Styles -->
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        <script src="https://cdn.tailwindcss.com"></script>
    @endif
</head>

<body class="bg-white text-gray-800">

    <!-- Navegación -->
    <nav class="bg-white shadow">
        <div class="container mx-auto px-4 py-4 flex items-center justify-between">
            <div class="text-2xl font-bold text-gray-800">Bloogol</div>
            <div class="hidden md:flex space-x-8">
                <a href="#features" class="text-gray-700 hover:text-gray-900 font-medium">Características</a>
                <a href="#testimonios" class="text-gray-700 hover:text-gray-900 font-medium">Testimonios</a>
                <a href="#download" class="text-gray-700 hover:text-gray-900 font-medium">Descargas</a>
            </div>
            <div class="hidden md:flex items-center space-x-4">
                <a href="#" class="text-gray-700 hover:text-gray-900 font-medium">Iniciar Sesión</a>
                <a href="#"
                    class="bg-blue-500 text-white px-4 py-1 rounded-md hover:bg-blue-600 font-medium">Registrarse</a>
            </div>
            <div class="md:hidden">
                <button aria-label="Menú">
                    <svg class="w-6 h-6 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
            </div>
        </div>
    </nav>

    <!-- Hero -->
    <section class="container mx-auto px-4 py-12 flex flex-col-reverse md:flex-row items-center gap-8">
        <div class="w-full md:w-1/2 text-center md:text-left flex flex-col items-center md:items-start gap-6">
            <h1 class="text-4xl md:text-5xl font-bold text-gray-800">
                Conéctate y comparte con la comunidad de Bloogol
            </h1>
            <p class="text-gray-600 text-base md:text-lg">
                Únete a la comunidad Bloogol: comparte ideas, historias y momentos inolvidables.
                Disponible en Web y Móvil, Bloogol te mantendrá conectado donde quieras.
            </p>
            <a href="{{ url('/download') }}"
                class="bg-blue-500 text-white px-6 py-3 rounded-md hover:bg-blue-600 font-medium flex items-center space-x-2">
                <!-- Icono de descarga -->
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="size-6">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5M16.5 12 12 16.5m0 0L7.5 12m4.5 4.5V3" />
                </svg>

                <span>Descargar</span>
            </a>
        </div>
        <div class="w-full md:w-1/2 flex justify-center">
            <img src="https://images.unsplash.com/photo-1525026198548-4baa812f1183?q=80&w=1468&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D"
                alt="Bloogol" class="w-full max-w-md rounded-lg" />
        </div>
    </section>

    <!-- Características -->
    <section class="bg-gray-50 py-12" id="features">
        <div class="container mx-auto px-4 text-center">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-800 mb-4">
                Todo lo que necesitas para conectarte con la comunidad
            </h2>
            <p class="text-gray-600 max-w-2xl mx-auto">
                Bloogol combina las mejores características de las redes sociales.
                Tienes todo lo necesario para conocer y compartir tus mejores momentos con todo el mundo.
            </p>
        </div>
    </section>

    <!-- Tarjetas de características -->
    <section class="container mx-auto px-4 py-12 grid grid-cols-1 md:grid-cols-3 gap-8">
        <!-- Tarjeta 1 -->
        <div class="bg-white border border-gray-200 rounded-lg shadow-sm p-6 text-center">
            <div class="flex justify-center mb-4">
                <svg class="w-8 h-8 text-blue-600" fill="currentColor" viewBox="0 0 16 16">
                    <path fill-rule="evenodd"
                        d="M2 3.75A.75.75 0 0 1 2.75 3h10.5a.75.75 0 0 1 0 1.5H2.75A.75.75 0 0 1 2 3.75ZM2 8a.75.75 0 0 1 .75-.75h4.5a.75.75 0 0 1 0 1.5h-4.5A.75.75 0 0 1 2 8Zm0 4.25a.75.75 0 0 1 .75-.75h10.5a.75.75 0 0 1 0 1.5H2.75a.75.75 0 0 1-.75-.75Z"
                        clip-rule="evenodd" />
                </svg>
            </div>
            <h3 class="text-2xl font-semibold text-gray-900 mb-2">Posts Comunitarios</h3>
            <p class="text-gray-500">Comparte posts, fotos y mantente actualizado con la comunidad.</p>
        </div>

        <!-- Tarjeta 2 -->
        <div class="bg-white border border-gray-200 rounded-lg shadow-sm p-6 text-center">
            <div class="flex justify-center mb-4">
                <svg class="w-8 h-8 text-blue-600" fill="currentColor" viewBox="0 0 16 16">
                    <path
                        d="M3.6 1.7A.75.75 0 1 0 2.4.799a6.978 6.978 0 0 0-1.123 2.247.75.75 0 1 0 1.44.418c.187-.644.489-1.24.883-1.764ZM13.6.799a.75.75 0 1 0-1.2.9 5.48 5.48 0 0 1 .883 1.765.75.75 0 1 0 1.44-.418A6.978 6.978 0 0 0 13.6.799Z" />
                    <path fill-rule="evenodd"
                        d="M8 1a4 4 0 0 1 4 4v2.379c0 .398.158.779.44 1.06l1.267 1.268a1 1 0 0 1 .293.707V11a1 1 0 0 1-1 1h-2a3 3 0 1 1-6 0H3a1 1 0 0 1-1-1v-.586a1 1 0 0 1 .293-.707L3.56 8.44A1.5 1.5 0 0 0 4 7.38V5a4 4 0 0 1 4-4Zm0 12.5A1.5 1.5 0 0 1 6.5 12h3A1.5 1.5 0 0 1 8 13.5Z"
                        clip-rule="evenodd" />
                </svg>
            </div>
            <h3 class="text-2xl font-semibold text-gray-900 mb-2">Notificaciones Inteligentes</h3>
            <p class="text-gray-500">Mantente actualizado con las noticias más importantes y relevantes para ti.</p>
        </div>

        <!-- Tarjeta 3 -->
        <div class="bg-white border border-gray-200 rounded-lg shadow-sm p-6 text-center">
            <div class="flex justify-center mb-4">
                <svg class="w-8 h-8 text-blue-600" fill="currentColor" viewBox="0 0 16 16">
                    <path
                        d="M13.488 2.513a1.75 1.75 0 0 0-2.475 0L6.75 6.774a2.75 2.75 0 0 0-.596.892l-.848 2.047a.75.75 0 0 0 .98.98l2.047-.848a2.75 2.75 0 0 0 .892-.596l4.261-4.262a1.75 1.75 0 0 0 0-2.474Z" />
                    <path
                        d="M4.75 3.5c-.69 0-1.25.56-1.25 1.25v6.5c0 .69.56 1.25 1.25 1.25h6.5c.69 0 1.25-.56 1.25-1.25V9A.75.75 0 0 1 14 9v2.25A2.75 2.75 0 0 1 11.25 14h-6.5A2.75 2.75 0 0 1 2 11.25v-6.5A2.75 2.75 0 0 1 4.75 2H7a.75.75 0 0 1 0 1.5H4.75Z" />
                </svg>
            </div>
            <h3 class="text-2xl font-semibold text-gray-900 mb-2">Feed Personalizado</h3>
            <p class="text-gray-500">Sigue a las personas que te interesan y personaliza tu experiencia.</p>
        </div>
    </section>

    <!-- Testimonios -->
    <section class="bg-gray-100 py-12" id="testimonios">
        <div class="container mx-auto px-4 text-center">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-800 mb-10">Lo que dicen nuestros usuarios</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Testimonio 1 -->
                <div class="bg-white p-6 rounded-lg shadow-md flex flex-col items-center text-center">
                    <img class="w-20 h-20 rounded-full mb-4 object-cover"
                        src="https://randomuser.me/api/portraits/men/32.jpg" alt="Usuario 1">
                    <h3 class="text-xl font-semibold text-gray-800">Carlos Méndez</h3>
                    <p class="text-gray-600 mt-2">"Bloogol me ayudó a conectar con personas increíbles y compartir mis
                        ideas con facilidad."</p>
                </div>

                <!-- Testimonio 2 -->
                <div class="bg-white p-6 rounded-lg shadow-md flex flex-col items-center text-center">
                    <img class="w-20 h-20 rounded-full mb-4 object-cover"
                        src="https://randomuser.me/api/portraits/women/44.jpg" alt="Usuario 2">
                    <h3 class="text-xl font-semibold text-gray-800">María López</h3>
                    <p class="text-gray-600 mt-2">"Una comunidad maravillosa. El diseño es limpio y fácil de usar, ¡me
                        encanta!"</p>
                </div>

                <!-- Testimonio 3 -->
                <div class="bg-white p-6 rounded-lg shadow-md flex flex-col items-center text-center">
                    <img class="w-20 h-20 rounded-full mb-4 object-cover"
                        src="https://randomuser.me/api/portraits/men/75.jpg" alt="Usuario 3">
                    <h3 class="text-xl font-semibold text-gray-800">Luis Hernández</h3>
                    <p class="text-gray-600 mt-2">"Perfecto para compartir mis proyectos y recibir retroalimentación de
                        otros usuarios."</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Descarga -->
    <section id="download" class="py-12">
        <div class="container mx-auto px-4 text-center">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-800 mb-4">
                ¡Lleva Bloogol contigo!
            </h2>
            <p class="text-gray-600 max-w-2xl mx-auto mb-6">
                Descarga nuestra aplicación y mantente conectado desde cualquier lugar.
                Disponible pronto para Android y iOS.
            </p>
            <div class="flex flex-col md:flex-row items-center justify-center gap-4">
                <a href="{{ url('/download') }}"
                    class="bg-blue-600 text-white px-6 py-3 rounded-md hover:bg-blue-700 font-medium flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="w-5 h-5 fill-white">
                        <path
                            d="M6 18c0 .55.45 1 1 1h1v3.5c0 .83.67 1.5 1.5 1.5s1.5-.67 1.5-1.5V19h2v3.5c0 .83.67 1.5 1.5 1.5s1.5-.67 1.5-1.5V19h1c.55 0 1-.45 1-1V8H6v10zM3.5 8C2.67 8 2 8.67 2 9.5v7c0 .83.67 1.5 1.5 1.5S5 17.33 5 16.5v-7C5 8.67 4.33 8 3.5 8zm17 0c-.83 0-1.5.67-1.5 1.5v7c0 .83.67 1.5 1.5 1.5s1.5-.67 1.5-1.5v-7c0-.83-.67-1.5-1.5-1.5zm-4.97-5.84l1.3-1.3c.2-.2.2-.51 0-.71-.2-.2-.51-.2-.71 0l-1.48 1.48C13.85 1.23 12.95 1 12 1c-.96 0-1.86.23-2.66.63L7.85.15c-.2-.2-.51-.2-.71 0-.2.2-.2.51 0 .71l1.31 1.31C7.06 3.36 6 5.09 6 7h12c0-1.91-1.06-3.64-2.47-4.84zM10 5H9V4h1v1zm5 0h-1V4h1v1z" />
                    </svg>
                    Descargar para Android
                </a>
                <a href="#"
                    class="bg-gray-800 text-white px-6 py-3 rounded-md hover:bg-gray-900 font-medium flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512" class="w-5 h-5 fill-white">
                        <path
                            d="M318.7 268.6c-.3-52.3 42.6-77.5 44.6-78.7-24.3-35.5-61.9-40.4-75.3-41-32-3.3-62.3 18.8-78.4 18.8s-40.7-18.3-66.9-17.8c-34.4.5-66.2 20.1-83.8 51.1-35.8 62.1-9.1 153.7 25.7 204.1 17.1 24.8 37.4 52.7 64 51.6 25.4-1 35-16.5 65.6-16.5s39.3 16.5 66.1 16 43.1-25.2 59.1-50.1c18.5-27 26.1-53.3 26.4-54.6-.6-.2-50.7-19.4-51-76.9zM261.4 96.4c14.2-17.2 23.8-41.2 21.2-65.4-20.5.8-45.4 13.6-60.3 30.9-13.2 15.4-24.6 39.9-21.5 63.3 22.7 1.7 46.2-11.6 60.6-28.8z" />
                    </svg>
                    Descargar para iOS
                </a>
            </div>
        </div>
    </section>


    <!-- Footer -->
    <footer class="bg-white border-t border-gray-200 mt-12">
        <div
            class="container mx-auto px-4 py-8 flex flex-col md:flex-row justify-between items-center text-center md:text-left">
            <p class="text-gray-600">&copy; 2025 Bloogol. Todos los derechos reservados.</p>
            <div class="flex space-x-4 mt-4 md:mt-0">
                <a href="#" class="text-gray-500 hover:text-gray-700">Privacidad</a>
                <a href="#" class="text-gray-500 hover:text-gray-700">Términos</a>
                <a href="#" class="text-gray-500 hover:text-gray-700">Contacto</a>
            </div>
        </div>
    </footer>
</body>

</html>
