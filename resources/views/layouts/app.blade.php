<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100">
            @include('layouts.navigation')

            @isset($header)
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <div class="flex">

                {{-- Sidebar --}}
                <aside class="w-64 bg-white shadow-md min-h-screen p-4">
                    <ul class="space-y-2">
                        <li><a href="/appointments" class="block p-2 rounded hover:bg-blue-100">📅 Rendez-vous</a></li>
                        <li><a href="/services" class="block p-2 rounded hover:bg-blue-100">🏥 Services</a></li>
                    </ul>
                </aside>

                {{-- Contenu --}}
                <main class="flex-1 p-6">
                    @yield('content')
                </main>

            </div>

            {{-- Footer --}}
            <footer class="bg-gray-200 text-center p-4 text-sm text-gray-500">
                © 2026 Cabinet Médical
            </footer>

        </div>
    </body>
</html>