<x-admin-layout>
<x-slot name="header">
    <div class="flex justify-between items-center">
        <div class="flex items-center gap-2">
        <span class="text-3xl">🏢</span>
            <h2 class="font-semibold text-xl text-[#152C54] leading-tight">
                {{ __(' Gestion des sociétés') }}
            </h2>
        </div>
        <button type="button" onclick="document.getElementById('addSocieteModal').classList.remove('hidden')" class="px-5 py-2 bg-[#152C54] text-white rounded-lg shadow hover:bg-[#2748E9] transition">
            + Nouvelle société
        </button>
    </div>
</x-slot>
 <div class="flex min-h-screen bg-gradient-to-br from-[#152C54] via-[#152C54]/30 to-[#152C54]/10 overflow-hidden">

        <div class="flex-1 p-4 lg:p-8 max-w-6xl w-full">
            <!-- Statistiques sociétés -->
            <div class="mb-8">
                <div class="p-4 bg-white/80 rounded-xl shadow flex items-center gap-6 w-fit">
                    <div class="flex items-center gap-3">
                        <span class="text-3xl">🏢</span>
                        <div>
                            <div class="text-xs text-gray-500 font-semibold">Nombre de sociétés</div>
                            <div class="text-2xl font-bold text-[#152C54]">{{ $societes->count() }}</div>
                        </div>
                    </div>
                </div>
            </div>
             <!-- Barre de recherche et filtres -->
            <div class="bg-white rounded-xl shadow-sm p-4 mb-6">
                <div class="flex flex-col md:flex-row justify-between gap-4">
                    <div class="flex-1">
                        <div class="relative">
                            <input type="text" id="searchSociete" placeholder="Rechercher une société..." class="w-full pl-10 pr-4 py-2 rounded-lg border border-gray-300 focus:border-[#2748E9] focus:ring focus:ring-[#2748E9] focus:ring-opacity-50">
                            <span class="absolute left-3 top-2.5">🔍</span>
                        </div>
                    </div>
                    <div class="flex gap-4">
                        <select id="filterEtablissement" class="rounded-lg border border-gray-300 focus:border-[#2748E9] focus:ring focus:ring-[#2748E9] focus:ring-opacity-50">
    <option value="">Toutes les sociétés</option>
    @foreach($societes->pluck('nom')->unique()->filter()->sort() as $nomSociete)
        <option value="{{ $nomSociete }}">{{ $nomSociete }}</option>
    @endforeach
</select>
                        <a href="{{ route('admin.societes.exportSocietes') }}" class="bg-[#152C54] text-white px-4 py-2 rounded-md hover:bg-[#2748E9] transition-colors">
    Exporter les sociétés
</a>
<a href="{{ route('admin.societes.exportAllActions') }}" class="bg-[#152C54] text-white px-4 py-2 rounded-md hover:bg-[#2748E9] transition-colors">
    Exporter les actions
</a>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-xl shadow p-8">
                <div class="flex items-center justify-between mb-6">
                    <h1 class="text-2xl font-bold text-[#152C54]">Liste des sociétés</h1>
                    
                    
                </div>
                <div class="overflow-x-auto rounded-xl border border-[#E0E7FF] max-w-full">
    <table class="w-full divide-y divide-[#E0E7FF] table-fixed" style="min-width: 900px;">
        <thead>
            <tr class="bg-[#152C54] text-white">
                <th class="px-4 py-3 text-left text-xs font-bold uppercase tracking-wider">Nom</th>
                <th class="px-4 py-3 text-left text-xs font-bold uppercase tracking-wider">Adresse</th>
                <th class="px-4 py-3 text-left text-xs font-bold uppercase tracking-wider">SIREN</th>
                <th class="px-4 py-3 text-left text-xs font-bold uppercase tracking-wider">Code NAF</th>
                <th class="px-4 py-3"></th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-[#E0E7FF]">
            @forelse($societes as $societe)
                <tr class="@if($loop->even) bg-[#e0e7ef] @else bg-white @endif hover:bg-blue-100 transition-colors border-b border-gray-200" data-nom="{{ strtolower($societe->nom) }}" data-etablissement="{{ strtolower($societe->nom) }}">
                    <td class="px-4 py-3 text-sm text-[#152C54] font-semibold">{{ $societe->nom }}</td>
                    <td class="px-4 py-3 text-sm text-gray-900">{{ $societe->adresse }}</td>
                    <td class="px-4 py-3 text-sm text-gray-900">{{ $societe->siren }}</td>
                    <td class="px-4 py-3 text-sm text-gray-900">{{ $societe->code_naf }}</td>
                    <td class="px-4 py-3 flex items-center gap-3">
    <a href="{{ route('admin.societes.show', $societe->id) }}" class="text-[#152C54] hover:text-[#018FFD] transition-colors font-semibold">Voir</a>
    <button type="button" onclick="openEditSocieteModal(@js(['id'=>$societe->id,'nom'=>$societe->nom,'adresse'=>$societe->adresse,'siren'=>$societe->siren,'code_naf'=>$societe->code_naf]))" class="text-yellow-600 hover:text-yellow-800 transition-colors" title="Modifier">
    <svg xmlns="http://www.w3.org/2000/svg" class="inline w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536M9 13l6.586-6.586a2 2 0 112.828 2.828L11.828 15.828a2 2 0 01-2.828 0L9 13zm0 0V21h8" /></svg>
</button>
    <form action="{{ route('admin.societes.destroy', $societe->id) }}" method="POST" style="display:inline" onsubmit="return confirm('Supprimer cette société ?');">
        @csrf
        @method('DELETE')
        <button type="submit" class="text-red-600 hover:text-red-800 transition-colors" title="Supprimer">
            <svg xmlns="http://www.w3.org/2000/svg" class="inline w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
        </button>
    </form>
</td>
                </tr>
            @empty
                <tr><td colspan="5" class="text-center text-gray-400 py-6">Aucune société enregistrée.</td></tr>
            @endforelse
        </tbody>
    </table>
    <div class="mt-4">
        {{ $societes->links() }}
    </div>
</div>
            </div>
        </div>
    </div>
    <!-- Modal d'ajout de société -->
    <div id="addSocieteModal" class="fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-50 hidden">
        <div class="bg-white rounded-lg shadow-lg p-6 w-full max-w-md relative">
            <button type="button" onclick="document.getElementById('addSocieteModal').classList.add('hidden')" class="absolute top-2 right-2 text-gray-400 hover:text-gray-700 text-2xl">&times;</button>
            <h3 class="text-lg font-bold mb-4">Ajouter une société</h3>
            <form action="{{ route('admin.societes.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label class="block text-sm font-semibold mb-1">Nom</label>
                    <input type="text" name="nom" id="addSocieteNom" required autocomplete="off" class="w-full border rounded px-2 py-1 text-sm relative">
                </div>
                <div class="mb-3">
                    <label class="block text-sm font-semibold mb-1">Adresse</label>
                    <input type="text" name="adresse" class="w-full border rounded px-2 py-1 text-sm">
                </div>
                <div class="mb-3">
                    <label class="block text-sm font-semibold mb-1">SIREN</label>
                    <input type="text" name="siren" maxlength="9" class="w-full border rounded px-2 py-1 text-sm">
                </div>
                <div class="mb-3">
                    <label class="block text-sm font-semibold mb-1">Code NAF</label>
                    <input type="text" name="code_naf" maxlength="5" class="w-full border rounded px-2 py-1 text-sm">
                </div>
                <div class="flex justify-end gap-2 mt-4">
                    <button type="button" onclick="document.getElementById('addSocieteModal').classList.add('hidden')" class="px-4 py-2 bg-gray-200 text-[#152C54] rounded hover:bg-gray-300">Annuler</button>
                    <button type="submit" class="px-4 py-2 bg-[#152C54] text-white rounded hover:bg-[#2748E9]">Enregistrer</button>
                </div>
            </form>
        </div>
    </div>
@include('admin.partials.edit-societe-modal')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const editForm = document.getElementById('editSocieteForm');
    editForm.addEventListener('submit', function(e) {
        e.preventDefault();
        const id = document.getElementById('editSocieteId').value;
        const url = "{{ url('admin/societes') }}/" + id;
        editForm.action = url;
        editForm.submit();
    });
});
</script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('searchSociete');
        const filterEtab = document.getElementById('filterEtablissement');
        const rows = document.querySelectorAll('tbody tr[data-nom]');

        function filterRows() {
            const search = searchInput.value.toLowerCase();
            const etab = filterEtab.value.toLowerCase();
            rows.forEach(row => {
                const nom = row.getAttribute('data-nom');
                const etablissement = row.getAttribute('data-etablissement');
                const matchNom = nom.includes(search);
                const matchEtab = !etab || etablissement === etab;
                row.style.display = (matchNom && matchEtab) ? '' : 'none';
            });
        }
        searchInput.addEventListener('input', filterRows);
        filterEtab.addEventListener('change', filterRows);
    });
</script>
<script>
// Autocomplete SIRENE pour ajout société
let sireneAddTimeout;
document.addEventListener('DOMContentLoaded', function() {
    const nomInput = document.getElementById('addSocieteNom');
    if (nomInput) {
        nomInput.addEventListener('input', function() {
            clearTimeout(sireneAddTimeout);
            const query = this.value.trim();
            if (query.length < 3) {
                closeAddSocieteDropdown();
                return;
            }
            sireneAddTimeout = setTimeout(() => searchSireneAdd(query), 400);
        });
    }
});

function searchSireneAdd(query) {
    fetch('/api/sirene/search?query=' + encodeURIComponent(query))
        .then(response => response.json())
        .then(data => showAddSocieteDropdown(data))
        .catch(() => closeAddSocieteDropdown());
}

function showAddSocieteDropdown(societes) {
    closeAddSocieteDropdown();
    if (!Array.isArray(societes) || societes.length === 0) return;
    const nomInput = document.getElementById('addSocieteNom');
    const rect = nomInput.getBoundingClientRect();
    const dropdown = document.createElement('div');
    dropdown.id = 'add-societe-dropdown';
    dropdown.className = 'absolute bg-white border w-full z-50 rounded shadow max-h-60 overflow-auto';
    dropdown.style.left = `${rect.left + window.scrollX}px`;
    dropdown.style.top = `${rect.bottom + window.scrollY}px`;
    dropdown.style.width = `${rect.width}px`;
    societes.forEach(societe => {
        const item = document.createElement('div');
        item.className = 'px-3 py-2 hover:bg-[#E0E7FF] cursor-pointer';
        item.textContent = `${societe.nom} (${societe.siren})`;
        item.onclick = () => selectAddSocieteFromDropdown(societe);
        dropdown.appendChild(item);
    });
    document.body.appendChild(dropdown);
}

function closeAddSocieteDropdown() {
    const old = document.getElementById('add-societe-dropdown');
    if (old) old.remove();
}

function selectAddSocieteFromDropdown(societe) {
    document.getElementById('addSocieteNom').value = societe.nom || '';
    document.querySelector('input[name="adresse"]').value = societe.adresse || '';
    document.querySelector('input[name="siren"]').value = societe.siren || '';
    document.querySelector('input[name="code_naf"]').value = societe.code_naf || '';
    closeAddSocieteDropdown();
}

document.addEventListener('click', function(e) {
    const dropdown = document.getElementById('add-societe-dropdown');
    if (dropdown && !dropdown.contains(e.target) && e.target.id !== 'addSocieteNom') {
        closeAddSocieteDropdown();
    }
});
</script>

</x-admin-layout>
