<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>{{ $post->title }}</title>

    <!-- Open Graph -->
    <meta property="og:title" content="{{ $post->title }}" />
    <meta property="og:type" content="article" />
    <meta property="og:url" content="{{ url()->current() }}" />
    @if ($post->image)
        <meta property="og:image" content="{{ $post->image }}" />
    @endif
    <meta property="og:description" content="{{ Str::limit(strip_tags($post->content), 150) }}" />
    <meta property="og:site_name" content="{{ config('app.name', 'Mi Sitio') }}" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-50 min-h-screen flex items-center justify-center p-6">
    <div class="max-w-3xl w-full bg-white rounded-lg shadow-lg p-8">
        <!-- Título -->
        <h1 class="text-4xl font-extrabold text-gray-900 mb-6">
            {{ $post->title }}
        </h1>

        <!-- Imagen -->
        @if ($post->image)
            <img src="{{ $post->image }}" alt="Imagen del post" class="w-full h-auto rounded-md mb-8" />
        @endif

        <!-- Contenido -->
        <div class="prose max-w-none text-gray-800">
            {!! nl2br(e($post->content)) !!}
        </div>
    </div>
</body>

</html>
