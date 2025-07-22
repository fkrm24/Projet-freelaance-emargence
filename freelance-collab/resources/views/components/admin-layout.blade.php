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
<body class="font-sans antialiased">
    <div class="min-h-screen bg-[#F6F8FF]">
        <!-- Navigation -->
        <nav class="bg-white shadow-sm">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex flex-col items-center py-4">
                    <div class="flex items-center justify-center w-full">
                        <span class="text-xl font-bold text-[#152C54] mr-2">Bienvenue, {{ Auth::user()->name }} !</span>
                        <form method="POST" action="{{ route('logout') }}" class="ml-auto">
                            @csrf
                            <button type="submit" title="Déconnexion" class="ml-4 text-[#2748E9] hover:text-red-600 transition-colors text-2xl">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-7 h-7 inline">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a2 2 0 01-2 2H7a2 2 0 01-2-2V7a2 2 0 012-2h6a2 2 0 012 2v1" />
                                </svg>
                            </button>
                        </form>
                    </div>
                    <div class="mt-1 text-center w-full">
                        <span class="text-sm text-gray-500">Vous êtes sur l'espace administration de la plateforme.</span>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Page Content -->
        <div class="flex">
            <!-- Sidebar -->
            <aside class="w-64 lg:w-72 h-screen sticky top-0 flex-shrink-0 flex flex-col items-center py-10 px-4 lg:px-6 border-r border-[#E0E7FF] bg-gradient-to-b from-[#E0E7FF] to-[#152C54]/10 z-10">
                <div class="mb-2">
                    <img src="{{ asset('images/emargence-logo.jpeg') }}" alt="logo Émargence" class="w-28 h-28 rounded-full shadow-lg bg-white object-contain" />
                </div>
                <div class="flex flex-col gap-6 w-full mt-6">
                    @if(isset($sidebarContactsCount))
                    <div class="p-4 bg-[#e0e7ef] rounded-xl shadow-sm">
                        <h3 class="text-[#152C54] font-bold mb-2">Statistiques</h3>
                        <div class="bg-white p-3 rounded-lg shadow-sm flex items-center gap-3">
                            <span class="text-2xl">👥</span>
                            <div>
                                <p class="text-sm text-gray-500 mb-0">Contacts</p>
                                <p class="text-2xl font-bold text-[#152C54]">{{ $sidebarContactsCount }}</p>
                            </div>
                        </div>
                    </div>
                    @elseif(isset($sidebarSocietesCount))
                    <div class="p-4 bg-[#e0e7ef] rounded-xl shadow-sm">
                        <h3 class="text-[#152C54] font-bold mb-2">Statistiques</h3>
                        <div class="bg-white p-3 rounded-lg shadow-sm flex items-center gap-3">
                            <span class="text-2xl">🏢</span>
                            <div>
                                <p class="text-sm text-gray-500 mb-0">Sociétés</p>
                                <p class="text-2xl font-bold text-[#152C54]">{{ $sidebarSocietesCount }}</p>
                            </div>
                        </div>
                    </div>
                    @endif
                    <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2 p-4 {{ request()->routeIs('admin.dashboard') ? 'bg-[#152C54] text-white' : 'bg-white text-[#152C54]' }} rounded-xl hover:bg-[#2748E9] hover:text-white transition-colors">
                        <span class="text-xl">🏠</span> Dashboard
                    </a>
                    <a href="{{ route('admin.societes.index') }}" class="flex items-center gap-2 p-4 {{ request()->routeIs('admin.societes.index') ? 'bg-[#152C54] text-white' : 'bg-white text-[#152C54]' }} rounded-xl hover:bg-[#2748E9] hover:text-white transition-colors">
                        <span class="text-xl">🏢</span> Sociétés
                    </a>
                    <a href="{{ route('admin.contacts.index') }}" class="flex items-center gap-2 p-4 {{ request()->routeIs('admin.contacts.index') ? 'bg-[#152C54] text-white' : 'bg-white text-[#152C54]' }} rounded-xl hover:bg-[#2748E9] hover:text-white transition-colors">
                        <span class="text-xl">👥</span> Contacts
                    </a>
                    <a href="{{ route('admin.export-csv') }}" class="flex items-center gap-2 p-4 bg-[#152C54] text-white rounded-xl hover:bg-[#2748E9] transition-colors">
                        <span class="text-xl">📊</span> Exporter en CSV
                    </a>
                </div>
            </aside>

            <!-- Main Content -->
            <main class="flex-1 p-4">
                @if (isset($header))
                    <header class="bg-white shadow">
                        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                            {{ $header }}
                        </div>
                    </header>
                @endif

                {{ $slot }}
            </main>
        </div>
    </div>

    @stack('scripts')
</body>
</html>
