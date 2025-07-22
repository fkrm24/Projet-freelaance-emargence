<x-app-layout>
    @push('styles')
    <style>
        .contact-card {
            transition: all 0.3s ease;
        }
        .contact-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        }
    </style>
    @endpush

    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div class="flex items-center gap-2">
                <span class="text-3xl">👥</span>
                <h2 class="font-semibold text-xl text-primary leading-tight">
                    {{ __('Contacts') }}
                </h2>
            </div>
            <button onclick="showAddContactModal()" class="px-4 py-2 bg-accent1 text-white rounded-md hover:bg-accent2 transition-colors duration-200">
                + Nouveau contact
            </button>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <!-- Filtres et recherche -->
                    <div class="flex justify-between items-center mb-6">
                        <div class="flex gap-4">
                            <input type="text" placeholder="Rechercher un contact..." class="rounded-md border-gray-300 shadow-sm focus:border-accent1 focus:ring focus:ring-accent1 focus:ring-opacity-50">
                            <select class="rounded-md border-gray-300 shadow-sm focus:border-accent1 focus:ring focus:ring-accent1 focus:ring-opacity-50">
                                <option value="">Tous les établissements</option>
                                <option value="clichy">Clichy</option>
                            </select>
                        </div>
                        <div class="flex gap-2">
                            <button class="px-3 py-1 text-sm border border-accent1 text-accent1 rounded hover:bg-accent1 hover:text-white transition-colors duration-200">
                                Exporter
                            </button>
                            <button class="px-3 py-1 text-sm border border-accent1 text-accent1 rounded hover:bg-accent1 hover:text-white transition-colors duration-200">
                                Importer
                            </button>
                        </div>
                    </div>

                    <!-- Liste des contacts -->
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @forelse($contacts as $contact)
                        <!-- Carte de contact -->
                        <div class="contact-card bg-white border border-gray-200 rounded-lg p-4">
                            <div class="flex justify-between items-start mb-4">
                                <div>
                                    <h3 class="text-lg font-semibold text-primary">{{ $contact->nom }}</h3>
                                    <p class="text-sm text-gray-600">Siren : {{ $contact->siren }}</p>
                                    <p class="text-sm text-gray-600">Code NAF : {{ $contact->code_naf }}</p>
                                </div>
                                <div class="flex gap-2">
                                    <button class="text-accent1 hover:text-accent2">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                        </svg>
                                    </button>
                                    <form action="{{ route('admin.contacts.destroy', $contact) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-500 hover:text-red-700" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce contact ?')">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </div>
                            <div class="space-y-2">
                                <p class="text-sm">
                                    <span class="text-gray-600">Adresse :</span><br>
                                    {{ $contact->adresse }}
                                </p>
                                <p class="text-sm">
                                    <span class="text-gray-600">TVA :</span> {{ $contact->tva }}
                                </p>
                            </div>
                        </div>
                        @empty
                        <div class="col-span-3 text-center py-8 text-gray-500">
                            Aucun contact trouvé. Cliquez sur "+ Nouveau contact" pour en ajouter un.
                        </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal d'ajout de contact -->
    <div id="addContactModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-semibold text-accent1">Nouveau contact</h3>
                <button onclick="closeAddContactModal()" class="text-gray-400 hover:text-gray-500">
                    <span class="text-2xl">&times;</span>
                </button>
            </div>
            <form id="addContactForm" action="{{ route('admin.contacts.store') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-sm font-medium text-gray-700">Nom de l'entreprise</label>
                    <input type="text" name="nom" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-accent1 focus:ring focus:ring-accent1 focus:ring-opacity-50" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">SIREN</label>
                    <input type="text" name="siren" maxlength="9" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-accent1 focus:ring focus:ring-accent1 focus:ring-opacity-50" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Code NAF</label>
                    <input type="text" name="code_naf" maxlength="5" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-accent1 focus:ring focus:ring-accent1 focus:ring-opacity-50" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Adresse</label>
                    <textarea name="adresse" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-accent1 focus:ring focus:ring-accent1 focus:ring-opacity-50" required></textarea>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Numéro de TVA</label>
                    <input type="text" name="tva" maxlength="13" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-accent1 focus:ring focus:ring-accent1 focus:ring-opacity-50" required>
                </div>
                <div class="flex justify-end gap-4">
                    <button type="button" onclick="closeAddContactModal()" class="px-4 py-2 bg-gray-200 text-gray-800 rounded-md hover:bg-gray-300">Annuler</button>
                    <button type="submit" class="px-4 py-2 bg-accent1 text-white rounded-md hover:bg-accent2">Enregistrer</button>

                </div>
            </form>
        </div>
    </div>

    @push('scripts')
<script>
function showAddContactModal() {
    document.getElementById('addContactModal').classList.remove('hidden');
}

function closeAddContactModal() {
    document.getElementById('addContactModal').classList.add('hidden');
}

// Validation JS du formulaire d'ajout de contact
const addContactForm = document.getElementById('addContactForm');
addContactForm.addEventListener('submit', function(e) {
    let errorMsg = '';
    const nom = addContactForm.elements['nom'].value.trim();
    const siren = addContactForm.elements['siren'].value.trim();
    const codeNaf = addContactForm.elements['code_naf'].value.trim();
    const adresse = addContactForm.elements['adresse'].value.trim();
    const tva = addContactForm.elements['tva'].value.trim();
    if (!nom) errorMsg += "- Le nom de l'entreprise est requis.\n";
    if (!siren || siren.length !== 9 || !/^[0-9]+$/.test(siren)) errorMsg += "- Le SIREN doit comporter 9 chiffres.\n";
    if (!codeNaf || codeNaf.length !== 5) errorMsg += "- Le code NAF doit comporter 5 caractères.\n";
    if (!adresse) errorMsg += "- L'adresse est requise.\n";
    if (!tva) errorMsg += "- Le numéro de TVA est requis.\n";
    if (errorMsg) {
        alert("Merci de corriger les erreurs suivantes avant d'envoyer :\n\n" + errorMsg);
        e.preventDefault();
    }
});

// Fermer le modal si on clique en dehors
    document.getElementById('addContactModal').addEventListener('click', function(e) {
        if (e.target === this) {
            closeAddContactModal();
        }
    });
</script>
@endpush
</x-app-layout>
