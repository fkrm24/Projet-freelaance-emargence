@extends('layouts.app')

@section('content')
<style>
    body {
        background: url('{{ asset('images/fondecran.png') }}') no-repeat center center fixed !important;
        background-size: cover !important;
    }
    .glass-card {
        background: rgba(255,255,255,0.70);
        border-radius: 2rem;
        box-shadow: 0 8px 32px 0 rgba(31,38,135,0.18);
        backdrop-filter: blur(8px);
        -webkit-backdrop-filter: blur(8px);
        border: 1.5px solid rgba(255,255,255,0.28);
        padding: 2.5rem 2.5rem 2rem 2.5rem;
        max-width: 520px;
        width: 100%;
        animation: fadeInUp 1s cubic-bezier(.23,1.02,.32,1) 0s 1;
    }
    @keyframes fadeInUp {
        0% { opacity: 0; transform: translateY(30px); }
        100% { opacity: 1; transform: translateY(0); }
    }
    .dashboard-menu-title {
        color: #152C54;
        background: transparent;
        border-radius: 1rem;
        padding: 0;
        margin-bottom: 1.5rem;
        font-size: 2rem;
        font-weight: 700;
        letter-spacing: .01em;
        text-align: center;
        text-shadow: 0 2px 8px rgba(21,44,84,0.07);
    }
    .dashboard-menu-btn-square {
        width: 230px;
        height: 120px;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        text-align: center;
        font-size: 1.12rem;
        border-radius: 1.1rem;
        margin-bottom: 0;
        box-shadow: 0 2px 8px rgba(21,44,84,0.10);
        transition: transform 0.18s, box-shadow 0.18s, background 0.18s;
        background: #fff;
        color: #152C54;
        font-weight: 600;
        border: none;
        position: relative;
        overflow: hidden;
    }
    .dashboard-menu-btn-square svg {
        width: 2.1rem;
        height: 2.1rem;
        margin-bottom: .5rem;
        opacity: 0.92;
    }
    .dashboard-menu-btn-square:hover {
        background: #018FFD;
        color: #fff;
        transform: translateY(-6px) scale(1.045);
        box-shadow: 0 12px 32px rgba(1,143,253,0.18);
    }
    .dashboard-menu-btn-square:hover svg {
        filter: drop-shadow(0 2px 4px #fff8);
        opacity: 1;
    }
    .dashboard-menu-success {
        background: #d1fae5;
        color: #065f46;
        padding: 1rem 2rem;
        border-radius: .5rem;
        margin-bottom: 1.5rem;
        font-weight: 500;
        box-shadow: 0 1px 4px rgba(21,44,84,0.05);
        text-align: center;
    }
    @media (max-width: 640px) {
        .glass-card { padding: 1.2rem 0.5rem 1.5rem 0.5rem; }
        .dashboard-menu-btn-square {
            width: 100%;
            height: 80px;
            font-size: 1rem;
        }
        .flex.flex-row.gap-8.mt-4.w-full.justify-center {
            flex-direction: column;
            gap: 1.5rem;
            align-items: center;
        }
    }
</style>
<div class="w-full flex flex-col items-center bg-gradient-to-r from-[#152C54] to-[#018FFD] py-10 mb-8 shadow-lg">
    <div class="flex items-center gap-4">
        <span class="text-4xl">🌟</span>
        <span class="text-white text-3xl font-extrabold tracking-wide drop-shadow">Votre avenir commence ici</span>
    </div>
    <div class="text-[#FFD700] mt-3 text-lg font-semibold drop-shadow">Plateforme Emargence - Candidature Simplifiée</div>
</div>
<div class="flex flex-col items-center justify-center min-h-[65vh]">
    <div class="glass-card">
        <h1 class="dashboard-menu-title">Bienvenue sur votre espace candidat</h1>
        @if(session('success'))
            <div class="dashboard-menu-success">{{ session('success') }}</div>
        @endif
        <div class="flex flex-row gap-8 mt-6 w-full justify-center">
            <a href="{{ route('dashboard.menu', ['mode' => 'edit']) }}" class="dashboard-menu-btn-square group">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M15.232 5.232l3.536 3.536M9 11l6 6M3 21h18" stroke-linecap="round" stroke-linejoin="round"/><path d="M12 20h9" stroke-linecap="round" stroke-linejoin="round"/></svg>
                Mettre à jour<br>votre candidature
            </a>
            <a href="{{ route('dashboard.menu', ['mode' => 'create']) }}" class="dashboard-menu-btn-square group" style="background:#018FFD;color:#fff;">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M12 4v16m8-8H4" stroke-linecap="round" stroke-linejoin="round"/></svg>
                Nouvelle<br>candidature
            </a>
        </div>
    </div>
</div>
<footer class="w-full mt-16 py-4 bg-[#152C54] text-[#FFD700] text-center text-xs tracking-wider shadow-inner opacity-90">
    © 2025 Emargence | Plateforme dédiée aux talents et à l’innovation
</footer>
@endsection
