<x-app-layout>
@php
    $mode = $mode ?? 'create';
@endphp
    @push('styles')
    <link href="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/css/tom-select.css" rel="stylesheet">
    <style>
        .ts-wrapper {
            min-height: 42px;
        }
        .ts-control {
            background-color: #F6F8FF !important;
            border-color: #152C54 !important;
        }
        .ts-control:focus {
            border-color: #152C54 !important;
            box-shadow: 0 0 0 2px rgba(21, 44, 84, 0.2) !important;
        }
        .ts-dropdown {
            border-radius: 0.375rem;
        }
        .ts-dropdown .optgroup-header {
            background: #f3f4f6;
            font-weight: 600;
            color: #152C54;
            display: flex;
            justify-content: space-between;
            align-items: center;
            cursor: pointer;
        }
        .ts-dropdown .optgroup-header .select-all {
            font-size: 0.8em;
            padding: 2px 6px;
            border-radius: 4px;
            background: #152C54;
            color: white;
            margin-left: 8px;
        }
        .ts-dropdown .option {
            padding-left: 1.5rem;
        }
        /* Scrollbar bleu foncé pour la liste d'expertises */
        .col-span-8::-webkit-scrollbar {
            width: 10px;
        }
        .col-span-8::-webkit-scrollbar-thumb {
            background: #152C54;
            border-radius: 6px;
        }
        .col-span-8::-webkit-scrollbar-track {
            background: #e0e7ef;
        }
        /* Firefox */
        .col-span-8 {
            scrollbar-color: #152C54 #e0e7ef;
            scrollbar-width: thin;
        }
        /* Champs de formulaire */
        input[type="text"], input[type="email"], input[type="tel"], input[type="password"], input[type="date"], input[type="file"], input[type="number"], input[type="url"], select, textarea {
            background-color: #fff !important;
            border-color: #152C54 !important;
            color: #152C54 !important;
        }
        /* Titres des champs du formulaire */
        label {
            color: #fff !important;
        }
        input[type="text"]:focus, input[type="email"]:focus, input[type="tel"]:focus, input[type="password"]:focus, select:focus, textarea:focus {
            border-color: #152C54 !important;
            box-shadow: 0 0 0 2px rgba(21, 44, 84, 0.2) !important;
        }
        /* Boutons principaux du formulaire */
        button[type="submit"], .main-btn {
            background-color: #152C54 !important;
            color: #fff !important;
            border: none !important;
        }
        button[type="submit"]:hover, .main-btn:hover {
            background-color: #152C54 !important;
        }
        /* Sidebar - boutons */
        .sidebar-step {
            background-color: #152C54 !important;
            color: #fff !important;
        }
        .sidebar-step *,
        .sidebar-step span,
        .sidebar-step div {
            color: #fff !important;
        }
        .sidebar-step .text-xs {
            color: #e0e7ef !important;
        }
        .sidebar-step .group-[.active]:text-[#018FFD] {
            color: #fff !important;
        }
    </style>
    @endpush

    <x-slot name="header">
        <div class="flex items-center gap-2">
            <span class="text-3xl">📝</span>
            <h2 class="font-semibold text-xl text-[#152C54] leading-tight">
                {{ __('Profil Freelance') }}
            </h2>
        </div>
    </x-slot>
    <div class="flex min-h-screen w-full bg-gradient-to-br from-[#152C54] via-[#e0e7ef] to-[#F6F8FF]">
    <!-- Sidebar sticky à gauche -->
    <aside class="w-72 h-screen sticky top-0 flex flex-col items-center py-10 px-6 border-r border-[#E0E7FF] bg-gradient-to-b from-[#E0E7FF] to-[#F6F8FF] z-10">
        <div class="mb-2">
            <img src="/images/emargence-logo.jpeg" alt="logo emargence" class="w-28 h-28 rounded-full shadow-lg bg-white" />
        </div>
        <div class="flex flex-col gap-6 w-full mt-6">
            <div id="step1Sidebar" class="sidebar-step group flex items-center gap-3 p-3 rounded-xl cursor-pointer font-bold transition-all duration-200 shadow-sm hover:bg-[#e7edff] relative">
                <span class="flex items-center justify-center w-8 h-8 rounded-full bg-gradient-to-br from-[#2748E9] to-[#018FFD] text-white group-[.active]:scale-110 transition-all">1</span>
                <div>
                    <div class="text-[#2748E9] group-[.active]:text-[#018FFD]">Profil personnel</div>
                    <div class="text-xs text-gray-500 font-normal">Identité et contact</div>
                </div>
            </div>
            <div id="step2Sidebar" class="sidebar-step group flex items-center gap-3 p-3 rounded-xl cursor-pointer transition-all duration-200 shadow-sm hover:bg-[#e7edff] relative">
                <span class="flex items-center justify-center w-8 h-8 rounded-full bg-gradient-to-br from-[#E0E7FF] to-[#2748E9] text-[#2748E9] group-[.active]:bg-gradient-to-br group-[.active]:from-[#2748E9] group-[.active]:to-[#018FFD] group-[.active]:text-white transition-all">2</span>
                <div>
                    <div class="text-[#152C54] group-[.active]:text-[#018FFD]">Profil professionnel</div>
                    <div class="text-xs text-gray-500 font-normal">Compétences & CV</div>
                </div>
            </div>

            <div id="step3Sidebar" class="sidebar-step group flex items-center gap-3 p-3 rounded-xl cursor-pointer transition-all duration-200 shadow-sm hover:bg-[#e7edff] relative">
                <span class="flex items-center justify-center w-8 h-8 rounded-full bg-gradient-to-br from-[#E0E7FF] to-[#2748E9] text-[#2748E9] group-[.active]:bg-gradient-to-br group-[.active]:from-[#2748E9] group-[.active]:to-[#018FFD] group-[.active]:text-white transition-all">3</span>
                <div>
                    <div class="text-[#152C54] group-[.active]:text-[#018FFD]">Type d'expertise</div>
                    <div class="text-xs text-gray-500 font-normal">Domaine d'expertise</div>
                </div>
            </div>

            <div id="step4Sidebar" class="sidebar-step group flex items-center gap-3 p-3 rounded-xl cursor-pointer transition-all duration-200 shadow-sm hover:bg-[#e7edff] relative">
                <span class="flex items-center justify-center w-8 h-8 rounded-full bg-gradient-to-br from-[#E0E7FF] to-[#2748E9] text-[#2748E9] group-[.active]:bg-gradient-to-br group-[.active]:from-[#2748E9] group-[.active]:to-[#018FFD] group-[.active]:text-white transition-all">4</span>
                <div>
                    <div class="text-[#152C54] group-[.active]:text-[#018FFD]">Compétences</div>
                    <div class="text-xs text-gray-500 font-normal">Outils & Technologies</div>
                </div>
            </div>
            <div id="step5Sidebar" class="sidebar-step group flex items-center gap-3 p-3 rounded-xl cursor-pointer transition-all duration-200 shadow-sm hover:bg-[#e7edff] relative">
                <span class="flex items-center justify-center w-8 h-8 rounded-full bg-gradient-to-br from-[#E0E7FF] to-[#2748E9] text-[#2748E9] group-[.active]:bg-gradient-to-br group-[.active]:from-[#2748E9] group-[.active]:to-[#018FFD] group-[.active]:text-white transition-all">5</span>
                <div>
                    <div class="text-[#152C54] group-[.active]:text-[#018FFD]">Expériences & Références</div>
                    <div class="text-xs text-gray-500 font-normal">Ajoutez vos contacts</div>
                </div>
            </div>
        </div>
        <div class="flex-1"></div>
        <div class="text-xs text-gray-500 italic text-center mt-8">“Le succès n’est pas la clé du bonheur. Le bonheur est la clé du succès.”</div>
    </aside>
    <div class="flex-1 flex flex-col min-h-screen p-0 md:p-12 bg-white overflow-x-auto">
        <div class="w-full max-w-6xl mx-auto flex-1 flex flex-col justify-center">
            <div class="flex-1 p-8 rounded-2xl relative bg-gradient-to-br from-[#152C54] via-[#e0e7ef] to-[#F6F8FF]">
                
                <form method="POST" action="{{ $mode === 'edit' ? route('profil.submit', ['mode' => 'edit']) : route('profil.submit', ['mode' => 'create']) }}" enctype="multipart/form-data" id="profilForm">
                    @csrf
                    @if($mode === 'edit' && isset($profil) && $profil)
                        <input type="hidden" name="profil_id" value="{{ $profil->id }}">
                    @endif
                    <input type="hidden" name="mode" value="{{ $mode }}">
                    @if ($errors->any())
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                            <strong class="font-bold">Erreur!</strong>
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <!-- Étape 1 : Profil personnel -->
                    <div id="step1" class="step">
                        <div class="w-full bg-white rounded-lg shadow flex items-center px-6 py-3 mb-6">
    <span class="text-2xl mr-3">👤</span>
    <h3 class="text-xl font-bold text-[#152C54] m-0">Profil personnel</h3>
</div>
                        <p class="text-sm font-bold text-white mb-6">Complétez vos informations personnelles</p>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                                <div>
                                    <label for="nom" class="block text-sm font-medium text-gray-700 mb-1">Nom</label>
                                    <input type="text" name="nom" id="nom" value="{{ old('nom', $profil?->nom) }}" class="w-full rounded-md border-gray-300 bg-[#E0E7FF] focus:border-[#2748E9] focus:ring-2 focus:ring-[#2748E9]">
<div class="text-red-500 text-xs mt-1 error-message"></div>
                                    <x-input-error :messages="$errors->get('nom')" class="mt-2" />
                                </div>
                                <div>
                                    <label for="prenom" class="block text-sm font-medium text-gray-700 mb-1">Prénom</label>
                                    <input type="text" name="prenom" id="prenom" value="{{ old('prenom', $profil?->prenom) }}" class="w-full rounded-md border-gray-300 bg-[#E0E7FF] focus:border-[#2748E9] focus:ring-2 focus:ring-[#2748E9]">
<div class="text-red-500 text-xs mt-1 error-message"></div>
                                    <x-input-error :messages="$errors->get('prenom')" class="mt-2" />
                                </div>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                                <div class="md:col-span-2">
                                    <label for="sexe" class="block text-sm font-medium text-gray-700 mb-1">Sexe</label>
                                    <select id="sexe" name="sexe" class="w-full rounded-md border-gray-300 bg-[#E0E7FF] focus:border-[#2748E9] focus:ring-2 focus:ring-[#2748E9]">
<div class="text-red-500 text-xs mt-1 error-message"></div>
                                        <option value="" disabled {{ old('sexe', $profil?->sexe) ? '' : 'selected' }}>Sélectionnez votre sexe</option>
                                        <option value="Homme" {{ old('sexe', $profil?->sexe) === 'Homme' ? 'selected' : '' }}>Homme</option>
                                        <option value="Femme" {{ old('sexe', $profil?->sexe) === 'Femme' ? 'selected' : '' }}>Femme</option>
                                    </select>
                                    <x-input-error :messages="$errors->get('sexe')" class="mt-2" />
                                </div>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                                <div>
                                    <label for="date_disponibilite" class="block text-sm font-medium text-gray-700 mb-1">Date de disponibilité</label>
                                    <input type="date" name="date_disponibilite" id="date_disponibilite" class="w-full rounded-md border-gray-300 bg-[#E0E7FF] focus:border-[#2748E9] focus:ring-2 focus:ring-[#2748E9]" value="{{ old('date_disponibilite', isset($user->date_disponibilite) ? \Illuminate\Support\Carbon::parse($user->date_disponibilite)->format('Y-m-d') : '') }}">
                                    
<div class="text-red-500 text-xs mt-1 error-message"></div>
                                </div>
                                <div>
                                    <label for="taux_disponibilite" class="block text-sm font-medium text-gray-700 mb-1">Taux de disponibilité  </label>
                                    <select name="taux_disponibilite" id="taux_disponibilite" class="w-full rounded-md border-gray-300 bg-[#E0E7FF] focus:border-[#2748E9] focus:ring-2 focus:ring-[#2748E9]">
                                        <option value="">Sélectionnez un taux</option>
                                        <option value="1/5" {{ old('taux_disponibilite', $profil->taux_disponibilite ?? '') == '1/5' ? 'selected' : '' }}>1/5</option>
                                        <option value="2/5" {{ old('taux_disponibilite', $profil->taux_disponibilite ?? '') == '2/5' ? 'selected' : '' }}>2/5</option>
                                        <option value="3/5" {{ old('taux_disponibilite', $profil->taux_disponibilite ?? '') == '3/5' ? 'selected' : '' }}>3/5</option>
                                        <option value="4/5" {{ old('taux_disponibilite', $profil->taux_disponibilite ?? '') == '4/5' ? 'selected' : '' }}>4/5</option>
                                        <option value="5/5" {{ old('taux_disponibilite', $profil->taux_disponibilite ?? '') == '5/5' ? 'selected' : '' }}>5/5</option>
                                    </select>
                                    <div class="text-red-500 text-xs mt-1 error-message"></div>
                                </div>
                                <div> 
                                    <label for="date_naissance" class="block text-sm font-medium mb-1" style="color:#152C54!important">Date de naissance</label>
                                    <div class="flex gap-2">
    <input type="text" name="date_naissance_jour" id="date_naissance_jour" maxlength="2" placeholder="JJ" class="w-14 rounded-md border-gray-300 bg-[#E0E7FF] text-center" value="{{ old('date_naissance_jour', isset($profil->date_naissance) ? \Illuminate\Support\Carbon::parse($profil->date_naissance)->format('d') : '') }}">
    <span class="self-center">/</span>
    <input type="text" name="date_naissance_mois" id="date_naissance_mois" maxlength="2" placeholder="MM" class="w-14 rounded-md border-gray-300 bg-[#E0E7FF] text-center" value="{{ old('date_naissance_mois', isset($profil->date_naissance) ? \Illuminate\Support\Carbon::parse($profil->date_naissance)->format('m') : '') }}">
    <span class="self-center">/</span>
    <input type="text" name="date_naissance_annee" id="date_naissance_annee" maxlength="4" placeholder="AAAA" class="w-20 rounded-md border-gray-300 bg-[#E0E7FF] text-center" value="{{ old('date_naissance_annee', isset($profil->date_naissance) ? \Illuminate\Support\Carbon::parse($profil->date_naissance)->format('Y') : '') }}">
    <input type="hidden" name="date_naissance" id="date_naissance" value="{{ old('date_naissance', isset($profil->date_naissance) ? \Illuminate\Support\Carbon::parse($profil->date_naissance)->format('Y-m-d') : '') }}">
</div>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const jj = document.getElementById('date_naissance_jour');
    const mm = document.getElementById('date_naissance_mois');
    const aa = document.getElementById('date_naissance_annee');
    if (jj && mm) {
        jj.addEventListener('input', function() {
            if (this.value.length === 2) mm.focus();
        });
    }
    if (mm && aa) {
        mm.addEventListener('input', function() {
            if (this.value.length === 2) aa.focus();
        });
    }
});
</script>
<div class="text-red-500 text-xs mt-1 error-message"></div>
                                </div>
                                <div>
                                    <label for="telephone" class="block text-sm font-medium mb-1" style="color:#152C54!important">Téléphone</label>
                                    <div class="relative">
                                        
                                        <input type="text" name="telephone" id="telephone" class="w-full pl-10 rounded-md border-gray-300 bg-[#E0E7FF] focus:border-[#2748E9] focus:ring-2 focus:ring-[#2748E9]" value="{{ old('telephone', $profil->telephone ?? '') }}" placeholder="Téléphone">
<div class="text-red-500 text-xs mt-1 error-message"></div>
                                    </div>
                                    
                                </div>
                        </div>
                        <div class="mt-8 flex justify-end">
                            <button type="button" class="bg-[#2748E9] text-white px-6 py-2 rounded hover:bg-[#018FFD] shadow-md" onclick="nextStep(2)">Suivant</button>
                        </div>
                    </div>
                    <!-- Étape 2 : Profil professionnel -->
                    <div id="step2" class="step hidden">
                        <div class="w-full bg-white rounded-lg shadow flex items-center px-6 py-3 mb-6">
    <span class="text-2xl mr-3">💼</span>
    <h3 class="text-xl font-bold text-[#152C54] m-0">Profil professionnel</h3>
</div>
                        <p class="text-sm font-bold text-white mb-6">Complétez vos informations professionnelles</p>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="md:col-span-2">
                                <label for="profil" class="block text-sm font-medium text-gray-700 mb-1">Profil</label>
                                <select name="profil" id="profil" class="w-full rounded-md border-gray-300 bg-[#E0E7FF] focus:border-[#2748E9] focus:ring-2 focus:ring-[#2748E9]">
    <option value="" {{ old('profil', $profil->profil ?? '') == '' ? 'selected' : '' }}>Sélectionnez votre profil</option>
    <option value="Associé" {{ old('profil', $profil->profil ?? '') == 'Associé' ? 'selected' : '' }}>Associé</option>
    <option value="Consultant" {{ old('profil', $profil->profil ?? '') == 'Consultant' ? 'selected' : '' }}>Consultant</option>
    <option value="Manager" {{ old('profil', $profil->profil ?? '') == 'Manager' ? 'selected' : '' }}>Manager</option>
    <optgroup label="Conseil & Pilotage de missions">
        <option value="Consultant Junior" {{ old('profil', $profil->profil ?? '') == 'Consultant Junior' ? 'selected' : '' }}>Consultant Junior</option>
        <option value="Consultant Confirmé" {{ old('profil', $profil->profil ?? '') == 'Consultant Confirmé' ? 'selected' : '' }}>Consultant Confirmé</option>
        <option value="Consultant Senior" {{ old('profil', $profil->profil ?? '') == 'Consultant Senior' ? 'selected' : '' }}>Consultant Senior</option>
        <option value="Chef de mission" {{ old('profil', $profil->profil ?? '') == 'Chef de mission' ? 'selected' : '' }}>Chef de mission</option>
        <option value="Manager" {{ old('profil', $profil->profil ?? '') == 'Manager' ? 'selected' : '' }}>Manager</option>
        <option value="Senior Manager" {{ old('profil', $profil->profil ?? '') == 'Senior Manager' ? 'selected' : '' }}>Senior Manager</option>
        <option value="Directeur" {{ old('profil', $profil->profil ?? '') == 'Directeur' ? 'selected' : '' }}>Directeur</option>
        <option value="Associé" {{ old('profil', $profil->profil ?? '') == 'Associé' ? 'selected' : '' }}>Associé</option>
        <option value="Expert" {{ old('profil', $profil->profil ?? '') == 'Expert' ? 'selected' : '' }}>Expert</option>
    </optgroup>
    <optgroup label="Gestion de projets">
        <option value="Chef de projet" {{ old('profil', $profil->profil ?? '') == 'Chef de projet' ? 'selected' : '' }}>Chef de projet</option>
        <option value="Directeur de projet" {{ old('profil', $profil->profil ?? '') == 'Directeur de projet' ? 'selected' : '' }}>Directeur de projet</option>
        <option value="PMO" {{ old('profil', $profil->profil ?? '') == 'PMO' ? 'selected' : '' }}>PMO</option>
        <option value="Chargé d'étude" {{ old('profil', $profil->profil ?? '') == 'Chargé d\'étude' ? 'selected' : '' }}>Chargé d'étude</option>
    </optgroup>
    <optgroup label="Finance, Comptabilité & Contrôle">
        <option value="Comptable technique" {{ old('profil', $profil->profil ?? '') == 'Comptable technique' ? 'selected' : '' }}>Comptable technique</option>
        <option value="Comptable frais généraux" {{ old('profil', $profil->profil ?? '') == 'Comptable frais généraux' ? 'selected' : '' }}>Comptable frais généraux</option>
        <option value="Consolideur" {{ old('profil', $profil->profil ?? '') == 'Consolideur' ? 'selected' : '' }}>Consolideur</option>
        <option value="Contrôleur de Gestion Assurance" {{ old('profil', $profil->profil ?? '') == 'Contrôleur de Gestion Assurance' ? 'selected' : '' }}>Contrôleur de Gestion Assurance</option>
        <option value="Chargé de reporting" {{ old('profil', $profil->profil ?? '') == 'Chargé de reporting' ? 'selected' : '' }}>Chargé de reporting</option>
    </optgroup>
    <optgroup label="Actuariat & Études">
        <option value="Actuaire" {{ old('profil', $profil->profil ?? '') == 'Actuaire' ? 'selected' : '' }}>Actuaire</option>
        <option value="Chargé d'études actuarielles" {{ old('profil', $profil->profil ?? '') == "Chargé d'études actuarielles" ? 'selected' : '' }}>Chargé d'études actuarielles</option>
    </optgroup>
    <optgroup label="Data & Analyse métier">
        <option value="Data Analyst" {{ old('profil', $profil->profil ?? '') == 'Data Analyst' ? 'selected' : '' }}>Data Analyst</option>
        <option value="Data Scientist" {{ old('profil', $profil->profil ?? '') == 'Data Scientist' ? 'selected' : '' }}>Data Scientist</option>
        <option value="Business Analyst" {{ old('profil', $profil->profil ?? '') == 'Business Analyst' ? 'selected' : '' }}>Business Analyst</option>
        <option value="Business Analyst Assurance" {{ old('profil', $profil->profil ?? '') == 'Business Analyst Assurance' ? 'selected' : '' }}>Business Analyst Assurance</option>
    </optgroup>

                                </select>
                            </div>
                            <div>
                                <label for="niveau_diplome" class="block text-sm font-medium text-gray-700 mb-1">Niveau du dernier diplôme</label>
                                <select id="niveau_diplome" name="niveau_diplome" class="w-full rounded-md border-gray-300 bg-[#E0E7FF] focus:border-[#2748E9] focus:ring-2 focus:ring-[#2748E9]" value="{{ old('niveau_diplome', $profil->niveau_diplome ?? '') }}">
                                    <option value="" disabled {{ old('niveau_diplome', $profil?->niveau_diplome) ? '' : 'selected' }}>Sélectionnez votre niveau</option>
                                    <option value="Bac+2 " {{ old('niveau_diplome', $profil?->niveau_diplome) === 'Bac+2' ? 'selected' : '' }}>Bac+2</option>
                                    <option value="Licence" {{ old('niveau_diplome', $profil?->niveau_diplome) === 'Licence' ? 'selected' : '' }}>Licence</option>
                                    <option value="M1" {{ old('niveau_diplome', $profil?->niveau_diplome) === 'M1' ? 'selected' : '' }}>M1</option>
                                    <option value="M2" {{ old('niveau_diplome', $profil?->niveau_diplome) === 'M2' ? 'selected' : '' }}>M2</option>
                                    <option value="Doctorat" {{ old('niveau_diplome', $profil?->niveau_diplome) === 'Doctorat' ? 'selected' : '' }}>Doctorat</option>
                                </select>
                                <x-input-error :messages="$errors->get('niveau_diplome')" class="mt-2" />
                            </div>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
                            <div>
                                <label for="experience" class="block text-sm font-medium text-gray-700 mb-1">Années d'expérience</label>
                                <input type="number" name="experience" id="experience" min="0" max="50" class="w-full rounded-md border-gray-300 bg-[#E0E7FF] focus:border-[#2748E9] focus:ring-2 focus:ring-[#2748E9]" value="{{ old('experience', $profil->experience ?? '') }}" />
<div     class="text-red-500 text-xs mt-1 error-message"></div>
                            </div>
                            <div>
                                <label for="date_diplome_annee" class="block text-sm font-medium mb-1" style="color:#152C54!important">Année d'obtention du dernier diplôme</label>
                                <div>
                                    <input type="text" name="date_diplome_annee" id="date_diplome_annee" maxlength="4" placeholder="AAAA" class="w-24 rounded-md border-gray-300 bg-[#E0E7FF] text-center" value="{{ old('date_diplome_annee', isset($profil->date_diplome) ? \Illuminate\Support\Carbon::parse($profil->date_diplome)->format('Y') : '') }}">
                                    <input type="hidden" name="date_diplome" id="date_diplome" value="{{ old('date_diplome', isset($profil->date_diplome) ? \Illuminate\Support\Carbon::parse($profil->date_diplome)->format('Y') : '') }}">
                                </div>
                                <div class="text-red-500 text-xs mt-1 error-message"></div>
                            </div>
                            <div>
                                <label for="tjm" class="block text-sm font-medium text-gray-700 mb-1">TJM souhaité</label>
                                <div class="relative">
                               <div class="relative">
    <input type="number" name="tjm" id="tjm" min="0" class="w-full pr-10 rounded-md border-gray-300 bg-[#E0E7FF] focus:border-[#2748E9] focus:ring-2 focus:ring-[#2748E9]" value="{{ old('tjm', $profil->tjm ?? '') }}" />
    <span class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-500 pointer-events-none">€</span>
</div>                                </div>
                            </div>
                            <div>
                                <label for="linkedin" class="block text-sm font-medium mb-1" style="color:#152C54!important">Profil LinkedIn</label>
                                <input type="url" name="linkedin" id="linkedin" class="w-full rounded-md border-gray-300 bg-[#E0E7FF] focus:border-[#2748E9] focus:ring-2 focus:ring-[#2748E9]" placeholder="https://www.linkedin.com/in/votre-profil" value="{{ old('linkedin', $profil->linkedin ?? '') }}"/>
                            </div>
                            <div class="md:col-span-2">
                                <label for="cv" class="block text-sm font-medium text-gray-700 mb-1">CV (PDF)</label>
                                <input type="file" name="cv" id="cv" accept=".pdf" class="w-full rounded-md border-gray-300 bg-[#E0E7FF] focus:border-[#2748E9] focus:ring-2 focus:ring-[#2748E9]" value="{{ old('cv', $profil->cv ?? '') }}" />
<div class="text-red-500 text-xs mt-1 error-message"></div>
                            </div>
                        </div>

                        <div class="mt-6 flex justify-between">
                            <button type="button" class="border border-[#2748E9] text-[#2748E9] px-6 py-2 rounded hover:bg-[rgba(50,69,110,0.15)] shadow-md" onclick="previousStep(1)">Précédent</button>
                            <button type="button" class="bg-[#2748E9] text-white px-6 py-2 rounded hover:bg-[#018FFD] shadow-md" onclick="nextStep(3)">Suivant</button>
                        </div>
                    </div>
                    <div id="step3" class="step hidden">
                        <div class="w-full bg-white rounded-lg shadow flex items-center px-6 py-3 mb-4">
    <span class="text-2xl mr-3">🎯</span>
    <h3 class="text-xl font-bold text-[#152C54] m-0">Type d'expertise</h3>
</div>
                        <p class="text-sm font-bold text-white mb-4">Sélectionnez vos domaines d'expertise</p>
                        @php
                            $expertises = old('expertise', $profil->expertise ?? []);
                            if (is_string($expertises)) {
                                $expertises = json_decode($expertises, true) ?: [];
                            }
                            if (!is_array($expertises)) {
                                $expertises = [];
                            }
                        @endphp
                        <div id="expertise-list" class="flex flex-wrap gap-2">
    @foreach($expertises as $i => $expertise)
        <span class="inline-flex items-center px-3 py-1 bg-[#E0E7FF] text-[#152C54] rounded-full font-medium text-sm mb-2">
            {{ $expertise['text'] ?? '' }}
            <span class="mx-1 text-xs text-gray-400">|</span>
            <span class="text-xs text-gray-500">{{ $expertise['category'] ?? '' }}</span>
            <button type="button" class="ml-2 text-red-500 hover:text-red-700 font-bold focus:outline-none remove-expertise-btn" data-index="{{ $i }}" aria-label="Supprimer cette expertise">×</button>
            <input type="hidden" name="expertise[{{ $i }}][text]" value="{{ $expertise['text'] ?? '' }}">
            <input type="hidden" name="expertise[{{ $i }}][category]" value="{{ $expertise['category'] ?? '' }}">
        </span>
    @endforeach
</div>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.remove-expertise-btn').forEach(function(btn) {
            btn.addEventListener('click', function() {
                const idx = this.dataset.index;
                const badge = this.parentElement;
                badge.remove();
                // Supprimer aussi les inputs hidden pour ce badge
                badge.querySelectorAll('input[type="hidden"]').forEach(input => input.remove());
            });
        });
    });
</script>
                        <!-- Ajoute ici le bouton pour ajouter dynamiquement d'autres expertises si besoin -->


                        <div class="grid grid-cols-12 gap-6">
                            <!-- Liste des expertises à gauche -->
                            <div class="col-span-8 bg-white rounded-xl border border-[#E0E7FF] p-6 max-h-[600px] overflow-y-auto">
                                <input type="text" id="searchExpertise" placeholder="Rechercher une expertise..." class="w-full mb-4 px-4 py-2 rounded-md border-gray-300 focus:border-[#2748E9] focus:ring-2 focus:ring-[#2748E9] bg-[#E0E7FF]">

                                <div id="expertiseList">
                                    <!-- Pilotage de la performance financière & Controle de gestion -->
                                    <div class="expertise-category mb-6">
                                        <h4 class="font-bold text-[#2748E9] mb-2">Pilotage de la performance financière & Controle de gestion</h4>
                                        <div class="space-y-2">
                                            <div class="expertise-item p-2 hover:bg-[rgba(50,69,110,0.15)] rounded cursor-pointer transition-colors" data-category="Pilotage de la performance financière & Controle de gestion">
                                                KPI et tableaux de bord
                                            </div>
                                            <div class="expertise-item p-2 hover:bg-[rgba(50,69,110,0.15)] rounded cursor-pointer transition-colors" data-category="Pilotage de la performance financière & Controle de gestion">
                                                Modélisation financière
                                            </div>
                                            <div class="expertise-item p-2 hover:bg-[rgba(50,69,110,0.15)] rounded cursor-pointer transition-colors" data-category="Pilotage de la performance financière & Controle de gestion">
                                                Refonte analytique
                                            </div>
                                            <div class="expertise-item p-2 hover:bg-[rgba(50,69,110,0.15)] rounded cursor-pointer transition-colors" data-category="Pilotage de la performance financière & Controle de gestion">
                                                Rentabilité technique et financière
                                            </div>
                                            <div class="expertise-item p-2 hover:bg-[rgba(50,69,110,0.15)] rounded cursor-pointer transition-colors" data-category="Pilotage de la performance financière & Controle de gestion">
                                                Budget/Forecast
                                            </div>
                                            <div class="expertise-item p-2 hover:bg-[rgba(50,69,110,0.15)] rounded cursor-pointer transition-colors" data-category="Pilotage de la performance financière & Controle de gestion">
                                                Business partnering
                                            </div>
                                            <div class="expertise-item p-2 hover:bg-[rgba(50,69,110,0.15)] rounded cursor-pointer transition-colors" data-category="Pilotage de la performance financière & Controle de gestion">
                                                Plan à 3 ans
                                            </div>
                                            <div class="expertise-item p-2 hover:bg-[rgba(50,69,110,0.15)] rounded cursor-pointer transition-colors" data-category="Pilotage de la performance financière & Controle de gestion">
                                                Suivi des charges
                                            </div>
                                            <div class="expertise-item p-2 hover:bg-[rgba(50,69,110,0.15)] rounded cursor-pointer transition-colors" data-category="Pilotage de la performance financière & Controle de gestion">
                                                Modélisation des coûts
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Normes & reporting réglementaire -->
                                    <div class="expertise-category mb-6">
                                        <h4 class="font-bold text-[#2748E9] mb-2">Normes & reporting réglementaire</h4>
                                        <div class="space-y-2">
                                            <div class="expertise-item p-2 hover:bg-[rgba(50,69,110,0.15)] rounded cursor-pointer transition-colors" data-category="Normes & reporting réglementaire">
                                                IFRS 17
                                            </div>
                                            <div class="expertise-item p-2 hover:bg-[rgba(50,69,110,0.15)] rounded cursor-pointer transition-colors" data-category="Normes & reporting réglementaire">
                                                Solvabilité 2
                                            </div>
                                            <div class="expertise-item p-2 hover:bg-[rgba(50,69,110,0.15)] rounded cursor-pointer transition-colors" data-category="Normes & reporting réglementaire">
                                                QRT, ORSA, RSR, SFCR
                                            </div>
                                            <div class="expertise-item p-2 hover:bg-[rgba(50,69,110,0.15)] rounded cursor-pointer transition-colors" data-category="Normes & reporting réglementaire">
                                                Reporting consolidé
                                            </div>
                                            <div class="expertise-item p-2 hover:bg-[rgba(50,69,110,0.15)] rounded cursor-pointer transition-colors" data-category="Normes & reporting réglementaire">
                                                Retraitements comptables multi-GAAP
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Transformation de la fonction finance -->
                                    <div class="expertise-category mb-6">
                                        <h4 class="font-bold text-[#2748E9] mb-2">Transformation de la fonction finance</h4>
                                        <div class="space-y-2">
                                            <div class="expertise-item p-2 hover:bg-[rgba(50,69,110,0.15)] rounded cursor-pointer transition-colors" data-category="Transformation de la fonction finance">
                                                Diagnostic finance
                                            </div>
                                            <div class="expertise-item p-2 hover:bg-[rgba(50,69,110,0.15)] rounded cursor-pointer transition-colors" data-category="Transformation de la fonction finance">
                                                Fast close
                                            </div>
                                            <div class="expertise-item p-2 hover:bg-[rgba(50,69,110,0.15)] rounded cursor-pointer transition-colors" data-category="Transformation de la fonction finance">
                                                TOM finance
                                            </div>
                                            <div class="expertise-item p-2 hover:bg-[rgba(50,69,110,0.15)] rounded cursor-pointer transition-colors" data-category="Transformation de la fonction finance">
                                                Schéma directeur
                                            </div>
                                            <div class="expertise-item p-2 hover:bg-[rgba(50,69,110,0.15)] rounded cursor-pointer transition-colors" data-category="Transformation de la fonction finance">
                                                CSP finance
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Autres catégories... -->
                                    <!-- Outils, SI finance & digitalisation -->
                                    <div class="expertise-category mb-6">
                                        <h4 class="font-bold text-[#2748E9] mb-2">Outils, SI finance & digitalisation</h4>
                                        <div class="space-y-2">
                                            <div class="expertise-item p-2 hover:bg-[rgba(50,69,110,0.15)] rounded cursor-pointer transition-colors" data-category="Outils, SI finance & digitalisation">
                                                Cadrage d'outils SI
                                            </div>
                                            <div class="expertise-item p-2 hover:bg-[rgba(50,69,110,0.15)] rounded cursor-pointer transition-colors" data-category="Outils, SI finance & digitalisation">
                                                Automatisation de reporting
                                            </div>
                                            <div class="expertise-item p-2 hover:bg-[rgba(50,69,110,0.15)] rounded cursor-pointer transition-colors" data-category="Outils, SI finance & digitalisation">
                                                Qualité des données
                                            </div>
                                            <div class="expertise-item p-2 hover:bg-[rgba(50,69,110,0.15)] rounded cursor-pointer transition-colors" data-category="Outils, SI finance & digitalisation">
                                                Intégration ERP
                                            </div>
                                            <div class="expertise-item p-2 hover:bg-[rgba(50,69,110,0.15)] rounded cursor-pointer transition-colors" data-category="Outils, SI finance & digitalisation">
                                                Reporting réglementaire
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Accompagnement au changement / PMO -->
                                    <div class="expertise-category mb-6">
                                        <h4 class="font-bold text-[#2748E9] mb-2">Accompagnement au changement / PMO</h4>
                                        <div class="space-y-2">
                                            <div class="expertise-item p-2 hover:bg-[rgba(50,69,110,0.15)] rounded cursor-pointer transition-colors" data-category="Accompagnement au changement / PMO">
                                                Conduite du changement
                                            </div>
                                            <div class="expertise-item p-2 hover:bg-[rgba(50,69,110,0.15)] rounded cursor-pointer transition-colors" data-category="Accompagnement au changement / PMO">
                                                Gouvernance projet
                                            </div>
                                            <div class="expertise-item p-2 hover:bg-[rgba(50,69,110,0.15)] rounded cursor-pointer transition-colors" data-category="Accompagnement au changement / PMO">
                                                Suivi des livrables
                                            </div>
                                            <div class="expertise-item p-2 hover:bg-[rgba(50,69,110,0.15)] rounded cursor-pointer transition-colors" data-category="Accompagnement au changement / PMO">
                                                Coordination métiers/IT
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Expertise actuarielle appliquée à la finance -->
                                    <div class="expertise-category mb-6">
                                        <h4 class="font-bold text-[#2748E9] mb-2">Expertise actuarielle appliquée à la finance</h4>
                                        <div class="space-y-2">
                                            <div class="expertise-item p-2 hover:bg-[rgba(50,69,110,0.15)] rounded cursor-pointer transition-colors" data-category="Expertise actuarielle appliquée à la finance">
                                                Projections cash-flows
                                            </div>
                                            <div class="expertise-item p-2 hover:bg-[rgba(50,69,110,0.15)] rounded cursor-pointer transition-colors" data-category="Expertise actuarielle appliquée à la finance">
                                                SCR
                                            </div>
                                            <div class="expertise-item p-2 hover:bg-[rgba(50,69,110,0.15)] rounded cursor-pointer transition-colors" data-category="Expertise actuarielle appliquée à la finance">
                                                Best estimate
                                            </div>
                                            <div class="expertise-item p-2 hover:bg-[rgba(50,69,110,0.15)] rounded cursor-pointer transition-colors" data-category="Expertise actuarielle appliquée à la finance">
                                                VNB
                                            </div>
                                            <div class="expertise-item p-2 hover:bg-[rgba(50,69,110,0.15)] rounded cursor-pointer transition-colors" data-category="Expertise actuarielle appliquée à la finance">
                                                IFRS17 actuariel
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Comptabilité -->
                                    <div class="expertise-category mb-6">
                                        <h4 class="font-bold text-[#2748E9] mb-2">Comptabilité</h4>
                                        <div class="space-y-2">
                                            <div class="expertise-item p-2 hover:bg-[rgba(50,69,110,0.15)] rounded cursor-pointer transition-colors" data-category="Comptabilité">
                                                Comptabilité générale
                                            </div>
                                            <div class="expertise-item p-2 hover:bg-[rgba(50,69,110,0.15)] rounded cursor-pointer transition-colors" data-category="Comptabilité">
                                                Comptabilité technique
                                            </div>
                                            <div class="expertise-item p-2 hover:bg-[rgba(50,69,110,0.15)] rounded cursor-pointer transition-colors" data-category="Comptabilité">
                                                Comptabilité de placement
                                            </div>
                                            <div class="expertise-item p-2 hover:bg-[rgba(50,69,110,0.15)] rounded cursor-pointer transition-colors" data-category="Comptabilité">
                                                Comptabilité d'assurance
                                            </div>
                                             
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Sélections à droite -->
                            <div class="col-span-4">
                                <div class="bg-white rounded-xl border border-[#E0E7FF] p-6">
                                    <h4 class="font-bold text-[#2748E9] mb-4">Expertises sélectionnées</h4>
                                    <div id="expertiseCounter" class="text-sm text-gray-500 mb-2">0/10 types d'expertise</div>
                                    
                                    <div id="selectedExpertise" class="space-y-2">
                                        <!-- Les expertises sélectionnées seront ajoutées ici dynamiquement -->
                                    </div>
                                    <div id="expertiseWarning" class="text-red-500 text-sm mt-2 hidden">
                                        Vous avez atteint la limite de 10 types d'expertise.
                                    </div>
                                    <input type="hidden" name="expertise" id="expertise">
<div class="text-red-500 text-xs mt-1 error-message"></div>
                                </div> 
                            </div> 
                        </div>

                        <div class="mt-8 flex justify-between">
                            <button type="button" class="border border-[#2748E9] text-[#2748E9] px-6 py-2 rounded hover:bg-[rgba(50,69,110,0.15)] shadow-md" onclick="previousStep(2)">Précédent</button>
                            <button type="button" class="bg-[#2748E9] text-white px-6 py-2 rounded hover:bg-[#018FFD] shadow-md" onclick="nextStep(4)">Suivant</button>
                        </div>
                    </div>

                    <!-- Étape 4 : Compétences -->
                    <div id="step4" class="step hidden">
                        <div class="w-full bg-white rounded-lg shadow flex items-center px-6 py-3 mb-4">
    <span class="text-2xl mr-3">🛠️</span>
    <h3 class="text-xl font-bold text-[#152C54] m-0">Compétences</h3>
</div>
                        <p class="text-sm font-bold text-white mb-4">Ajoutez vos outils et technologies</p>
                        @php
                            $competences = old('competences', $profil->competences ?? []);
                            if (is_string($competences)) {
                                $competences = json_decode($competences, true) ?: [];
                            }
                        @endphp
                        <div id="competence-list" class="flex flex-wrap gap-2">
    @foreach($competences as $i => $competence)
        <span class="inline-flex items-center px-3 py-1 bg-[#E0E7FF] text-[#152C54] rounded-full font-medium text-sm mb-2">
            {{ $competence['text'] ?? '' }}
            <span class="mx-1 text-xs text-gray-400">|</span>
            <span class="text-xs text-gray-500">{{ $competence['category'] ?? '' }}</span>
            <button type="button" class="ml-2 text-red-500 hover:text-red-700 font-bold focus:outline-none remove-competence-btn" data-index="{{ $i }}" aria-label="Supprimer cette compétence">×</button>
            <input type="hidden" name="competences[{{ $i }}][text]" value="{{ $competence['text'] ?? '' }}">
            <input type="hidden" name="competences[{{ $i }}][category]" value="{{ $competence['category'] ?? '' }}">
        </span>
    @endforeach
</div>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.remove-competence-btn').forEach(function(btn) {
            btn.addEventListener('click', function() {
                const idx = this.dataset.index;
                const badge = this.parentElement;
                badge.remove();
                // Supprimer aussi les inputs hidden pour ce badge
                badge.querySelectorAll('input[type="hidden"]').forEach(input => input.remove());
            });
        });
    });
</script>
                        <!-- Ajoute ici le bouton pour ajouter dynamiquement d'autres compétences si besoin -->


                        <div class="flex gap-6">
                            <!-- Liste des compétences -->
                            <div class="w-2/3 bg-white rounded-lg p-6 shadow-sm">
                                <div class="mb-4">
                                    <input type="text" id="searchSkills" placeholder="Rechercher une compétence..." class="w-full p-2 border border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500">
                                </div>
                                <input type="hidden" name="skills" id="skills" value="[]">
                                
                                <div class="space-y-6 max-h-[600px] overflow-y-auto">
                                    <!-- Bureautique -->
                                    <div class="skills-category">
                                        <h3 class="font-bold text-[#2748E9] mb-2">Bureautique</h3>
                                        <div class="grid grid-cols-2 gap-2">
                                            <div class="skill-item cursor-pointer p-2 hover:bg-indigo-50 rounded" data-category="Bureautique">Excel</div>
                                            <div class="skill-item cursor-pointer p-2 hover:bg-indigo-50 rounded" data-category="Bureautique">Word</div>
                                            <div class="skill-item cursor-pointer p-2 hover:bg-indigo-50 rounded" data-category="Bureautique">PowerPoint</div>
                                            <div class="skill-item cursor-pointer p-2 hover:bg-indigo-50 rounded" data-category="Bureautique">Outlook</div>
                                        </div>
                                    </div>

                                    <!-- Data / BI -->
                                    <div class="skills-category">
                                        <h3 class="font-bold text-[#2748E9] mb-2">Data / BI</h3>
                                        <div class="grid grid-cols-2 gap-2">
                                            <div class="skill-item cursor-pointer p-2 hover:bg-indigo-50 rounded" data-category="Data / BI">Power BI</div>
                                            <div class="skill-item cursor-pointer p-2 hover:bg-indigo-50 rounded" data-category="Data / BI">Tableau</div>
                                            <div class="skill-item cursor-pointer p-2 hover:bg-indigo-50 rounded" data-category="Data / BI">Qlik</div>
                                            <div class="skill-item cursor-pointer p-2 hover:bg-indigo-50 rounded" data-category="Data / BI">SQL</div>
                                            <div class="skill-item cursor-pointer p-2 hover:bg-indigo-50 rounded" data-category="Data / BI">Python</div>
                                            <div class="skill-item cursor-pointer p-2 hover:bg-indigo-50 rounded" data-category="Data / BI">R</div>
                                        </div>
                                    </div>

                                    <!-- Gestion de projet -->
                                    <div class="skills-category">
                                        <h3 class="font-bold text-[#2748E9] mb-2">Gestion de projet</h3>
                                        <div class="grid grid-cols-2 gap-2">
                                            <div class="skill-item cursor-pointer p-2 hover:bg-indigo-50 rounded" data-category="Gestion de projet">MS Project</div>
                                            <div class="skill-item cursor-pointer p-2 hover:bg-indigo-50 rounded" data-category="Gestion de projet">Jira</div>
                                            <div class="skill-item cursor-pointer p-2 hover:bg-indigo-50 rounded" data-category="Gestion de projet">Confluence</div>
                                            <div class="skill-item cursor-pointer p-2 hover:bg-indigo-50 rounded" data-category="Gestion de projet">Trello</div>
                                            <div class="skill-item cursor-pointer p-2 hover:bg-indigo-50 rounded" data-category="Gestion de projet">Notion</div>
                                            <div class="skill-item cursor-pointer p-2 hover:bg-indigo-50 rounded" data-category="Gestion de projet">Teams</div>
                                            <div class="skill-item cursor-pointer p-2 hover:bg-indigo-50 rounded" data-category="Gestion de projet">SharePoint</div>
                                        </div>
                                    </div>

                                    <!-- Actuariat / Finance -->
                                    <div class="skills-category">
                                        <h3 class="font-bold text-[#2748E9] mb-2">Actuariat / Finance</h3>
                                        <div class="grid grid-cols-2 gap-2">
                                            <div class="skill-item cursor-pointer p-2 hover:bg-indigo-50 rounded" data-category="Actuariat / Finance">Prophet</div>
                                            <div class="skill-item cursor-pointer p-2 hover:bg-indigo-50 rounded" data-category="Actuariat / Finance">RiskAgility</div>
                                            <div class="skill-item cursor-pointer p-2 hover:bg-indigo-50 rounded" data-category="Actuariat / Finance">Addactis</div>
                                            <div class="skill-item cursor-pointer p-2 hover:bg-indigo-50 rounded" data-category="Actuariat / Finance">Excel/VBA</div>
                                            <div class="skill-item cursor-pointer p-2 hover:bg-indigo-50 rounded" data-category="Actuariat / Finance">R</div>
                                            <div class="skill-item cursor-pointer p-2 hover:bg-indigo-50 rounded" data-category="Actuariat / Finance">Python</div>
                                        </div>
                                    </div>

                                    <!-- Réglementaire / Assurance -->
                                    <div class="skills-category">
                                        <h3 class="font-bold text-[#2748E9] mb-2">Réglementaire / Assurance</h3>
                                        <div class="grid grid-cols-2 gap-2">
                                            <div class="skill-item cursor-pointer p-2 hover:bg-indigo-50 rounded" data-category="Réglementaire / Assurance">EIOPA templates</div>
                                            <div class="skill-item cursor-pointer p-2 hover:bg-indigo-50 rounded" data-category="Réglementaire / Assurance">IFRS17 tools</div>
                                            <div class="skill-item cursor-pointer p-2 hover:bg-indigo-50 rounded" data-category="Réglementaire / Assurance">SAP</div>
                                            <div class="skill-item cursor-pointer p-2 hover:bg-indigo-50 rounded" data-category="Réglementaire / Assurance">Oracle</div>
                                            <div class="skill-item cursor-pointer p-2 hover:bg-indigo-50 rounded" data-category="Réglementaire / Assurance">Outils internes de reporting réglementaire</div>
                                        </div>
                                    </div>

                                    <!-- Communication / GED -->
                                    <div class="skills-category">
                                        <h3 class="font-bold text-[#2748E9] mb-2">Communication / GED</h3>
                                        <div class="grid grid-cols-2 gap-2">
                                            <div class="skill-item cursor-pointer p-2 hover:bg-indigo-50 rounded" data-category="Communication / GED">Teams</div>
                                            <div class="skill-item cursor-pointer p-2 hover:bg-indigo-50 rounded" data-category="Communication / GED">Zoom</div>
                                            <div class="skill-item cursor-pointer p-2 hover:bg-indigo-50 rounded" data-category="Communication / GED">Webex</div>
                                            <div class="skill-item cursor-pointer p-2 hover:bg-indigo-50 rounded" data-category="Communication / GED">SharePoint</div>
                                            <div class="skill-item cursor-pointer p-2 hover:bg-indigo-50 rounded" data-category="Communication / GED">DocuWare</div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Compétences sélectionnées -->
                            <div class="w-1/3">
                                <div class="bg-white rounded-lg p-6 shadow-sm sticky top-6">
                                    <h3 class="text-lg font-semibold mb-4">Compétences sélectionnées</h3>
                                    <div id="skillsCounter" class="text-sm text-gray-500 mb-2">0/10 compétences</div>
                                    <div id="selectedSkills" class="space-y-4"></div>
                                    <div id="skillsRemaining" class="text-green-600 text-sm mt-2">Vous pouvez encore ajouter 10 compétences.</div>
                                    <div id="skillsWarning" class="text-red-500 text-sm mt-2 hidden">Vous avez atteint la limite de 10 compétences.</div>
                                    <input type="hidden" name="competences" id="competencesInput">
<div class="text-red-500 text-xs mt-1 error-message"></div>
                                </div>
                            </div>
                        </div>
                        <div class="mt-8 flex justify-between">
                            <button type="button" class="border border-[#2748E9] text-[#2748E9] px-6 py-2 rounded hover:bg-[rgba(50,69,110,0.15)] shadow-md" onclick="previousStep(3)">Précédent</button>
                            <button type="button" class="bg-[#2748E9] text-white px-6 py-2 rounded hover:bg-[#018FFD] shadow-md" onclick="nextStep(5)">Suivant</button>
                        </div>
                    </div>
                    <!-- Étape 5 : Expériences et Références -->
<div id="step5" class="step hidden">
    <div class="w-full bg-white rounded-lg shadow flex items-center px-6 py-3 mb-6">
        <span class="text-2xl mr-3">💼</span>
        <h3 class="text-xl font-bold text-[#152C54] m-0">Expériences</h3>
    </div>
    <p class="text-sm font-bold text-white mb-6">Détaillez vos expériences professionnelles</p>
    @php
    $experiences = old('experiences', $profil->experiences ?? []);
    if ($experiences instanceof \Illuminate\Database\Eloquent\Collection) {
        $experiences = $experiences->toArray();
    }
@endphp
<div id="experiencesContainer">
    @foreach($experiences as $eIdx => $experience)
        <div class="experience-card bg-white rounded-xl shadow p-6 mb-8">
            <div class="flex items-center gap-3 mb-4">
                <span class="text-2xl">🗂️</span>
                <div class="font-bold text-lg text-[#152C54] flex-1">Expérience {{ $eIdx + 1 }}</div>
                <button type="button" class="text-red-500 hover:text-red-700" onclick="this.closest('.experience-card').remove()">✕</button>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <input type="text" name="experiences[{{ $eIdx }}][societe]" placeholder="Société" class="rounded-md border-gray-300" value="{{ $experience['societe'] ?? '' }}">
                <input type="text" name="experiences[{{ $eIdx }}][secteur]" placeholder="Secteur" class="rounded-md border-gray-300" value="{{ $experience['secteur'] ?? '' }}">
                <input type="text" name="experiences[{{ $eIdx }}][poste]" placeholder="Poste" class="rounded-md border-gray-300" value="{{ $experience['poste'] ?? '' }}">
                <input type="text" name="experiences[{{ $eIdx }}][detail]" placeholder="Détail" class="rounded-md border-gray-300" value="{{ $experience['detail'] ?? '' }}">
                <div class="flex gap-2">
    
    <input type="text" name="experiences[{{ $eIdx }}][date_debut_mois]" id="experiences_{{ $eIdx }}_date_debut_mois" maxlength="2" placeholder="MM" class="w-12 rounded-md border-gray-300 bg-[#E0E7FF] text-center" value="{{ old('experiences.'.$eIdx.'.date_debut_mois', isset($experience['date_debut']) ? \Illuminate\Support\Carbon::parse($experience['date_debut'])->format('m') : '') }}">
    <span class="self-center">/</span>
    <input type="text" name="experiences[{{ $eIdx }}][date_debut_annee]" id="experiences_{{ $eIdx }}_date_debut_annee" maxlength="4" placeholder="AAAA" class="w-16 rounded-md border-gray-300 bg-[#E0E7FF] text-center" value="{{ old('experiences.'.$eIdx.'.date_debut_annee', isset($experience['date_debut']) ? \Illuminate\Support\Carbon::parse($experience['date_debut'])->format('Y') : '') }}">
    <input type="hidden" name="experiences[{{ $eIdx }}][date_debut]" id="experiences_{{ $eIdx }}_date_debut_full">
</div>
<div class="flex gap-2 mt-2">
    
    <input type="text" name="experiences[{{ $eIdx }}][date_fin_mois]" id="experiences_{{ $eIdx }}_date_fin_mois" maxlength="2" placeholder="MM" class="w-12 rounded-md border-gray-300 bg-[#E0E7FF] text-center" value="{{ old('experiences.'.$eIdx.'.date_fin_mois', isset($experience['date_fin']) ? \Illuminate\Support\Carbon::parse($experience['date_fin'])->format('m') : '') }}">
    <span class="self-center">/</span>
    <input type="text" name="experiences[{{ $eIdx }}][date_fin_annee]" id="experiences_{{ $eIdx }}_date_fin_annee" maxlength="4" placeholder="AAAA" class="w-16 rounded-md border-gray-300 bg-[#E0E7FF] text-center" value="{{ old('experiences.'.$eIdx.'.date_fin_annee', isset($experience['date_fin']) ? \Illuminate\Support\Carbon::parse($experience['date_fin'])->format('Y') : '') }}">
    <input type="hidden" name="experiences[{{ $eIdx }}][date_fin]" id="experiences_{{ $eIdx }}_date_fin_full">
</div>

    <script>
        // Log pour debug
        console.log('autoTabExperienceDateInputs appelé pour idx', eIdx);
        // Helper pour reset event listener proprement
        function setAutoTab(input, target) {
            if (!input || !target) return;
            // Clone technique pour retirer tous les anciens listeners
            const clone = input.cloneNode(true);
            input.parentNode.replaceChild(clone, input);
            clone.addEventListener('input', function() {
                if (this.value.length === 2) {
                    target.focus();
                }
            });
        }
        // Début
        const debutMois = document.getElementById(`experiences_${eIdx}_date_debut_mois`);
        const debutAnnee = document.getElementById(`experiences_${eIdx}_date_debut_annee`);
        setAutoTab(debutMois, debutAnnee);
        // Fin
        const finMois = document.getElementById(`experiences_${eIdx}_date_fin_mois`);
        const finAnnee = document.getElementById(`experiences_${eIdx}_date_fin_annee`);
        setAutoTab(finMois, finAnnee);
    </script>
</div>

            </div>
            <!-- Références associées à cette expérience -->
            @php
                $refs = $experience['references'] ?? [];
                if (empty($refs) && isset($profil->references)) {
                    // Si old vide, récupérer les références liées à cette expérience par experience_id
                    $refs = collect($profil->references)->where('experience_id', $experience['id'] ?? null)->values()->toArray();
                }
            @endphp
            <div class="referencesContainer">
                @foreach($experiences as $eIdx => $experience)
    @php
        $refs = $experience['references'] ?? [];
    @endphp
    @foreach($refs as $rIdx => $reference)
        <div class="reference-card bg-gray-100 rounded p-4 mb-2">
            <input type="text" name="experiences[{{ $eIdx }}][references][{{ $rIdx }}][nom]" placeholder="Nom" class="rounded-md border-gray-300" value="{{ $reference['nom'] ?? '' }}">
            <input type="text" name="experiences[{{ $eIdx }}][references][{{ $rIdx }}][prenom]" placeholder="Prénom" class="rounded-md border-gray-300" value="{{ $reference['prenom'] ?? '' }}">
            <input type="text" name="experiences[{{ $eIdx }}][references][{{ $rIdx }}][fonction]" placeholder="Fonction" class="rounded-md border-gray-300" value="{{ $reference['fonction'] ?? '' }}">
            <input type="email" name="experiences[{{ $eIdx }}][references][{{ $rIdx }}][email]" placeholder="Email" class="rounded-md border-gray-300" value="{{ $reference['email'] ?? '' }}">
            <input type="tel" name="experiences[{{ $eIdx }}][references][{{ $rIdx }}][telephone]" placeholder="Téléphone" class="rounded-md border-gray-300" value="{{ $reference['telephone'] ?? '' }}">
        </div>
    @endforeach
@endforeach
            </div>
        </div>
    @endforeach
</div>
<button type="button" onclick="addExperienceCard()" class="text-[#2748E9] hover:text-[#018FFD] mt-2 mb-8">
    + Ajouter une expérience
</button>
    <div class="mt-8 flex justify-between">
        <button type="button" class="border border-[#2748E9] text-[#2748E9] px-6 py-2 rounded hover:bg-[rgba(50,69,110,0.15)] shadow-md" onclick="previousStep(4)">Précédent</button>
        <button type="button" id="previewProfileBtn" class="bg-[#2748E9] text-white px-6 py-2 rounded hover:bg-[#018FFD] shadow-md">Vérifier mon profil</button>
    </div>
</div>

<!-- Modal de récapitulatif du profil -->
<style>
#profilePreviewModal {
  background: rgba(0,0,0,0.12)!important;
}
#profilePreviewModal .modal-card {
  background: #fff;
  border-radius: 1.1rem;
  box-shadow: 0 8px 32px 0 rgba(44,62,80,0.18), 0 1.5px 8px rgba(44,62,80,0.09);
  border: none;
  padding: 0;
  max-width: 610px;
  width: 97vw;
  position: relative;
  animation: modalFadeIn 0.22s cubic-bezier(.4,0,.2,1);
  display: flex;
  flex-direction: column;
}
@keyframes modalFadeIn {
  from { transform: scale(0.98) translateY(30px); opacity: 0; }
  to   { transform: scale(1) translateY(0); opacity: 1; }
}
#profilePreviewModal .close-btn {
  position: absolute; top: 1.1rem; right: 1.2rem;
  background: transparent; border: none;
  font-size: 2.1rem; color: #bfc6e0;
  transition: color 0.18s;
  cursor: pointer;
  z-index: 2;
}
#profilePreviewModal .close-btn:hover { color: #2748E9; }
#profilePreviewModal .modal-header {
  padding: 2.1rem 2.2rem 1.1rem 2.2rem;
  border-bottom: 1px solid #f0f1f5;
  display: flex; align-items: center; gap: 1rem;
}
#profilePreviewModal .modal-header h2 {
  color: #22304a;
  font-size: 1.35rem;
  font-weight: 700;
  margin: 0;
  flex: 1;
  text-align: center;
  letter-spacing: 0.5px;
}
#profilePreviewModal .modal-content {
  padding: 1.6rem 2.2rem 1.2rem 2.2rem;
  max-height: 56vh;
  overflow-y: auto;
  display: flex;
  flex-direction: column;
  gap: 1.3rem;
}
#profilePreviewModal .profile-section {
  margin-bottom: 0.7rem;
  padding-bottom: 0.7rem;
  border-bottom: 1px solid #f2f3f7;
}
#profilePreviewModal .profile-section:last-child {
  border-bottom: none;
}
#profilePreviewModal .profile-section-title {
  font-size: 1.07rem;
  font-weight: 600;
  color: #2748E9;
  margin-bottom: 0.4rem;
  letter-spacing: 0.1px;
}
#profilePreviewModal .profile-section-content {
  color: #384053;
  font-size: 1.01rem;
  padding-left: 0.2rem;
}
#profilePreviewModal .modal-actions {
  display: flex;
  justify-content: flex-end;
  gap: 1.2rem;
  padding: 1.1rem 2.2rem 1.5rem 2.2rem;
  border-top: 1px solid #f0f1f5;
}
#profilePreviewModal .modal-actions button {
  transition: all 0.18s;
  font-weight: 500;
  outline: none;
  border-radius: 0.5rem;
  font-size: 1rem;
  padding: 0.6em 1.6em;
  border: 1.5px solid #e1e3f0;
  background: #f7f8fa;
  color: #22304a;
  box-shadow: 0 1px 4px rgba(44,62,80,0.04);
}
#profilePreviewModal .modal-actions button:hover {
  background: #e0e7ff;
  border-color: #b1c5f6;
  color: #2748E9;
}
#profilePreviewModal .modal-actions .submit-btn {
  background: #2748E9;
  color: #fff;
  border: none;
}
#profilePreviewModal .modal-actions .submit-btn:hover {
  background: #018FFD;
  color: #fff;
}
@media (max-width: 600px) {
  #profilePreviewModal .modal-card { padding: 0; }
  #profilePreviewModal .modal-header,
  #profilePreviewModal .modal-content,
  #profilePreviewModal .modal-actions { padding-left: 1rem; padding-right: 1rem; }
}

{
  border-radius: 1.2rem;
  box-shadow: 0 8px 32px 0 rgba(39,72,233,0.15), 0 1.5px 8px rgba(39,72,233,0.08);
  border: 2.5px solid #2748E9;
  padding: 0;
  max-width: 650px;
  width: 96vw;
  animation: modalFadeIn 0.25s cubic-bezier(.4,0,.2,1);
  position: relative;
}
@keyframes modalFadeIn {
  from { transform: scale(0.98) translateY(30px); opacity: 0; }
  to   { transform: scale(1) translateY(0); opacity: 1; }
}
#profilePreviewModal .modal-header {
  background: linear-gradient(90deg,#2748E9 60%,#018FFD 100%);
  border-top-left-radius: 1.1rem;
  border-top-right-radius: 1.1rem;
  padding: 1.6rem 2rem 1.2rem 2rem;
  display: flex; align-items: center; gap: 1rem;
}
#profilePreviewModal .modal-header .icon {
  font-size: 2.4rem;
  color: #fff;
}
#profilePreviewModal .modal-header h2 {
  color: #fff;
  font-size: 1.35rem;
  font-weight: 700;
  margin: 0;
  flex: 1;
  text-align: center;
  letter-spacing: 0.5px;
}
#profilePreviewModal .close-btn {
  position: absolute; top: 1.1rem; right: 1.2rem;
  background: transparent; border: none;
  font-size: 2.1rem; color: #bfc6e0;
  transition: color 0.18s;
  cursor: pointer;
  z-index: 2;
}
#profilePreviewModal .close-btn:hover { color: #2748E9; }
#profilePreviewModal .modal-content {
  padding: 2.2rem 2.2rem 1.2rem 2.2rem;
  max-height: 55vh;
  overflow-y: auto;
}
#profilePreviewModal .profile-section {
  margin-bottom: 1.3rem;
}
#profilePreviewModal .profile-section-title {
  font-size: 1.07rem;
  font-weight: 600;
  color: #2748E9;
  margin-bottom: 0.3rem;
  display: flex; align-items: center; gap: 0.5rem;
}
#profilePreviewModal .profile-section-content {
  padding-left: 1.1rem;
  color: #384053;
  font-size: 1.01rem;
}
#profilePreviewModal .modal-actions {
  display: flex;
  justify-content: flex-end;
  gap: 1.2rem;
  padding: 1.2rem 2.2rem 1.5rem 2.2rem;
}
#profilePreviewModal .modal-actions button {
  transition: all 0.18s;
  font-weight: 500;
  box-shadow: 0 2px 8px rgba(39,72,233,0.07);
  outline: none;
}
#profilePreviewModal .modal-actions .edit-btn {
  border: 2px solid #2748E9;
  color: #2748E9;
  background: #fff;
}
#profilePreviewModal .modal-actions .edit-btn:hover {
  background: #e0e7ff;
  color: #018FFD;
  border-color: #018FFD;
}
#profilePreviewModal .modal-actions .submit-btn {
  background: linear-gradient(90deg,#2748E9 60%,#018FFD 100%);
  color: #fff;
  border: none;
}
#profilePreviewModal .modal-actions .submit-btn:hover {
  background: linear-gradient(90deg,#018FFD 60%,#2748E9 100%);
}
@media (max-width: 600px) {
  #profilePreviewModal .modal-card { padding: 0; }
  #profilePreviewModal .modal-header,
  #profilePreviewModal .modal-content,
  #profilePreviewModal .modal-actions { padding-left: 1rem; padding-right: 1rem; }
}
</style>

<div id="profilePreviewModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
  <div class="modal-card">
    <button type="button" onclick="closeProfilePreviewModal()" class="close-btn" aria-label="Fermer">&times;</button>
    <div class="modal-header">
      <h2>Récapitulatif de votre profil</h2>
    </div>
    <div class="modal-content">
      <div class="profile-section">
        <div class="profile-section-title">Profil personnel</div>
        <div class="profile-section-content" id="recap-profil-personnel"></div>
      </div>
      <div class="profile-section">
        <div class="profile-section-title">Profil professionnel</div>
        <div class="profile-section-content" id="recap-profil-professionnel"></div>
      </div>
      <div class="profile-section">
        <div class="profile-section-title">Compétences &amp; expertises</div>
        <div class="profile-section-content" id="recap-competences-expertises"></div>
      </div>
      <div class="profile-section">
        <div class="profile-section-title">Expériences et Références</div>
        <div class="profile-section-content" id="recap-experiences"></div>
      </div>
    </div>
    <div class="modal-actions">
      <button type="button" class="edit-btn" onclick="closeProfilePreviewModal()">Revenir à l'édition</button>
      <button type="submit" id="submitProfileBtn" class="submit-btn">Envoyer mon profil</button>
    </div>
  </div>
</div>

<script>

function formatDateFR(dateStr) {
    if (!dateStr || !dateStr.match(/^\\d{4}-\\d{2}-\\d{2}$/)) return dateStr || '-';
    const [y, m, d] = dateStr.split('-');
    return `${d}/${m}/${y}`;
}

function assembleHiddenDates() {
    // Date de naissance
    const jj = document.getElementById('date_naissance_jour');
    const mm = document.getElementById('date_naissance_mois');
    const aa = document.getElementById('date_naissance_annee');
    const hidden = document.getElementById('date_naissance');
    if (jj && mm && aa && hidden) {
        if (jj.value && mm.value && aa.value) {
            hidden.value = `${aa.value}-${mm.value.padStart(2,'0')}-${jj.value.padStart(2,'0')}`;
        } else {
            hidden.value = '';
        }
    }
    // Date du diplôme (année seule)
    const da = document.getElementById('date_diplome_annee');
    const hiddenDiplome = document.getElementById('date_diplome');
    if (da && hiddenDiplome) {
        if (da.value && da.value.length === 4) {
            hiddenDiplome.value = `${da.value}-01-01`;
        } else {
            hiddenDiplome.value = '';
        }
    }
}

// Récupère et affiche le résumé du profil dans le modal
function getProfileSummary() {
    assembleHiddenDates();
    const previewBtn = document.getElementById('previewProfileBtn');
    let form = previewBtn?.closest('form') || document.querySelector('form');
    const formData = new FormData(form);

    // 1. Profil personnel
    let personnel = '';
    personnel += `<b>Nom :</b> ${formData.get('nom') || '-'}<br>`;
    personnel += `<b>Prénom :</b> ${formData.get('prenom') || '-'}<br>`;
    personnel += `<b>Sexe :</b> ${formData.get('sexe') || '-'}<br>`;
    personnel += `<b>Date de naissance :</b> ${formatDateFR(formData.get(`date_naissance`))}<br>`;
    personnel += `<b>Téléphone :</b> ${formData.get('telephone') || '-'}<br>`;
    document.getElementById('recap-profil-personnel').innerHTML = personnel;

    // 2. Profil professionnel
    let professionnel = '';
    professionnel += `<b>Profil :</b> ${formData.get('profil') || '-'}<br>`;
    professionnel += `<b>Niveau de diplôme :</b> ${formData.get('niveau_diplome') || '-'}<br>`;
    professionnel += `<b>Date du diplôme :</b> ${formatDateFR(formData.get(`date_diplome`))}<br>`;
    professionnel += `<b>Années d'expérience :</b> ${formData.get('experience') || '-'}<br>`;
    professionnel += `<b>Date de disponibilité :</b> ${formatDateFR(formData.get(`date_disponibilite`))}<br>`;
    professionnel += `<b>Taux de disponibilité :</b> ${formData.get('taux_disponibilite') || '-'}<br>`;
    professionnel += `<b>TJM :</b> ${formData.get('tjm') || '-'}<br>`;
    document.getElementById('recap-profil-professionnel').innerHTML = professionnel;

    // 3. Compétences & expertises
    let competences = '';
    // Compétences
    let comp = [];
    try {
        comp = JSON.parse(formData.get('competences') || '[]');
    } catch(e) {
        comp = [];
    }
    let compLabels = comp.map(item => {
    if (typeof item === 'string') return item;
    const label = item.label || item.value || item.text || '';
    // On prend en priorité level (utilisé par selectedSkills), sinon stars, etoiles, niveau
    const stars = item.level || item.stars || item.etoiles || item.niveau || 0;
    if (stars > 0) {
        return `${label} (<span style='color:#FFD700'>${'★'.repeat(stars)}${'☆'.repeat(5-stars)}</span>)`;
    }
    return label;
});
    competences += `<b>Compétences :</b> ${compLabels.filter(Boolean).join(', ') || '-'}<br>`;

    // Expertises
    let exp = [];
    try {
        exp = JSON.parse(formData.get('expertise') || '[]');
    } catch(e) {
        exp = [];
    }
    let expLabels = exp.map(item => typeof item === 'string' ? item : item.text || item.label || item.value || '');
    competences += `<b>Expertises :</b> ${expLabels.filter(Boolean).join(', ') || '-'}<br>`;
    document.getElementById('recap-competences-expertises').innerHTML = competences;
    
    // 4. Expériences et Références
    let experiences = '';
    let i = 0;
    while (formData.has(`experiences[${i}][societe]`)) {
        experiences += `<div style="margin-bottom:0.5em;"><b>Expérience ${i+1}</b><br>`;
        experiences += `<b>Société :</b> ${formData.get(`experiences[${i}][societe]`) || '-'}<br>`;
        experiences += `<b>Secteur :</b> ${formData.get(`experiences[${i}][secteur]`) || '-'}<br>`;
        experiences += `<b>Poste :</b> ${formData.get(`experiences[${i}][poste]`) || '-'}<br>`;
        experiences += `<b>Date début :</b> ${formatDateFR(formData.get(`experiences[${i}][date_debut]`))}<br>`;
        experiences += `<b>Date fin :</b> ${formatDateFR(formData.get(`experiences[${i}][date_fin]`))}<br>`;
        experiences += `<b>Détail :</b> ${formData.get(`experiences[${i}][detail]`) || '-'}<br>`;

        // Références pour cette expérience
        let refIdx = 0;
while (formData.has(`experiences[${i}][references][${refIdx}][nom]`) ||
       formData.has(`experiences[${i}][references][${refIdx}][prenom]`) ||
       formData.has(`experiences[${i}][references][${refIdx}][fonction]`) ||
       formData.has(`experiences[${i}][references][${refIdx}][secteur]`) ||
       formData.has(`experiences[${i}][references][${refIdx}][email]`) ||
       formData.has(`experiences[${i}][references][${refIdx}][telephone]`)) {
    experiences += `<div style="margin-left:1em; margin-bottom:0.5em;"><b>Référence ${refIdx+1}</b><br>`;
    experiences += `<b>Nom :</b> ${formData.get(`experiences[${i}][references][${refIdx}][nom]`) || '-'}<br>`;
    experiences += `<b>Prénom :</b> ${formData.get(`experiences[${i}][references][${refIdx}][prenom]`) || '-'}<br>`;
    experiences += `<b>Fonction :</b> ${formData.get(`experiences[${i}][references][${refIdx}][fonction]`) || '-'}<br>`;

    experiences += `<b>Email :</b> ${formData.get(`experiences[${i}][references][${refIdx}][email]`) || '-'}<br>`;
    experiences += `<b>Téléphone :</b> ${formData.get(`experiences[${i}][references][${refIdx}][telephone]`) || '-'}<br>`;
    experiences += `</div>`;
    refIdx++;
}
        experiences += `</div>`;
        i++;
    }
    document.getElementById('recap-experiences').innerHTML = experiences || '-';

}

function openProfilePreviewModal() {
    document.getElementById('profilePreviewModal').classList.remove('hidden');
    document.getElementById('profilePreviewContent').textContent = getProfileSummary();
}

function closeProfilePreviewModal() {
    document.getElementById('profilePreviewModal').classList.add('hidden');
}

// Affiche le modal au clic sur "Vérifier mon profil"
document.getElementById('previewProfileBtn').addEventListener('click', openProfilePreviewModal);

// Soumission du formulaire via le bouton du modal
const submitProfileBtn = document.getElementById('submitProfileBtn');
if (submitProfileBtn) {
    submitProfileBtn.addEventListener('click', function() {
        const previewBtn = document.getElementById('previewProfileBtn');
        let form = previewBtn?.closest('form') || document.querySelector('form');
        closeProfilePreviewModal();
        form.submit();
    });
}

</script>
<script>
// Nouvelle gestion visuelle des expériences et références (JS vanilla)
let experienceIndex = 0;
let referenceIndexes = {};

// Correction : assembler les dates JJ/MM/AAAA en AAAA-MM-JJ avant submit
function assembleExperienceDatesBeforeSubmit() {
    const form = document.querySelector('form');
    if (!form) return;
    form.addEventListener('submit', function(e) {
        document.querySelectorAll('.experience-card').forEach(card => {
            const idx = card.getAttribute('data-idx');
            if(idx === null) return;
            // Début
            
            const m = card.querySelector(`#experiences_${idx}_date_debut_mois`);
            const a = card.querySelector(`#experiences_${idx}_date_debut_annee`);
            const hiddenDebut = card.querySelector(`#experiences_${idx}_date_debut_full`);
            if(m && a && hiddenDebut) {
                if(m.value && a.value) {
                    hiddenDebut.value = `${a.value}-${m.value.padStart(2,'0')}`;
                } else {
                    hiddenDebut.value = '';
                }
                console.log('date_debut', hiddenDebut.name, hiddenDebut.value);
            }
            // Fin
            
            const mf = card.querySelector(`#experiences_${idx}_date_fin_mois`);
            const af = card.querySelector(`#experiences_${idx}_date_fin_annee`);
            const hiddenFin = card.querySelector(`#experiences_${idx}_date_fin_full`);
            if(mf && af && hiddenFin) {
                if(mf.value && af.value) {
                    hiddenFin.value = `${af.value}-${mf.value.padStart(2,'0')}`;
                } else {
                    hiddenFin.value = '';
                }
                console.log('date_fin', hiddenFin.name, hiddenFin.value);
            }
        });
    });
}
document.addEventListener('DOMContentLoaded', function() {
    assembleExperienceDatesBeforeSubmit();
    // Ajout : mise à jour dynamique du champ caché à chaque modification d'un champ date
    document.querySelectorAll('.experience-card').forEach((card, idx) => {
        const m = card.querySelector(`#experiences_${idx}_date_debut_mois`);
        const a = card.querySelector(`#experiences_${idx}_date_debut_annee`);
        const hiddenDebut = card.querySelector(`#experiences_${idx}_date_debut_full`);
        if(m && a && hiddenDebut) {
            const updateDebut = () => {
                if(m.value && a.value) {
                    hiddenDebut.value = `${a.value}-${m.value.padStart(2,'0')}`;
                } else {
                    hiddenDebut.value = '';
                }
            };
            m.addEventListener('input', updateDebut);
            a.addEventListener('input', updateDebut);
            updateDebut();
        }
        // Même chose pour la date de fin
        
        const mf = card.querySelector(`#experiences_${idx}_date_fin_mois`);
        const af = card.querySelector(`#experiences_${idx}_date_fin_annee`);
        const hiddenFin = card.querySelector(`#experiences_${idx}_date_fin_full`);
        if(mf && af && hiddenFin) {
            const updateFin = () => {
                if(mf.value && af.value) {
                    hiddenFin.value = `${af.value}-${mf.value.padStart(2,'0')}`;
                } else {
                    hiddenFin.value = '';
                }
            };
            mf.addEventListener('input', updateFin);
            af.addEventListener('input', updateFin);
            updateFin();
        }
    });
});
window.addExperienceCard = function addExperienceCard(data = {}) {
    const container = document.getElementById('experiencesContainer');
    const idx = experienceIndex++;
    referenceIndexes[idx] = 0;
    const card = document.createElement('div');
    card.className = 'experience-card bg-white rounded-xl shadow p-6 mb-8';
    card.setAttribute('data-idx', idx);
    card.innerHTML = `
        <div class="flex items-center gap-3 mb-4">
            <span class="text-2xl">🗂️</span>
            <div class="font-bold text-lg text-[#152C54] flex-1">Expérience ${idx + 1}</div>
            <button type="button" class="text-red-500 hover:text-red-700" onclick="this.closest('.card-experience').remove()">✕</button>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
    <div>
        <label class="block mb-1 text-sm font-bold text-[#152C54]" style="color:#152C54">Date début</label>
        <div class="flex gap-2">
            
            <input type="text" name="experiences[${idx}][date_debut_mois]" id="experiences_${idx}_date_debut_mois" maxlength="2" placeholder="MM" class="w-12 rounded-md border-gray-300 bg-[#E0E7FF] text-center" value="${data.date_debut_mois || ''}">
            
            <span class="self-center">/</span>
            
            <input type="text" name="experiences[${idx}][date_debut_annee]" id="experiences_${idx}_date_debut_annee" maxlength="4" placeholder="AAAA" class="w-16 rounded-md border-gray-300 bg-[#E0E7FF] text-center" value="${data.date_debut_annee || ''}">
            <input type="hidden" name="experiences[${idx}][date_debut]" id="experiences_${idx}_date_debut_full">
        </div>
    </div>
    <div>
        <label class="block mb-1 text-sm font-bold text-[#152C54]" style="color:#152C54">Date fin</label>
        <div class="flex gap-2">
            
            <input type="text" name="experiences[${idx}][date_fin_mois]" id="experiences_${idx}_date_fin_mois" maxlength="2" placeholder="MM" class="w-12 rounded-md border-gray-300 bg-[#E0E7FF] text-center" value="${data.date_fin_mois || ''}">
            
            <span class="self-center">/</span>
            
            <input type="text" name="experiences[${idx}][date_fin_annee]" id="experiences_${idx}_date_fin_annee" maxlength="4" placeholder="AAAA" class="w-16 rounded-md border-gray-300 bg-[#E0E7FF] text-center" value="${data.date_fin_annee || ''}">
            <input type="hidden" name="experiences[${idx}][date_fin]" id="experiences_${idx}_date_fin_full">
        </div>
    </div>
    <div>
        <label class="block mb-1 text-sm font-bold text-[#152C54]" style="color:#152C54">Société</label>
        <input type="text" name="experiences[${idx}][societe]" class="w-full bg-[#E0E7FF] rounded-md" value="${data.societe || ''}" />
    </div>
    <div>
        <label class="block mb-1 text-sm font-bold text-[#152C54]" style="color:#152C54">Secteur</label>
        <select name="experiences[${idx}][secteur]" class="w-full bg-[#E0E7FF] rounded-md">
            <option value="">Sélectionnez un secteur</option>
            @foreach($secteurs as $secteur)
                <option value="{{ $secteur }}">{{ $secteur }}</option>
            @endforeach
        </select>
    </div>
    <div>
        <label class="block mb-1 text-sm font-bold text-[#152C54]" style="color:#152C54">Poste</label>
        <input type="text" name="experiences[${idx}][poste]" class="w-full bg-[#E0E7FF] rounded-md" value="${data.poste || ''}" />
    </div>
    <div class="md:col-span-3">
        <label class="block mb-1 text-sm font-bold text-[#152C54]" style="color:#152C54">Détail expérience</label>
        <textarea name="experiences[${idx}][detail]" class="w-full bg-[#E0E7FF] rounded-md" rows="2">${data.detail || ''}</textarea>
    </div>
</div>
        <div class="mt-4">
            <div class="font-bold text-[#2748E9] mb-2 flex items-center gap-2"><span>📏</span> Références associées <span class="text-red-500">*</span></div>
            <div class="referencesContainer mb-2" id="referencesContainer_${idx}"></div>
            <button type="button" class="text-[#2748E9] hover:text-[#018FFD]" onclick="window.addReferenceRow(${idx})">+ Ajouter une référence</button>
        </div>
    `;
    card.classList.add('card-experience');
    container.appendChild(card);
    // Déclenche l'événement pour l'auto-tabulation JS
    document.dispatchEvent(new CustomEvent('experience:added', { detail: { idx } }));
    // Focus sur le premier champ du nouvel item, etc.
    // Ajouter une référence par défaut
    window.addReferenceRow(idx);

    // Appliquer la logique d’assemblage des dates sur cette carte
    assembleDatesForCard(card, idx);

    // Gestion auto-tab pour les dates (début et fin)
    function autoTabDynamicDateInputs(idx) {
        const fields = [
            [`experiences_${idx}_date_debut_jour`, `experiences_${idx}_date_debut_mois`, `experiences_${idx}_date_debut_annee`],
            [`experiences_${idx}_date_fin_jour`, `experiences_${idx}_date_fin_mois`, `experiences_${idx}_date_fin_annee`]
        ];
        fields.forEach(ids => {
            const [day, month, year] = ids.map(id => card.querySelector(`#${id}`));
            if(day && month && year) {
                day.addEventListener('input', function() { if(this.value.length === 2) month.focus(); });
                month.addEventListener('input', function() { if(this.value.length === 2) year.focus(); });
            }
        });
    }
    autoTabDynamicDateInputs(idx);
    // Synchronisation dynamique des références à chaque changement de societe/secteur
    const societeInput = card.querySelector(`input[name='experiences[${idx}][societe]']`);
    const secteurSelect = card.querySelector(`select[name='experiences[${idx}][secteur]']`);
    function syncReferencesFields() {
        const societe = societeInput ? societeInput.value : '';
        const secteur = secteurSelect ? secteurSelect.value : '';
        // Met à jour tous les champs cachés des références de cette expérience
        const refSocieteFields = card.querySelectorAll(`input[type='hidden'][name^='references[${idx}_'][name$='[societe]']`);
        const refSecteurFields = card.querySelectorAll(`input[type='hidden'][name^='references[${idx}_'][name$='[secteur]']`);
        refSocieteFields.forEach(input => input.value = societe);
        refSecteurFields.forEach(input => input.value = secteur);
    }
    if(societeInput) societeInput.addEventListener('input', syncReferencesFields);
    if(secteurSelect) secteurSelect.addEventListener('change', syncReferencesFields);
    // Synchronise à l'initialisation
    syncReferencesFields();
}

// Applique la logique d’assemblage des dates à une carte d'expérience donnée
function assembleDatesForCard(card, idx) {
    // Début
    const m = card.querySelector(`#experiences_${idx}_date_debut_mois`);
    const a = card.querySelector(`#experiences_${idx}_date_debut_annee`);
    const hiddenDebut = card.querySelector(`#experiences_${idx}_date_debut_full`);
    if(m && a && hiddenDebut) {
        const updateDebut = () => {
            if(m.value && a.value) {
                hiddenDebut.value = `${a.value}-${m.value.padStart(2,'0')}`;
            } else {
                hiddenDebut.value = '';
            }
        };
        m.addEventListener('input', updateDebut);
        a.addEventListener('input', updateDebut);
        updateDebut();
    }
    // Fin
    const mf = card.querySelector(`#experiences_${idx}_date_fin_mois`);
    const af = card.querySelector(`#experiences_${idx}_date_fin_annee`);
    const hiddenFin = card.querySelector(`#experiences_${idx}_date_fin_full`);
    if(mf && af && hiddenFin) {
        const updateFin = () => {
            if(mf.value && af.value) {
                hiddenFin.value = `${af.value}-${mf.value.padStart(2,'0')}`;
            } else {
                hiddenFin.value = '';
            }
        };
        mf.addEventListener('input', updateFin);
        af.addEventListener('input', updateFin);
        updateFin();
    }
}

window.addReferenceRow = function addReferenceRow(expIdx) {
    console.log('addReferenceRow appelé pour expIdx=', expIdx);
    if (!(expIdx in referenceIndexes)) {
        referenceIndexes[expIdx] = 0;
        console.warn('referenceIndexes['+expIdx+'] initialisé à 0');
    }
    const container = document.getElementById(`referencesContainer_${expIdx}`);
    if (!container) {
        alert('Erreur : container referencesContainer_'+expIdx+' introuvable !');
        console.error('Container referencesContainer_'+expIdx+' introuvable');
        return;
    }
    const refIdx = referenceIndexes[expIdx]++;
    // Récupère les valeurs de société et secteur de l'expérience parente
    let societe = '';
    let secteur = '';
    const expSocieteInput = document.querySelector(`input[name='experiences[${expIdx}][societe]']`);
    if(expSocieteInput) societe = expSocieteInput.value;
    const expSecteurInput = document.querySelector(`select[name='experiences[${expIdx}][secteur]']`);
    if(expSecteurInput) secteur = expSecteurInput.value;
    const refDiv = document.createElement('div');
    refDiv.className = 'bg-[#152C54] text-white rounded p-4 mb-3 grid grid-cols-1 md:grid-cols-5 gap-4 items-end';
    refDiv.innerHTML = `
        <div>
            <label class="text-xs font-bold text-white" style="color:white !important;">Nom</label>
            <input type="text" name="experiences[${expIdx}][references][${refIdx}][nom]" class="w-full bg-white rounded-md text-white" style="color:white;" required />
        </div>
        <div>
            <label class="text-xs font-bold text-white" style="color:white !important;">Prénom</label>
            <input type="text" name="experiences[${expIdx}][references][${refIdx}][prenom]" class="w-full bg-white rounded-md text-white" style="color:white;" required />
        </div>
        <div>
            <label class="text-xs font-bold text-white" style="color:white !important;">Fonction</label>
            <input type="text" name="experiences[${expIdx}][references][${refIdx}][fonction]" class="w-full bg-white rounded-md text-white" style="color:white;" />
        </div>
        <div>
            <label class="text-xs font-bold text-white" style="color:white !important;">Adresse mail</label>
            <input type="email" name="experiences[${expIdx}][references][${refIdx}][email]" class="w-full bg-white rounded-md text-white" style="color:white;" required />
        </div>
        <div>
            <label class="text-xs font-bold text-white" style="color:white !important;">Téléphone</label>
            <div class="relative">

                <input type="text" name="experiences[${expIdx}][references][${refIdx}][telephone]" class="w-full pl-10 bg-white rounded-md text-white" style="color:white;" placeholder="Téléphone" />
            </div>
        </div> 
        <div>
            <button type="button" class="text-red-500 hover:text-red-700 text-white" style="color:white;" onclick="this.closest('.grid').remove()">✕</button>
        </div>
        <input type="hidden" name="experiences[${expIdx}][references][${refIdx}][societe]" value="${societe}" />
<input type="hidden" name="experiences[${expIdx}][references][${refIdx}][secteur]" value="${secteur}" />
    `;
    container.appendChild(refDiv);
    console.log('Bloc référence ajouté à', container.id);
}
// Initialisation à l'ouverture de la page
if(document.getElementById('experiencesContainer')) {
    addExperienceCard();
}
</script>

                <style>
.experience-card label {
  color: #152C54 !important;
  background: none !important;
  mix-blend-mode: normal !important;
}
</style>
<script>
document.querySelectorAll('form').forEach(function(form) {
    form.addEventListener('submit', function(e) {
        let error = false;
        document.querySelectorAll('.referencesContainer').forEach(function(container) {
            container.querySelectorAll('.reference-card').forEach(function(card) {
                let nom = card.querySelector('[name*="[nom]"]')?.value.trim();
                let prenom = card.querySelector('[name*="[prenom]"]')?.value.trim();
                let email = card.querySelector('[name*="[email]"]')?.value.trim();
                if (!nom || !prenom || !email) {
                    error = true;
                    card.scrollIntoView({behavior: "smooth", block: "center"});
                    card.classList.add('border-red-500', 'border-2');
                    setTimeout(() => card.classList.remove('border-red-500', 'border-2'), 2000);
                }
            });
        });
        if (error) {
            e.preventDefault();
            alert('Merci de remplir tous les champs obligatoires pour chaque référence (nom, prénom, email).');
        }
    });
});
</script>
</form>
            </div>
        </div>
    </div>
    <script>
    // Gestion des compétences
    document.addEventListener('DOMContentLoaded', function() {
        const skillItems = document.querySelectorAll('.skill-item');
        const searchSkillsInput = document.getElementById('searchSkills');
        // Initialisation des compétences sélectionnées
        // Variables globales pour les compétences
        window.window.selectedSkills = [];
        window.skillsInput = document.getElementById('competencesInput');
        window.skillsInput.value = JSON.stringify(window.selectedSkills);

        // Fonction globale pour supprimer une compétence
        window.removeSkill = function(text, category) {
            window.selectedSkills = window.selectedSkills.filter(s => !(s.text === text && s.category === category));
            window.skillsInput.value = JSON.stringify(window.selectedSkills);
            window.updateSkillsDisplay();
        };

        document.querySelectorAll('.skill-item').forEach(item => {
            item.addEventListener('click', function() {
                const text = this.textContent.trim();
                const category = this.dataset.category;

                if (window.selectedSkills.length >= 10) {
                    document.getElementById('skillsWarning').classList.remove('hidden');
                    return;
                }

                if (!window.selectedSkills.find(s => s.text === text && s.category === category)) {
                    window.selectedSkills.push({ text, category });
                    window.skillsInput.value = JSON.stringify(window.selectedSkills);
                    updateSkillsDisplay();
                    document.getElementById('skillsWarning').classList.add('hidden');
                }
            });
        });

        // Fonction de recherche des compétences
        searchSkillsInput.addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase();
            const categories = document.querySelectorAll('.skills-category');

            categories.forEach(category => {
                const items = category.querySelectorAll('.skill-item');
                let hasVisibleItems = false;

                items.forEach(item => {
                    const text = item.textContent.trim().toLowerCase();
                    const matches = text.includes(searchTerm);
                    item.style.display = matches ? 'block' : 'none';
                    if (matches) hasVisibleItems = true;
                });

                // Afficher/masquer la catégorie entière
                category.style.display = hasVisibleItems ? 'block' : 'none';
            });
        });
    });

    // Gestion des expertises
    document.addEventListener('DOMContentLoaded', function() {
        const expertiseItems = document.querySelectorAll('.expertise-item');
        const searchInput = document.getElementById('searchExpertise');
        const selectedExpertiseContainer = document.getElementById('selectedExpertise');
        const expertiseInput = document.getElementById('expertise');
        let selectedExpertises = [];

        // Fonction pour mettre à jour l'input caché
        function updateExpertiseInput() {
            expertiseInput.value = JSON.stringify(selectedExpertises);
        }

        // Fonction pour ajouter une expertise
        function addExpertise(text, category) {
    if (selectedExpertises.length >= 10) {
        if (document.getElementById('expertiseWarning')) {
            document.getElementById('expertiseWarning').classList.remove('hidden');
        } else {
            alert("Vous avez atteint la limite de 10 types d'expertise.");
        }
        return;
    }
    if (!selectedExpertises.find(e => e.text === text && e.category === category)) {
        selectedExpertises.push({ text, category });
        updateExpertiseInput();
        updateSelectedExpertiseDisplay();
        if (document.getElementById('expertiseWarning')) {
            document.getElementById('expertiseWarning').classList.add('hidden');
        }
    }
}

        // Fonction pour supprimer une expertise
        function removeExpertise(text, category) {
            selectedExpertises = selectedExpertises.filter(e => !(e.text === text && e.category === category));
            updateExpertiseInput();
            updateSelectedExpertiseDisplay();
        }

        // ----- Gestion dynamique des compétences sélectionnées -----
window.window.selectedSkills = [];

// Génère le HTML des étoiles pour une compétence
function renderStars(skill, idx) {
    const level = skill.level || 0;
    let stars = '';
    for (let i = 1; i <= 5; i++) {
        stars += `<span class="star inline-block cursor-pointer text-xl ${i <= level ? 'text-yellow-400' : 'text-gray-300'}" style="${i <= level ? 'color: #facc15 !important;' : ''}" data-skill-idx="${idx}" data-star="${i}">&#9733;</span>`;
    }
    return stars;
}



// Met à jour le niveau de la compétence
window.setSkillLevel = function setSkillLevel(idx, level) {
    console.log('Avant:', window.selectedSkills[idx]);
    window.selectedSkills[idx].level = level;
    console.log('Après:', window.selectedSkills[idx]);
    updateSkillsDisplay();
    updateCompetencesInput();
}

const competencesInput = document.getElementById('competencesInput');

window.updateCompetencesInput = function updateCompetencesInput() {
    competencesInput.value = JSON.stringify(window.selectedSkills);
}

window.updateSkillsDisplay = function updateSkillsDisplay() {
    const selectedSkillsContainer = document.getElementById('selectedSkills');
    const skillsCounter = document.getElementById('skillsCounter');
    selectedSkillsContainer.innerHTML = '';
    skillsCounter.textContent = `${window.selectedSkills.length}/10 compétences`;
    window.selectedSkills.forEach((skill, idx) => {
        const skillElement = document.createElement('div');
        skillElement.className = 'bg-[#E0E7FF] rounded p-3';
        skillElement.innerHTML = `
            <div class="text-sm text-gray-600 mb-1">${skill.category}</div>
            <div class="flex items-center justify-between">
                <span class="text-sm font-medium">${skill.text}</span>
                <span>${renderStars(skill, idx)}</span>
                <button type="button" class="text-red-500 hover:text-red-700 ml-2" 
                    onclick="removeSkill('${skill.text}', '${skill.category}')">
                    ×
                </button>
            </div>
        `;
        selectedSkillsContainer.appendChild(skillElement);
    });
    // Message dynamique "vous pouvez encore ajouter X compétences"
    const skillsRemaining = document.getElementById('skillsRemaining');
    const skillsWarning = document.getElementById('skillsWarning');
    const remaining = 10 - window.selectedSkills.length;
    if (remaining > 0) {
        skillsRemaining.textContent = `Vous pouvez encore ajouter ${remaining} compétence${remaining > 1 ? 's' : ''}.`;
        skillsRemaining.classList.remove('hidden');
        skillsWarning.classList.add('hidden');
    } else {
        skillsRemaining.classList.add('hidden');
        skillsWarning.classList.remove('hidden');
    }
}
// Pour compatibilité : rediriger l'ancien appel
window.updateSelectedSkillsDisplay = function updateSelectedSkillsDisplay() { window.updateSkillsDisplay(); }

// Event delegation : gestion du clic sur les étoiles
if (document.getElementById('selectedSkills')) {
    document.getElementById('selectedSkills').addEventListener('click', function(e) {
        // Gestion des étoiles
        if (e.target.classList.contains('star')) {
            e.preventDefault();
            e.stopPropagation();
            const idx = parseInt(e.target.getAttribute('data-skill-idx'));
            const level = parseInt(e.target.getAttribute('data-star'));
            if (!isNaN(idx) && !isNaN(level) && window.selectedSkills[idx]) {
                setSkillLevel(idx, level);
            }
            return;
        }
        // Gestion de la croix (suppression)
        if (
            e.target.tagName === 'BUTTON' &&
            e.target.textContent.trim() === '×'
        ) {
            // On remonte au parent pour trouver le nom et la catégorie
            const skillDiv = e.target.closest('.flex.items-center.justify-between');
            if (skillDiv) {
                const skillName = skillDiv.querySelector('span.text-sm.font-medium').textContent;
                const skillCategory = skillDiv.parentElement.querySelector('.text-sm.text-gray-600').textContent;
                removeSkill(skillName, skillCategory);
            }
        }
    });
}



window.addSkill = function addSkill(skillLabel, skillCategory) {
    // Vérifie si déjà présente (par nom et catégorie)
    if (!selectedSkills.some(s => s.text === skillLabel && s.category === skillCategory) && selectedSkills.length < 10) {
        selectedSkills.push({ text: skillLabel, category: skillCategory, level: 0 });
        updateSkillsDisplay();
        updateCompetencesInput();
    }
}

window.removeSkill = function removeSkill(skillLabel, skillCategory) {
    selectedSkills = selectedSkills.filter(s => !(s.text === skillLabel && s.category === skillCategory));
    updateSkillsDisplay();
    updateCompetencesInput();
}

document.querySelectorAll('.skill-item').forEach(item => {
    item.addEventListener('click', function() {
        const skillLabel = this.textContent.trim();
        const skillCategory = this.dataset.category;
        addSkill(skillLabel, skillCategory);
    });
});

document.addEventListener('DOMContentLoaded', function() {
    try {
        window.selectedSkills = JSON.parse(competencesInput.value || '[]');
    } catch(e) {
        window.selectedSkills = [];
    }
    updateSelectedSkillsDisplay();
});
// ----- Fin gestion dynamique des compétences sélectionnées -----

// Fonction pour afficher les expertises sélectionnées
        function updateSelectedExpertiseDisplay() {
    if (document.getElementById('expertiseCounter')) {
        document.getElementById('expertiseCounter').textContent = `${selectedExpertises.length}/10 types d'expertise`;
    }
    if (document.getElementById('expertiseCounter')) {
        document.getElementById('expertiseCounter').textContent = `${selectedExpertises.length}/10 types d'expertise`;
    }
            selectedExpertiseContainer.innerHTML = '';
            selectedExpertises.forEach(expertise => {
                const div = document.createElement('div');
                div.className = 'flex items-center justify-between bg-[#E0E7FF] p-2 rounded';
                div.innerHTML = `
                    <div class="flex-1">
                        <div class="text-sm font-medium">${expertise.text}</div>
                        <div class="text-xs text-gray-500">${expertise.category}</div>
                    </div>
                    <button type="button" class="text-red-500 hover:text-red-700 ml-4" data-text="${expertise.text}" data-category="${expertise.category}" aria-label="Supprimer cette expertise">
                        ×
                    </button>
                `;
                selectedExpertiseContainer.appendChild(div);
                div.querySelector('button').addEventListener('click', function() {
                    removeExpertise(this.dataset.text, this.dataset.category);
                });
            });
        }

        // Ajouter les événements de clic sur les expertises
        expertiseItems.forEach(item => {
            item.addEventListener('click', function() {
                const text = this.textContent.trim();
                const category = this.dataset.category;
                addExpertise(text, category);
            });
        });

        // Fonction de recherche
        searchInput.addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase();
            const categories = document.querySelectorAll('.expertise-category');

            categories.forEach(category => {
                const items = category.querySelectorAll('.expertise-item');
                let hasVisibleItems = false;

                items.forEach(item => {
                    const text = item.textContent.trim().toLowerCase();
                    const matches = text.includes(searchTerm);
                    item.style.display = matches ? 'block' : 'none';
                    if (matches) hasVisibleItems = true;
                });

                // Afficher/masquer la catégorie entière
                category.style.display = hasVisibleItems ? 'block' : 'none';
            });
        });
    });

    // Initialisation de Tom Select pour le champ profil
    document.addEventListener('DOMContentLoaded', function() {
        new TomSelect('#profil', {
            sortField: {
                field: 'text',
                direction: 'asc'
            },
            placeholder: 'Rechercher un profil...',
            searchField: ['text'],
            maxOptions: 50,
            plugins: {
                clear_button: {
                    title: 'Effacer la sélection'
                }
            }
        });
    });

    // Gestion des étapes
    function showStep(step) {
        // Masquer toutes les étapes
        for (let i = 1; i <= 5; i++) {
            document.getElementById('step' + i).classList.add('hidden');
            document.getElementById('step' + i + 'Sidebar').classList.remove('active');
        }
        // Afficher l'étape demandée
        document.getElementById('step' + step).classList.remove('hidden');
        document.getElementById('step' + step + 'Sidebar').classList.add('active');
        
        // Mettre à jour la progression
        const progress = (step / 5) * 100;
        const progressBar = document.getElementById('progress');
        if(progressBar) progressBar.style.width = progress + '%';
        
        // Scroll en haut de page
        window.scrollTo({ top: 0, behavior: 'smooth' });
    }

    // Navigation entre les étapes
    function nextStep(step) {
        showStep(step);
    }

    function previousStep(step) {
        showStep(step);
    }

    // Navigation sidebar
    document.getElementById('step1Sidebar').onclick = () => showStep(1);
    document.getElementById('step2Sidebar').onclick = () => showStep(2);
    document.getElementById('step3Sidebar').onclick = () => showStep(3);
    document.getElementById('step4Sidebar').onclick = () => showStep(4);
    document.getElementById('step5Sidebar').onclick = () => showStep(5);

    // Initialisation
    showStep(1);

    // Fonction pour ajouter une ligne de référence
    // Suppression de la validation JS sur le téléphone principal du profil
// function validatePhone(input) { ... } supprimée

    function addExperienceRow() {
        const tbody = document.getElementById('experiencesBody');
        const rowCount = tbody.rows.length;
        const row = document.createElement('tr');

        // Créer les options pour le select
        const secteurOptions = secteurs.map(secteur => 
            `<option value="${secteur}">${secteur}</option>`
        ).join('');

        row.innerHTML = `
            <td><input type="date" name="experiences[${rowCount}][date_debut]" class="w-full bg-[#E0E7FF] rounded-md" /></td>
            <td><input type="date" name="experiences[${rowCount}][date_fin]" class="w-full bg-[#E0E7FF] rounded-md" /></td>
            <td><input type="text" name="experiences[${rowCount}][societe]" class="w-full bg-[#E0E7FF] rounded-md" /></td>
            <td>
                <select name="experiences[${rowCount}][secteur]" class="w-full bg-[#E0E7FF] rounded-md">
                    <option value="">Sélectionnez un secteur</option>
                    ${secteurOptions}
                </select>
            </td>
            <td><input type="text" name="experiences[${rowCount}][poste]" class="w-full bg-[#E0E7FF] rounded-md" /></td>
            <td><textarea name="experiences[${rowCount}][detail]" class="w-full bg-[#E0E7FF] rounded-md" rows="2"></textarea></td>
            <td><button type="button" onclick="this.closest('tr').remove()" class="text-red-500">Supprimer</button></td>
        `;
        tbody.appendChild(row);
    }


    </script>

<!-- Modal d'erreur validation -->
<div id="errorModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
  <div class="bg-white rounded-lg shadow-lg p-8 max-w-md w-full relative">
    <button onclick="closeErrorModal()" class="absolute top-2 right-2 text-gray-400 hover:text-gray-700 text-2xl">&times;</button>
    <h2 class="text-xl font-bold mb-4 text-red-600">Erreur de validation</h2>
    <div id="errorModalContent" class="text-gray-700 whitespace-pre-line"></div>
  </div>
</div>
    <style>
    .badge {
        background-color: #2748E9;
        color: white;
        padding: 2px 5px;
        border-radius: 50%;
        font-size: 12px;
        font-weight: bold;
    }
    .sidebar-step {
        transition: background-color 0.3s ease-in-out, color 0.3s ease-in-out;
    }
    .sidebar-step:hover {
        background-color: #E0E7FF;
        color: #2748E9;
    }
    .step {
        animation: fadeIn 0.5s ease-in-out;
    }
    @keyframes fadeIn {
        from {
            opacity: 0;
        }
        to {
            opacity: 1;
        }
    }
    </style>
    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/js/tom-select.complete.min.js"></script>
    <script>
    document.addEventListener('DOMContentLoaded', function () {
        const f = document.getElementById('profilForm');
        if (!f) { console.error('profilForm introuvable !'); return; }

        // Validation et assemblage de la date de naissance dans un seul handler
        f.addEventListener('submit', function(e) {
            // Centralisation de l'assemblage des dates
            assembleHiddenDates();
            // Par défaut, on considère la date incomplète
            let dateNaissanceValide = false;
            const hidden = document.getElementById('date_naissance');
            if (hidden && hidden.value) {
                dateNaissanceValide = true;
            }
            // Gestion de la date de diplôme
            let dateDiplomeValide = false;
            const hiddenDiplome = document.getElementById('date_diplome');
            if (hiddenDiplome && hiddenDiplome.value) {
                dateDiplomeValide = true;
            } 

            // --- Début validation ---
            let hasError = false;
            let errorMsg = '';
            // Réinitialise les erreurs
            f.querySelectorAll('.error-message').forEach(div => div.textContent = '');
            f.querySelectorAll('.border-red-500').forEach(el => el.classList.remove('border-red-500'));
            // Liste des champs à valider
            const fields = [
                { name: 'nom', message: "Le nom est requis." },
                { name: 'prenom', message: "Le prénom est requis." },
                { name: 'email', message: "Un email valide est requis.", regex: /^\S+@\S+\.\S+$/ },
                { name: 'sexe', message: "Le sexe est requis." },
                { name: 'date_disponibilite', message: "La date de disponibilité est requise." },
                // La validation de la date_naissance est gérée juste après
                { name: 'telephone', message: "Le téléphone est requis." },
                { name: 'profil', message: "Le profil est requis." },
                { name: 'experience', message: "L'expérience est requise." },
                { name: 'date_diplome', message: "La date de diplôme est requise." },
                { name: 'cv', message: "Veuillez ajouter un fichier CV." },
                { name: 'competences', message: "Sélectionnez au moins une compétence." },
                { name: 'expertise', message: "Sélectionnez au moins une expertise." },
            ];
            fields.forEach(field => {
                let input = f.querySelector(`[name="${field.name}"]`);
                if (input) {
                    const value = input.type === 'file' ? input.files.length : input.value.trim();
                    const isInvalid = (!value || value.length === 0) || (field.regex && !field.regex.test(input.value.trim()));
                    if (isInvalid) {
                        hasError = true;
                        input.classList.add('border-red-500');
                        const errorBox = input.closest('div').querySelector('.error-message');
                        if (errorBox) errorBox.textContent = field.message;
                        errorMsg += `- ${field.message}\n`;
                    }
                }
            });
            // Validation spécifique de la date de naissance (3 champs)
            if (!dateNaissanceValide) {
                hasError = true;
                // Ajoute un style d'erreur sur chaque champ date
                [jj, mm, aa].forEach(el => { if(el) el.classList.add('border-red-500'); });
                // Affiche le message d'erreur dans la div la plus proche du premier champ (jour)
                if (jj) {
                    const errorBox = jj.closest('div').querySelector('.error-message');
                    if (errorBox) errorBox.textContent = "La date de naissance est requise.";
                }
                errorMsg += `- La date de naissance est requise.\n`;
            }

            if (hasError) {
                e.preventDefault();
                // Affiche la popup d'erreur si elle existe
                const modal = document.getElementById('errorModal');
                const modalContent = document.getElementById('errorModalContent');
                if (modal && modalContent) {
                    modalContent.textContent = errorMsg.trim();
                    modal.classList.remove('hidden');
                } else {
                    alert(errorMsg.trim());
                }
                return false;
            }
            // --- Fin validation ---
        });
    });     


    // Permet de fermer le modal d'erreur
    function closeErrorModal() {
        const modal = document.getElementById('errorModal');
        if (modal) modal.classList.add('hidden');
    }
    </script>

                       
    </script>
    @endpush
<script>
function autoTabMonthToYear() {
    document.querySelectorAll('[id^="experiences_"][id$="_date_debut_mois"], [id^="experiences_"][id$="_date_fin_mois"]').forEach(function(moisInput) {
        if (!moisInput.dataset.autotab) {
            const anneeInput = document.getElementById(moisInput.id.replace('_mois', '_annee'));
            if (anneeInput) {
                moisInput.addEventListener('input', function() {
                    if (this.value.length === 2) anneeInput.focus();
                });
                moisInput.dataset.autotab = "1";
            }
        }
    });
}
autoTabMonthToYear();
const container = document.getElementById('experiencesContainer');
if (container && window.MutationObserver) {
    const observer = new MutationObserver(autoTabMonthToYear);
    observer.observe(container, { childList: true, subtree: true });
}
</script>
</x-app-layout>
