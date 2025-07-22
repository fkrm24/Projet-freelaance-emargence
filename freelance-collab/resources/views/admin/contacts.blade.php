<x-admin-layout>
    <div class="min-h-screen bg-gradient-to-br from-[#152C54] via-[#e0e7ef] to-[#F6F8FF] overflow-hidden">
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div class="flex items-center gap-2">
                <span class="text-3xl">👥</span>
                <h2 class="font-semibold text-xl text-[#152C54] leading-tight">
                    {{ __('Gestion des contacts') }}
                </h2>
            </div>
            <button onclick="showAddContactModal()" class="px-4 py-2 bg-[#152C54] text-white rounded-md hover:bg-[#2748E9] transition-colors">
                + Nouveau contact
            </button>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Statistiques contacts -->
            <div class="mb-8">
                <div class="p-4 bg-white/80 rounded-xl shadow flex items-center gap-6 w-fit">
                    <div class="flex items-center gap-3">
                        <span class="text-3xl">👥</span>
                        <div>
                            <div class="text-xs text-gray-500 font-semibold">Nombre de contacts</div>
                            <div class="text-2xl font-bold text-[#152C54]">{{ $sidebarContactsCount }}</div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Barre de recherche et filtres -->
            <div class="bg-white rounded-xl shadow-sm p-4 mb-6">
                <div class="flex flex-col md:flex-row justify-between gap-4">
                    <div class="flex-1">
                        <div class="relative">
                            <input type="text" id="searchContact" placeholder="Rechercher un contact..." class="w-full pl-10 pr-4 py-2 rounded-lg border border-gray-300 focus:border-[#2748E9] focus:ring focus:ring-[#2748E9] focus:ring-opacity-50">
                            <span class="absolute left-3 top-2.5">🔍</span>
                        </div>
                    </div>
                    <div class="flex gap-4">
                        <select id="filterContactNom" class="rounded-lg border border-gray-300 focus:border-[#2748E9] focus:ring focus:ring-[#2748E9] focus:ring-opacity-50">
    <option value="">Tous les contacts</option>
    @php
        $refItems = ($references instanceof \Illuminate\Pagination\AbstractPaginator) ? $references->items() : $references;
        $manItems = (isset($manualContacts) && $manualContacts instanceof \Illuminate\Pagination\AbstractPaginator) ? $manualContacts->items() : (isset($manualContacts) ? $manualContacts : []);
        $allContacts = collect($refItems)->map(function($r) { return strtolower(trim($r->nom . ' ' . $r->prenom)); });
        if(!empty($manItems)) {
            $allContacts = $allContacts->merge(collect($manItems)->map(function($c) { return strtolower(trim($c->nom . ' ' . $c->prenom)); }));
        }
        $allContacts = $allContacts->unique()->filter()->sort();
    @endphp
    @foreach($allContacts as $contactNom)
        <option value="{{ $contactNom }}">{{ ucwords($contactNom) }}</option>
    @endforeach
</select>
                        <a href="{{ route('admin.contacts.export') }}" class="px-4 py-2 bg-[#152C54] text-white rounded-lg hover:bg-[#2748E9] transition">
                            Exporter les contacts
                        </a>
                    </div>  
                </div>
            </div>

            <!-- Liste des contacts -->
            <div class="overflow-x-auto rounded-xl border border-[#E0E7FF] max-w-full">
                <table class="w-full divide-y divide-[#E0E7FF] table-fixed" style="min-width: 900px;">
                    <thead>
                        <tr class="bg-[#152C54] text-white">
                            <th class="px-4 py-3 text-left text-xs font-bold uppercase tracking-wider">Société</th>
                            <th class="px-4 py-3 text-left text-xs font-bold uppercase tracking-wider">Secteur</th>
                            <th class="px-4 py-3 text-left text-xs font-bold uppercase tracking-wider">Nom Référence</th>
                            <th class="px-4 py-3 text-left text-xs font-bold uppercase tracking-wider">Prénom Référence</th>
                            <th class="px-4 py-3 text-left text-xs font-bold uppercase tracking-wider">Fonction</th>
                            <th class="px-4 py-3 text-left text-xs font-bold uppercase tracking-wider">Email</th>
                            <th class="px-4 py-3 text-left text-xs font-bold uppercase tracking-wider">Téléphone</th>
                            <th class="px-4 py-3 text-left text-xs font-bold uppercase tracking-wider">Action</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-[#E0E7FF]">
                        @forelse($references as $reference)
                        <tr class="@if($loop->even) bg-[#e0e7ef] @else bg-white @endif hover:bg-blue-100 transition-colors border-b border-gray-200" data-nom="{{ strtolower($reference->nom) }}" data-prenom="{{ strtolower($reference->prenom) }}" data-contact="{{ strtolower(trim($reference->nom . ' ' . $reference->prenom)) }}">
                            <td class="px-4 py-3 text-sm text-[#152C54] font-semibold">{{ $reference->experience->societe ?? '' }}</td>
                            <td class="px-4 py-3 text-sm text-gray-500">{{ $reference->experience->secteur ?? '' }}</td>
                            <td class="px-4 py-3 text-sm text-gray-500">
                                <a href="{{ url('/admin/contacts/reference/' . $reference->id) }}" class="text-blue-700 hover:underline">
                                    {{ $reference->nom }}
                                </a>
                            </td>
                            <td class="px-4 py-3 text-sm text-gray-500">
                                <a href="{{ url('/admin/contacts/reference/' . $reference->id) }}" class="text-blue-700 hover:underline">
                                    {{ $reference->prenom }}
                                </a>
                            </td>
                            <td class="px-4 py-3 text-sm text-gray-500">{{ $reference->fonction }}</td>
                            <td class="px-4 py-3 text-sm text-gray-500" style="word-break:break-all;white-space:normal;">{{ $reference->email }}</td>
                            <td class="px-4 py-3 text-sm text-gray-500">{{ $reference->telephone }}</td>
                            <td class="px-4 py-3 text-sm flex gap-2">
                                <button type="button" onclick='editReferenceContactModal(@json($reference))' class="text-blue-500 hover:text-blue-700" title="Modifier">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="inline w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536M16.5 7.5l-9 9V21h4.5l9-9a2.121 2.121 0 00-3-3z" /></svg>
                                </button>
                                <form action="{{ route('admin.contacts.destroy', ['reference' => $reference->id]) }}" method="POST" style="display:inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:text-red-700" title="Supprimer" onclick="return confirm('Supprimer ce contact ?')"><svg xmlns="http://www.w3.org/2000/svg" class="inline w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg></button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        @endforelse
                        @if(isset($manualContacts) && $manualContacts->count())
                            @foreach($manualContacts as $contact)
                            <tr class="@if($loop->even) bg-[#e0e7ef] @else bg-white @endif hover:bg-blue-100 transition-colors border-b border-gray-200" data-nom="{{ strtolower($contact->nom) }}" data-prenom="{{ strtolower($contact->prenom) }}" data-contact="{{ strtolower(trim($contact->nom . ' ' . $contact->prenom)) }}">
                                <td class="px-4 py-3 text-sm text-[#152C54] font-semibold">{{ $contact->societe }}</td>
                                <td class="px-4 py-3 text-sm text-gray-500">{{ $contact->secteur }}</td>
                                <td class="px-4 py-3 text-sm text-gray-500">
                                    <a href="{{ url('/admin/contacts/manual/' . $contact->id) }}" class="text-blue-700 hover:underline">
                                        {{ $contact->nom }}
                                    </a>
                                </td>
                                <td class="px-4 py-3 text-sm text-gray-500">
                                    <a href="{{ url('/admin/contacts/manual/' . $contact->id) }}" class="text-blue-700 hover:underline">
                                        {{ $contact->prenom }}
                                    </a>
                                </td>
                                <td class="px-4 py-3 text-sm text-gray-500">{{ $contact->fonction }}</td>
                                <td class="px-4 py-3 text-sm text-gray-500" style="word-break:break-all;white-space:normal;">{{ $contact->email }}</td>
                                <td class="px-4 py-3 text-sm text-gray-500">{{ $contact->telephone }}</td>
                                <td class="px-4 py-3 text-sm flex gap-2">
                                    <button type="button" onclick='editManualContactModal(@json($contact))' class="text-blue-500 hover:text-blue-700" title="Modifier">
  <svg xmlns="http://www.w3.org/2000/svg" class="inline w-5 h-5 pointer-events-none" fill="none" viewBox="0 0 24 24" stroke="currentColor">
    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536M9 13l6.586-6.586a2 2 0 112.828 2.828L11.828 15.828a2 2 0 01-2.828 0L5 11.828a2 2 0 010-2.828L9 13z" />
  </svg>
</button>
                                    <form action="{{ route('admin.manualcontacts.destroy', ['manualcontact' => $contact->id]) }}" method="POST" style="display:inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-500 hover:text-red-700" title="Supprimer" onclick="return confirm('Supprimer ce contact ?')"><svg xmlns="http://www.w3.org/2000/svg" class="inline w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg></button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        @endif
                        @if($references->isEmpty() && (!isset($manualContacts) || $manualContacts->isEmpty()))
                            <tr>
                                <td colspan="8" class="px-4 py-3 text-sm text-gray-500 text-center">Aucun contact trouvé.</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
                <div class="mt-4">
                    {{ $references->links() }}
                </div>
                <div class="mt-4">
                    {{ $manualContacts->links() }}
                </div>
            </div>
        </div>
    </div>

    <!-- Modal d'ajout/modification de contact -->
    <div id="contactModal" class="fixed inset-0 flex items-center justify-center bg-gray-900 bg-opacity-60 hidden z-50">
        <div class="relative p-5 border w-96 shadow-lg rounded-md bg-white z-10">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-semibold text-[#152C54]" id="modalTitle">Nouveau contact</h3>
                <button type="button" onclick="closeContactModal()" class="text-gray-400 hover:text-gray-500">
                    <span class="text-2xl">&times;</span>
                </button>
            </div>
            <form id="contactForm" action="{{ route('admin.contacts.store') }}" method="POST" class="space-y-4">
                @csrf
                <div id="methodField"></div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Société</label>
<input type="text" name="societe" id="societe" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#2748E9] focus:ring focus:ring-[#2748E9] focus:ring-opacity-50" required>
                </div>
                <div class="grid grid-cols-2 gap-4">
    <div>
        <label class="block text-sm font-medium text-gray-700">Secteur</label>
        <input type="text" name="secteur" id="secteur" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#2748E9] focus:ring focus:ring-[#2748E9] focus:ring-opacity-50" required>
    </div>
    <div>
        <label class="block text-sm font-medium text-gray-700">Fonction</label>
        <input type="text" name="fonction" id="fonction" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#2748E9] focus:ring focus:ring-[#2748E9] focus:ring-opacity-50" required>
    </div>
</div>
<div class="grid grid-cols-2 gap-4">
    <div>
        <label class="block text-sm font-medium text-gray-700">Nom</label>
        <input type="text" name="nom" id="nom" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#2748E9] focus:ring focus:ring-[#2748E9] focus:ring-opacity-50" required>
    </div>
    <div>
        <label class="block text-sm font-medium text-gray-700">Prénom</label>
        <input type="text" name="prenom" id="prenom" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#2748E9] focus:ring focus:ring-[#2748E9] focus:ring-opacity-50" required>
    </div>
</div>
<div class="grid grid-cols-2 gap-4">
    <div>
        <label class="block text-sm font-medium text-gray-700">Email</label>
        <input type="email" name="email" id="email" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#2748E9] focus:ring focus:ring-[#2748E9] focus:ring-opacity-50" required>
    </div>
    <div>
        <label class="block text-sm font-medium text-gray-700">Téléphone</label>
        <input type="text" name="telephone" id="telephone" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#2748E9] focus:ring focus:ring-[#2748E9] focus:ring-opacity-50" required pattern="0[67][0-9]{8}" maxlength="10" oninput="validateFrenchPhone(this)">
<div id="telephone-error" class="text-red-500 text-sm mt-1 hidden">Le numéro doit commencer par 06 ou 07 et comporter 10 chiffres.</div>
    </div>
</div>
                
                
                <div class="flex justify-end gap-4">
                    <button type="button" onclick="closeContactModal()" class="px-4 py-2 bg-gray-200 text-gray-800 rounded-md hover:bg-gray-300">
                        Annuler
                    </button>
                    <button type="submit" class="px-4 py-2 bg-[#2748E9] text-white rounded-md hover:bg-[#018FFD]">
                        Enregistrer
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('searchContact');
            document.getElementById('modalTitle').textContent = 'Nouveau contact';
            document.getElementById('contactForm').reset();
            document.getElementById('contactForm').action = "{{ route('admin.contacts.store') }}";
            document.getElementById('methodField').innerHTML = '';
            document.getElementById('contactModal').classList.remove('hidden');
        });

        function editContact(id) {
            document.getElementById('modalTitle').textContent = 'Modifier le contact';
            document.getElementById('contactForm').action = `/admin/contacts/${id}`;
            document.getElementById('methodField').innerHTML = '@method("PUT")';
            fetch(`/admin/contacts/${id}`)
                .then(response => response.json())
                .then(contact => {
                    document.getElementById('nom').value = contact.nom;
                    document.getElementById('siren').value = contact.siren;
                    document.getElementById('code_naf').value = contact.code_naf;
                    document.getElementById('adresse').value = contact.adresse;
                    document.getElementById('contactModal').classList.remove('hidden');
                });
        }

        window.closeContactModal = function() {
            document.getElementById('contactModal').classList.add('hidden');
        };

        document.getElementById('contactModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeContactModal();
            }
        });

        window.editManualContactModal = function(contact) {
            document.getElementById('modalTitle').textContent = 'Modifier le contact';
            document.getElementById('contactForm').action = `/admin/manualcontacts/${contact.id}`;
            document.getElementById('methodField').innerHTML = '<input type="hidden" name="_method" value="PUT">';
            document.getElementById('societe').value = contact.societe;
            document.getElementById('secteur').value = contact.secteur;
}

function editContact(id) {
    document.getElementById('modalTitle').textContent = 'Modifier le contact';
    document.getElementById('contactForm').action = `/admin/contacts/${id}`;
    document.getElementById('methodField').innerHTML = '@method("PUT")';
    fetch(`/admin/contacts/${id}`)
        .then(response => response.json())
        .then(contact => {
            document.getElementById('nom').value = contact.nom;
            document.getElementById('siren').value = contact.siren;
            document.getElementById('code_naf').value = contact.code_naf;
            document.getElementById('adresse').value = contact.adresse;
            document.getElementById('contactModal').classList.remove('hidden');
        });
}

window.closeContactModal = function() {
    document.getElementById('contactModal').classList.add('hidden');
};

document.getElementById('contactModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeContactModal();
    }
});

<script>
// Filtrage dynamique contacts et édition contact
window.editManualContactModal = function(contact) {
    console.log('editManualContactModal called with:', contact);
    document.getElementById('modalTitle').textContent = 'Modifier le contact';
    document.getElementById('contactForm').action = `/admin/manualcontacts/${contact.id}`;
    document.getElementById('methodField').innerHTML = '<input type="hidden" name="_method" value="PUT">';
    document.getElementById('societe').value = contact.societe;
    document.getElementById('secteur').value = contact.secteur;
    document.getElementById('nom').value = contact.nom;
    document.getElementById('prenom').value = contact.prenom;
    document.getElementById('fonction').value = contact.fonction;
    document.getElementById('email').value = contact.email;
    document.getElementById('telephone').value = contact.telephone;
    document.getElementById('contactModal').classList.remove('hidden');
}


    console.log('editManualContactModal called with:', contact);
    document.getElementById('modalTitle').textContent = 'Modifier le contact';
    document.getElementById('contactForm').action = `/admin/manualcontacts/${contact.id}`;
    document.getElementById('methodField').innerHTML = '<input type="hidden" name="_method" value="PUT">';
    document.getElementById('societe').value = contact.societe;
    document.getElementById('secteur').value = contact.secteur;
    document.getElementById('nom').value = contact.nom;
    document.getElementById('prenom').value = contact.prenom;
    document.getElementById('fonction').value = contact.fonction;
    document.getElementById('email').value = contact.email;
    document.getElementById('telephone').value = contact.telephone;
    document.getElementById('contactModal').classList.remove('hidden');
}

document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('searchContact');
    const filterContact = document.getElementById('filterContactNom');
    const rows = document.querySelectorAll('tbody tr[data-contact]');
    function filterRows() {
        const search = searchInput.value.toLowerCase();
        const selected = filterContact.value;
        rows.forEach(row => {
            const nom = row.getAttribute('data-nom');
            const prenom = row.getAttribute('data-prenom');
            const contactFull = row.getAttribute('data-contact');
            const matchSearch = nom.includes(search) || prenom.includes(search) || contactFull.includes(search);
            const matchSelect = !selected || contactFull === selected;
            row.style.display = (matchSearch && matchSelect) ? '' : 'none';
        });
    }
    searchInput.addEventListener('input', filterRows);
    filterContact.addEventListener('change', filterRows);
    filterRows();
});
</script>
<script>
function validateFrenchPhone(input) {
    const value = input.value;
    const errorId = input.id + '-error';
    const errorDiv = document.getElementById(errorId);
    const regex = /^0[67][0-9]{8}$/;
    if (value.length === 10 && regex.test(value)) {
        if (errorDiv) errorDiv.classList.add('hidden');
        input.setCustomValidity('');
    } else {
        if (errorDiv) errorDiv.classList.remove('hidden');
        input.setCustomValidity('Le numéro doit commencer par 06 ou 07 et comporter 10 chiffres.');
    }
}
window.closeContactModal = function() {
    document.getElementById('contactModal').classList.add('hidden');
};
window.showAddContactModal = function() {
    document.getElementById('modalTitle').textContent = 'Nouveau contact';
    document.getElementById('contactForm').reset();
    document.getElementById('contactForm').action = "{{ route('admin.contacts.store') }}";
    document.getElementById('methodField').innerHTML = '';
    document.getElementById('contactModal').classList.remove('hidden');
}
</script>
<script>
window.editReferenceContactModal = function(reference) {
    console.log('editReferenceContactModal called with:', reference);
    document.getElementById('modalTitle').textContent = 'Modifier le contact';
    document.getElementById('contactForm').action = `/admin/contacts/${reference.id}`;
    document.getElementById('methodField').innerHTML = '<input type="hidden" name="_method" value="PUT">';
    document.getElementById('societe').value = reference.experience ? reference.experience.societe : '';
    document.getElementById('secteur').value = reference.experience ? reference.experience.secteur : '';
    document.getElementById('nom').value = reference.nom;
    document.getElementById('prenom').value = reference.prenom;
    document.getElementById('fonction').value = reference.fonction;
    document.getElementById('email').value = reference.email;
    document.getElementById('telephone').value = reference.telephone;
    document.getElementById('contactModal').classList.remove('hidden');
};
</script>
</x-admin-layout>
