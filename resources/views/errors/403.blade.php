<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Acceso denegado</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100">
            @auth
                @include('layouts.navigation')
            @endauth

            <main class="mx-auto max-w-7xl px-4 py-12 sm:px-6 lg:px-8">
                <div class="rounded-xl border border-gray-200 bg-white p-10 text-center shadow-sm">
                    <p class="text-6xl font-bold text-gray-300">403</p>
                    <h1 class="mt-4 text-xl font-semibold text-gray-900">Acceso denegado</h1>
                    <p class="mt-2 text-sm text-gray-600">No tienes permisos para acceder a esta sección.</p>
                    <a href="{{ auth()->check() ? route('dashboard') : route('login') }}"
                       class="mt-6 inline-flex items-center justify-center rounded-md bg-gray-800 px-4 py-2 text-sm font-medium text-white shadow-sm transition hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-900 focus:ring-offset-2">
                        {{ auth()->check() ? 'Volver al panel' : 'Iniciar sesión' }}
                    </a>
                </div>
            </main>
        </div>
    </body>
</html>
