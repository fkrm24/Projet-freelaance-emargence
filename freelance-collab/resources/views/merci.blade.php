<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-2">
            <span class="text-3xl">✨</span>
            <h2 class="font-semibold text-xl text-[#152C54] leading-tight">
                {{ __('Profil enregistré') }}
            </h2>
        </div>
    </x-slot>

    <div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-[#152C54] via-[#e0e7ef] to-[#F6F8FF] -mt-32">
        <div class="bg-white rounded-2xl shadow-xl p-8 max-w-lg w-full text-center border border-[#E0E7FF]">
            <div class="mb-6 text-6xl">✨</div>
            <h1 class="text-2xl font-bold text-[#2748E9] mb-4">Merci pour votre inscription !</h1>
            <p class="text-gray-600 mb-8">Votre profil a été enregistré avec succès. Nous avons bien reçu toutes vos informations.</p>
            
            <div class="flex justify-center gap-4">
                <a href="{{ route('dashboard.menu') }}" class="bg-[#2748E9] text-white px-6 py-3 rounded-xl hover:bg-[#018FFD] transition-colors duration-300 flex items-center gap-2 shadow-md hover:shadow-lg">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 15L3 9m0 0l6-6M3 9h12a6 6 0 010 12h-3" />
                    </svg>
                    Retour au tableau de bord
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
