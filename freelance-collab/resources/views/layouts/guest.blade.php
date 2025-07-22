<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="min-h-screen flex items-center justify-center bg-gradient-to-br from-[#152C54] to-[#e0e7ef] font-sans text-gray-900 antialiased">
        <div class="flex flex-col items-center w-full">

            <div class="bg-white rounded-2xl shadow-2xl border border-[#152C54] flex flex-col md:flex-row w-full md:w-[800px] max-w-4xl md:min-h-[400px] md:h-[500px] gap-0 overflow-hidden">
                <!-- Bloc gauche accroche/visuel -->
                @yield('auth-left')
                <!-- Bloc droit formulaire -->
                <div class="flex-1 flex items-center justify-center p-8">
                    {{ $slot }}
                </div>
            </div>
        </div>
    </body>
</html>
