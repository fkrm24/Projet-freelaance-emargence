<nav class="w-full bg-[#152C54] shadow flex items-center justify-between px-8 py-4">
    <div class="flex items-center gap-3">
        <span class="text-2xl">👋</span>
        <span class="text-white font-semibold text-lg">Bienvenue</span>
        <span class="text-[#FFD700] font-bold text-lg">
            {{ Auth::user() ? Auth::user()->name : '' }}
        </span>
    </div>
    <div class="text-sm text-[#E0E7FF] italic hidden md:block">
        Ravi de vous revoir sur la plateforme freelance !
    </div>
    <form method="POST" action="{{ route('logout') }}" class="ml-4">
        @csrf
        <button type="submit" title="Déconnexion" class="flex items-center justify-center w-10 h-10 rounded-full bg-[#018FFD] hover:bg-[#FFD700] transition-colors">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="#152C54" class="w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6A2.25 2.25 0 005.25 5.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15m-6-3h12m0 0l-3-3m3 3l-3 3" />
            </svg>
        </button>
    </form>
</nav>
