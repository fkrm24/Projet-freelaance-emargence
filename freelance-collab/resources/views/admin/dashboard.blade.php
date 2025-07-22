<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-2">
            <span class="text-3xl">👥</span>
            <h2 class="font-semibold text-xl text-[#152C54] leading-tight">
                {{ __('Dashboard Admin') }}
            </h2>
        </div>
    </x-slot>

    <div class="flex min-h-screen bg-gradient-to-br from-[#152C54] via-[#152C54]/30 to-[#152C54]/10 overflow-hidden">
        <!-- Sidebar sticky à gauche -->
        <aside class="w-64 lg:w-72 h-screen sticky top-0 flex-shrink-0 flex flex-col items-center py-10 px-4 lg:px-6 border-r border-[#E0E7FF] bg-gradient-to-b from-[#E0E7FF] to-[#152C54]/10 z-10">
            <div class="mb-2">
                <img src="{{ asset('images/emargence-logo.jpeg') }}" alt="logo Émargence" class="w-28 h-28 rounded-full shadow-lg bg-white object-contain" />
            </div>
            <div class="flex flex-col gap-6 w-full mt-6">
                
                <div class="p-4 bg-[#e0e7ef] rounded-xl shadow-sm">
                    <h3 class="text-[#152C54] font-bold mb-2">Statistiques</h3>
                    <div class="grid grid-cols-2 gap-4">
                        <div class="bg-white p-3 rounded-lg shadow-sm">
                            <p class="text-sm text-gray-500">Candidats</p>
                            <p class="text-2xl font-bold text-[#152C54]">{{ $profils->count() }}</p>
                        </div>
                        <div class="bg-white p-3 rounded-lg shadow-sm">
                            <p class="text-sm text-gray-500">Expertises</p>
                            <p class="text-2xl font-bold text-[#152C54]">{{ $listeExpertises->count() }}</p>
                        </div>
                    </div>
                </div>
                <a href="{{ route('admin.societes.index') }}" class="flex items-center gap-2 p-4 bg-white text-[#152C54] rounded-xl hover:bg-[#2748E9] hover:text-white transition-colors">
    <span class="text-xl">🏢</span> Sociétés
</a>
<a href="{{ route('admin.contacts.index') }}" class="flex items-center gap-2 p-4 bg-white text-[#152C54] rounded-xl hover:bg-[#2748E9] hover:text-white transition-colors">
    <span class="text-xl">👥</span> Contacts
</a>
                <a href="{{ route('admin.export-csv') }}" class="flex items-center gap-2 p-4 bg-[#152C54] text-white rounded-xl hover:bg-[#2748E9] transition-colors">
                    <span class="text-xl">📊</span> Exporter en CSV
                </a>
            </div>
        </aside>

        <!-- Contenu principal -->
        <div class="flex-1 p-4 lg:p-8 overflow-hidden">
            <div class="bg-white rounded-xl shadow-sm p-4 lg:p-6 max-w-[calc(100vw-18rem)] lg:max-w-[calc(100vw-20rem)] overflow-hidden">
                <h2 class="text-2xl font-bold text-[#152C54] mb-6 flex items-center gap-2">
                    <span>📝</span> Liste des candidatures
                </h2>

                    <!-- Filtres -->
                <form action="{{ route('admin.dashboard') }}" method="GET" class="mb-6 bg-[#e0e7ef] p-4 rounded-xl grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                        <div>
                            <label class="block text-sm font-bold text-[#152C54]">Période de disponibilité</label>
                            <div class="grid grid-cols-2 gap-2 lg:gap-4">
                                <input type="date" name="date_debut" value="{{ request('date_debut') }}" class="mt-1 block w-full rounded-md border-gray-300 bg-[#e0e7ef] focus:border-[#2748E9] focus:ring-2 focus:ring-[#2748E9]">
                                <input type="date" name="date_fin" value="{{ request('date_fin') }}" class="mt-1 block w-full rounded-md border-gray-300 bg-[#e0e7ef] focus:border-[#2748E9] focus:ring-2 focus:ring-[#2748E9]">
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-[#152C54]">Profil</label>
                            <select name="profil" class="mt-1 block w-full rounded-md border-gray-300 bg-[#e0e7ef] focus:border-[#2748E9] focus:ring-2 focus:ring-[#2748E9]">
                                <option value="">Tous les profils</option>
                                @foreach($listeProfils as $profil)
                                    <option value="{{ $profil }}" {{ request('profil') == $profil ? 'selected' : '' }}>{{ $profil }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-[#152C54]">Type d'expertise</label>
                            <select name="expertise[]" multiple class="choices-expertise mt-1 block w-full rounded-md bg-[#e0e7ef] border-gray-300 shadow-sm focus:border-[#2748E9] focus:ring-2 focus:ring-[#2748E9]">
                                @foreach($listeExpertises as $expertise)
                                    @php
                                        $expertiseText = is_array($expertise) ? ($expertise['text'] ?? '') : $expertise;
                                        $selectedExpertises = (array)request('expertise', []);
                                    @endphp
                                    <option value="{{ $expertiseText }}" {{ in_array($expertiseText, $selectedExpertises) ? 'selected' : '' }}>{{ $expertiseText }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-[#152C54]">Compétence</label>
                            <select name="competence[]" multiple class="choices-competence mt-1 block w-full rounded-md bg-[#e0e7ef] border-gray-300 shadow-sm focus:border-[#2748E9] focus:ring-2 focus:ring-[#2748E9]">
                                @foreach($listeCompetences as $competence)
                                    @php
                                        $label = is_array($competence) ? ($competence['text'] ?? (isset($competence['label']) ? $competence['label'] : '') ) : $competence;
                                        $selectedCompetences = (array)request('competence', []);
                                    @endphp
                                    <option value="{{ $label }}" {{ in_array($label, $selectedCompetences) ? 'selected' : '' }}>{{ $label }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="lg:col-span-4 flex flex-col md:flex-row justify-between items-center gap-2">
    <button type="submit" class="px-4 py-2 bg-[#152C54] text-white rounded-md hover:bg-[#2748E9] transition-colors shadow-md flex items-center gap-2">
        <span>🔍</span> Filtrer
    </button>
    <input type="text" name="search" value="{{ request('search') }}" placeholder="Rechercher par nom ou entreprise..." class="w-full md:w-72 px-4 py-2 rounded-md border border-gray-300 bg-white focus:border-[#2748E9] focus:ring-2 focus:ring-[#2748E9] transition-colors" />
    <a href="{{ route('admin.export-csv') }}" class="bg-[#152C54] text-white px-4 py-2 rounded-md hover:bg-[#2748E9] transition-colors">
        Exporter en CSV
    </a>
</div>
                    </form>

                    <!-- Tableau -->
                    <div class="overflow-x-auto rounded-xl border border-[#E0E7FF] max-w-full">
                        <table class="w-full divide-y divide-[#E0E7FF] table-fixed" style="min-width: 1400px;">
                            <colgroup>
                                <col style="width: 50px"> <!-- ID -->
                                <col style="width: 120px"> <!-- Nom -->
                                <col style="width: 120px"> <!-- Prénom -->
                                <col style="width: 130px"> <!-- Téléphone -->
                                <col style="width: 130px"> <!-- Date de naissance -->
                                <col style="width: 130px"> <!-- Disponibilité -->
<col style="width: 130px"> <!-- Date modifiée -->
                                <col style="width: 150px"> <!-- Profil -->
                                <col style="width: 150px"> <!-- Expertise -->
                                <col style="width: 200px"> <!-- Compétences -->
                                <col style="width: 100px"> <!-- Expérience -->
                                <col style="width: 130px"> <!-- Diplôme -->
                                <col style="width: 80px"> <!-- CV -->
                                <col style="width: 120px"> <!-- Indice de confiance -->
                            </colgroup>
                            <thead>
    <tr class="bg-[#152C54] text-white">
        <th class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider">ID</th>
        <th class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider">Nom</th>
        <th class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider">Prénom</th>
        <th class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider">Téléphone</th>
        <th class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider">Date de naissance</th>
        <th class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider">Disponibilité</th>
        <th class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider">Date modifiée</th>
        <th class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider">Profil</th>
        <th class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider">Expertise</th>
        <th class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider">Compétences</th>
        <th class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider">Expérience</th>
        <th class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider">Diplôme</th>
        <th class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider">CV</th>
        <th class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider">Indice de confiance</th>
        <th class="px-4 py-3 text-left text-xs font-bold uppercase tracking-wider">Action</th>
    </tr>
</thead>
 <tbody class="bg-white divide-y divide-[#E0E7FF]">
     @foreach($profils as $profil)
        <tr class="@if($loop->even) bg-[#e0e7ef] @else bg-white @endif hover:bg-blue-100 transition-colors border-b border-gray-200">
            <td class="px-4 py-3 text-sm text-gray-500">{{ $profil->user->id }}</td>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $profil->nom }}</td>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $profil->prenom }}</td>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $profil->telephone }}</td>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $profil->date_naissance ? $profil->date_naissance->format('d/m/Y') : '' }}</td>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                {{ $profil->user->date_disponibilite ? \Carbon\Carbon::parse($profil->user->date_disponibilite)->format('d/m/Y') : '' }}
                @if($profil->user->date_disponibilite && $profil->taux_disponibilite)
                    ,
                @endif
                {{ $profil->taux_disponibilite ?? '' }}
            </td>
            
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                <form method="POST" action="{{ route('admin.users.update-date-modifiee', $profil->user->id) }}">
                    @csrf
        <input type="date" name="date_modifiee" value="{{ $profil->user->date_modifiee ? $profil->user->date_modifiee->format('Y-m-d') : '' }}" class="border px-2 py-1 rounded w-full" onchange="this.form.submit()">
    </form>
            </td>
            <td class="px-4 py-3 text-sm text-gray-900">
                <div class="max-h-24 overflow-y-auto break-words">
                    {{ $profil->profil }}
                </div>
            </td>
            <td class="px-4 py-3 text-sm text-gray-900">
                <div class="max-h-24 overflow-y-auto break-words">
                    @php
    $expertiseArray = is_array($profil->expertise) ? $profil->expertise : json_decode($profil->expertise, true);
@endphp
{{ collect($expertiseArray)->pluck('text')->implode(', ') }}
                </div>
            </td>
            <td class="px-4 py-3 text-sm text-gray-500">
               @php
                                     // Si c'est JSON, décode-le
                                     $competences = is_string($profil->competences) ? json_decode($profil->competences, true) : $profil->competences;
                                     @endphp
                                     @if(!empty($competences))
                                     @foreach($competences as $key => $competence)
                                     {{ $competence['text'] ?? '' }} 
                                     @if(!empty($competence['level']))
                                         ({{ $competence['level'] }}★)
                                     @endif
                                     @if(!$loop->last), @endif
                                     @endforeach
                                     @else
                                     -
                                     @endif
            </td>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
    {{ $profil->experience }} ans
    <button type="button"
            class="ml-2 px-2 py-1 bg-[#152C54] text-white rounded hover:bg-[#152C54] focus:outline-none"
            onclick="openExperienceModal({{ $profil->id }})"
            title="Voir les détails">
        +
    </button>
    <!-- Modal Expérience -->
    <div id="modal-experience-{{ $profil->id }}" class="fixed inset-0 z-50 hidden flex items-center justify-center bg-black bg-opacity-50">
        <div class="bg-white rounded-lg shadow-lg max-w-lg w-full p-6 relative">
            <button type="button" onclick="closeExperienceModal({{ $profil->id }})" class="absolute top-3 right-3 text-gray-400 hover:text-gray-700 text-2xl font-bold">&times;</button>
            <h3 class="text-lg font-bold text-[#152C54] mb-4">Détail des expériences</h3>
            <div class="overflow-y-auto max-h-96">
            @if($profil->experiences && $profil->experiences->count())
                @foreach($profil->experiences as $exp)
                    <div class="mb-4 border-b pb-2">
                        <div><span class="font-bold">Poste :</span> {{ $exp->poste }}</div>
                        <div><span class="font-bold">Entreprise :</span> {{ $exp->societe }}</div>
                        <div><span class="font-bold">Secteur :</span> {{ $exp->secteur }}</div>
                        <div><span class="font-bold">Début :</span> {{ $exp->date_debut ? \Carbon\Carbon::parse($exp->date_debut)->format('d/m/Y') : '' }}</div>
                        <div><span class="font-bold">Fin :</span> {{ $exp->date_fin ? \Carbon\Carbon::parse($exp->date_fin)->format('d/m/Y') : 'En cours' }}</div>
                        <div><span class="font-bold">Description :</span> {{ $exp->detail }}</div>
                    </div>
                @endforeach
            @else
                <div class="italic text-gray-400">Aucune expérience enregistrée.</div>
            @endif
            </div>
        </div>
    </div>
</td>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $profil->date_diplome ? $profil->date_diplome->format('d/m/Y') : '' }}</td>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                <a href="{{ route('admin.download-cv', $profil) }}" class="text-[#152C54] hover:text-[#018FFD] transition-colors flex items-center gap-1"> Voir CV</a>
            </td>
            <td class="px-4 py-3 text-sm text-gray-500">
                @php
    $colorMap = [
        'vert' => ['label' => '100%', 'bg' => '#22c55e'],
        'orange' => ['label' => '50%', 'bg' => '#fb923c'],
        'rouge' => ['label' => '25%', 'bg' => '#ef4444'],
        'noir' => ['label' => '0%', 'bg' => '#000'],
    ];
    $indices = $profil->confidenceIndices;
    $selected = $indices->where('is_active', true)->last();
@endphp
<div 
    x-data="{
        open: false,
        setToIncomplete() {
            fetch('{{ url('/admin/profils') }}/{{ $profil->id }}/confidence-indices/reset', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                }
            }).then(() => { window.location.reload(); });
        },
        activate(indiceId) {
            fetch('{{ url('/admin/profils') }}/{{ $profil->id }}/confidence-indices/' + indiceId + '/activate', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                }
            }).then(() => { window.location.reload(); });
        }
    }"
    class="relative"
>
    <button type="button" @click="open = !open"
        class="min-w-[80px] max-w-[110px] flex items-center justify-between border border-gray-300 rounded px-2 py-1 bg-white text-xs"
    >
        <span class="flex items-center gap-2">
            @if(!$selected)
                <span class="inline-block w-4 h-4 rounded-full" style="background: #ccc"></span>
                <span class="font-semibold">à compléter</span>
            @else
                @php $selectedColor = $colorMap[$selected->color_code ?? 'noir'] ?? $colorMap['noir']; @endphp
                <span class="inline-block w-4 h-4 rounded-full" style="background: {{ $selectedColor['bg'] }}"></span>
                <span class="font-semibold">{{ $selectedColor['label'] }}</span>
            @endif
        </span>
        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
        </svg>
    </button>
    <div x-show="open" @click.away="open = false"
        class="absolute z-10 mt-2 min-w-[80px] max-w-[110px] bg-white border border-gray-200 rounded shadow-lg text-xs"
        x-transition
        style="display: none;"
    >
        {{-- Choix "à compléter" --}}
        <div class="flex items-center gap-2 px-4 py-2 hover:bg-gray-100 cursor-pointer"
             @click="setToIncomplete(); open = false"
        >
            <span class="inline-block w-4 h-4 rounded-full" style="background: #ccc"></span>
            <span class="font-semibold">à compléter</span>
            @if(!$selected)
                <span class="ml-2 text-green-600 font-bold text-xs">Actif</span>
            @endif
        </div>
        {{-- Les autres choix --}}
        @foreach($indices as $indice)
            @php $c = $colorMap[$indice->color_code ?? 'noir'] ?? $colorMap['noir']; @endphp
            <div class="flex items-center gap-2 px-4 py-2 hover:bg-gray-100 cursor-pointer"
                 @click="activate({{ $indice->id }}); open = false"
            >
                <span class="inline-block w-4 h-4 rounded-full" style="background: {{ $c['bg'] }}"></span>
                <span class="font-semibold">{{ $c['label'] }}</span>
                @if($indice->is_active)
                    <span class="ml-2 text-green-600 font-bold text-xs">Actif</span>
                @endif
            </div>
        @endforeach
    </div>
</div>

                                        </td>
                                        <td class="px-4 py-3 text-center">
                                            <form action="{{ route('admin.profils.destroy', $profil->id) }}" method="POST" style="display:inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-500 hover:text-red-700" title="Supprimer" onclick="return confirm('Supprimer cette candidature ?')">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="inline w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                    </svg>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="mt-4">
                            {{ $profils->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
            </div>
        </div>
    </div>
<script>
function openExperienceModal(profilId) {
    const modal = document.getElementById('modal-experience-' + profilId);
    if (modal) {
        modal.classList.remove('hidden');
        document.body.classList.add('overflow-hidden');
    }
}
function closeExperienceModal(profilId) {
    const modal = document.getElementById('modal-experience-' + profilId);
    if (modal) {
        modal.classList.add('hidden');
        document.body.classList.remove('overflow-hidden');
    }
}
// Fermer le modal si on clique sur le fond noir
window.addEventListener('click', function(e) {
    document.querySelectorAll('[id^="modal-experience-"]').forEach(function(modal) {
        if (!modal.classList.contains('hidden') && e.target === modal) {
            modal.classList.add('hidden');
            document.body.classList.remove('overflow-hidden');
        }
    });
});
</script>
<!-- Choices.js CDN -->
<style>
/* Adoucir le style Choices.js pour harmoniser avec le filtre profils */
.choices__inner {
    border-radius: 0.375rem !important; /* rounded-md */
    background-color: #e0e7ef !important;
    min-height: 40px;
    border-color: #d1d5db;
    box-shadow: none;
}
.choices__list--dropdown, .choices__list[aria-expanded] {
    border-radius: 0.375rem !important;
    background-color: #fff;
    border-color: #d1d5db;
}
.choices__list--multiple .choices__item {
    background-color: #152C54 !important;
    color: #fff !important;
    border-radius: 0.375rem;
    border: none;
    margin-right: 4px;
    font-weight: 600;
    box-shadow: none;
}
</style>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/choices.js/public/assets/styles/choices.min.css" />
<script src="https://cdn.jsdelivr.net/npm/choices.js/public/assets/scripts/choices.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    new Choices('.choices-expertise', {
        removeItemButton: true,
        searchResultLimit: 10,
        placeholder: true,
        placeholderValue: 'Toutes les expertises',
        noResultsText: 'Aucun résultat',
        itemSelectText: 'Sélectionner',
        shouldSort: false
    });
    new Choices('.choices-competence', {
        removeItemButton: true,
        searchResultLimit: 10,
        placeholder: true,
        placeholderValue: 'Toutes les compétences',
        noResultsText: 'Aucun résultat',
        itemSelectText: 'Sélectionner',
        shouldSort: false
    });
});
</script>
</x-app-layout>

