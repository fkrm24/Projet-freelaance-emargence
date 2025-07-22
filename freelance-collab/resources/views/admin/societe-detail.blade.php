<x-admin-layout>
<div class="min-h-screen bg-gradient-to-br from-[#152C54] via-[#E0E7FF] to-[#152C54]/10 overflow-hidden py-10 pl-0 md:pl-20 pr-0 md:pr-20">
  <div class="max-w-6xl mx-auto w-full space-y-8">
    <!-- Bloc Infos Société -->
    <a href="{{ route('admin.societes.index') }}" class="mt-4 inline-block text-white hover:underline">← Retour à la liste</a>
    <div class="bg-white rounded-xl shadow p-6 flex flex-col md:flex-row gap-8 items-start">
     
      <div class="flex-1">
        <div class="flex flex-col md:flex-row md:items-center md:gap-8 mb-2">
          <div class="text-xl font-bold text-[#152C54]">{{ $contact->nom }}</div>
          <div class="text-gray-500 md:ml-8">
            @if($contact->adresse)
              <div><span class="font-semibold">Adresse :</span> {{ $contact->adresse }}</div>
            @endif
          </div>
        </div>
        <div class="flex flex-wrap gap-8 text-sm mt-2">
          @if($contact->siren)
            <div><span class="font-semibold">Siren :</span> {{ $contact->siren }}</div>
          @endif
          @if($contact->code_naf)
            <div><span class="font-semibold">Code NAF :</span> {{ $contact->code_naf }}</div>
          @endif
          @if($contact->tva)
            <div><span class="font-semibold">Numéro de TVA :</span> {{ $contact->tva }}</div>
          @endif
        </div>
      </div>
    </div>
    <!-- Bloc Établissements -->
    
    <!-- Bloc Contact -->
    <div class="bg-white rounded-xl shadow p-6 w-full">
      <div class="font-semibold text-[#152C54] mb-4 text-lg flex items-center gap-2">
        <span>👤</span> Contact
      </div>
      @if(session('success'))
        <div class="mb-4 px-4 py-2 rounded bg-[#152C54] text-white font-semibold">{{ session('success') }}</div>
      @endif
      @if(session('error'))
        <div class="mb-4 px-4 py-2 rounded bg-red-600 text-white font-semibold">{{ session('error') }}</div>
      @endif
      <form action="{{ route('admin.societes.affecter-contact', $contact->id) }}" method="POST" class="mb-6 flex gap-2 items-end">
        @csrf
        <div>
          <label for="contact_select" class="block text-sm font-medium text-gray-700">Affecter un contact :</label>
          <select name="contact_id" id="contact_select" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
            <option value="">-- Sélectionner un contact --</option>
            @foreach($contacts as $c)
              <option value="{{ $c->id }}">
                {{ $c->nom }} {{ $c->prenom ?? '' }} - {{ $c->fonction ?? '' }} | {{ $c->email ?? '' }} | {{ $c->telephone ?? '' }}
                @if($c instanceof \App\Models\ManualContact)
                  (manuel)
                @else
                  (référence)
                @endif
              </option>
            @endforeach
          </select>
        </div>
        <button type="submit" class="px-4 py-2 bg-[#152C54] text-white rounded hover:bg-[#2748E9] transition-colors">Affecter</button>
      </form>
      <div class="mt-6">
        <div class="flex items-center mb-2">
  <h3 class="font-semibold text-[#152C54]">Contacts affectés à cette société :</h3>
</div>
        @if($contact->contactsReferences->count() || $contact->contactsManuels->count())
          <div class="overflow-x-auto">
            <table class="min-w-full border rounded-xl overflow-hidden shadow">
              <thead>
                <tr class="bg-[#152C54] text-white">
                  <th class="px-4 py-3 text-left text-xs font-bold uppercase">Nom</th>
                  <th class="px-4 py-3 text-left text-xs font-bold uppercase">Prénom</th>
                  <th class="px-4 py-3 text-left text-xs font-bold uppercase">Fonction</th>
                  <th class="px-4 py-3 text-left text-xs font-bold uppercase">Email</th>
                  <th class="px-4 py-3 text-left text-xs font-bold uppercase">Téléphone</th>
                  <th class="px-4 py-3 text-left text-xs font-bold uppercase">Type</th>
                  <th class="px-4 py-3 text-left text-xs font-bold uppercase">Action</th>
                </tr>
              </thead>
              <tbody>
                @foreach($contact->contactsReferences as $loopRef => $ref)
                  <tr class="@if($loop->even) bg-[#e0e7ef] @else bg-white @endif hover:bg-blue-100 transition-colors border-b border-gray-200">
                    <td class="px-4 py-2 text-[#152C54] font-medium">{{ $ref->nom }}</td>
                    <td class="px-4 py-2 text-[#152C54]">{{ $ref->prenom }}</td>
                    <td class="px-4 py-2 text-[#152C54]">{{ $ref->fonction }}</td>
                    <td class="px-4 py-2 text-[#152C54]">{{ $ref->email }}</td>
                    <td class="px-4 py-2 text-[#152C54]">{{ $ref->telephone }}</td>
                    <td class="px-4 py-2 text-[#152C54]">Référence</td>
                    <td class="px-4 py-2 text-center">
                      <form action="{{ route('admin.societes.detach-contact', [$contact->id, $ref->id, 'type' => 'reference']) }}" method="POST" onsubmit="return confirm('Retirer ce contact de la société ?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-600 hover:text-red-900 font-bold text-lg" title="Retirer ce contact">&times;</button>
                      </form>
                    </td>
                  </tr>
                @endforeach
                @foreach($contact->contactsManuels as $loopManuel => $manuel)
                  <tr class="@if($loop->even) bg-[#e0e7ef] @else bg-white @endif hover:bg-blue-100 transition-colors border-b border-gray-200">
                    <td class="px-4 py-2 text-[#152C54] font-medium">{{ $manuel->nom }}</td>
                    <td class="px-4 py-2 text-[#152C54]">{{ $manuel->prenom }}</td>
                    <td class="px-4 py-2 text-[#152C54]">{{ $manuel->fonction }}</td>
                    <td class="px-4 py-2 text-[#152C54]">{{ $manuel->email }}</td>
                    <td class="px-4 py-2 text-[#152C54]">{{ $manuel->telephone }}</td>
                    <td class="px-4 py-2 text-[#152C54]">Manuel</td>
                    <td class="px-4 py-2 text-center">
                      <form action="{{ route('admin.societes.detach-contact', [$contact->id, $manuel->id, 'type' => 'manuel']) }}" method="POST" onsubmit="return confirm('Retirer ce contact de la société ?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-600 hover:text-red-900 font-bold text-lg" title="Retirer ce contact">&times;</button>
                      </form>
                    </td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>
          <div class="flex justify-end mt-2">
            <a href="{{ route('admin.societes.exportContacts', $contact->id) }}" class="bg-[#152C54] text-white px-4 py-2 rounded-md hover:bg-[#2748E9] transition-colors">
              Exporter en Excel
            </a>
          </div>
        @else
          <div class="text-gray-500 italic">Aucun contact affecté à cette société.</div>
          <div class="flex justify-end mt-2">
            <a href="{{ route('admin.societes.exportContacts', $contact->id) }}" class="bg-[#152C54] text-white px-4 py-2 rounded-md hover:bg-[#2748E9] transition-colors">
              Exporter en Excel
            </a>
          </div>
        @endif
      </div>
    </div>
    
  </div>

  <!-- Bloc Actions -->
  <div class="bg-white rounded-xl shadow p-6 w-full mt-8">
    <div class="font-semibold text-[#152C54] mb-4 text-lg flex items-center gap-2">
      <span class="flex items-center gap-2"><span>📝</span> Actions</span>
    </div>
    <form action="{{ route('admin.societes.actions.store', $contact->id) }}" method="POST" class="mb-6">
      @csrf
      <div class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
        <div>
          <label for="contact_id" class="block text-sm font-medium text-gray-700 mb-1">Contact concerné</label>
          <select name="contact_id" id="contact_id" class="w-full rounded border-gray-300 focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50" required>
            <option value="">-- Sélectionner un contact --</option>
            @foreach($contact->contactsReferences as $ref)
              <option value="{{ $ref->id }}" data-type="reference">{{ $ref->email }} ({{ $ref->nom }} {{ $ref->prenom }}) [Référence]</option>
            @endforeach
            @foreach($contact->contactsManuels as $manuel)
              <option value="{{ $manuel->id }}" data-type="manual">{{ $manuel->email }} ({{ $manuel->nom }} {{ $manuel->prenom }}) [Manuel]</option>
            @endforeach
          </select>
          <input type="hidden" name="contact_type" id="contact_type" value="">
          <script>
            document.addEventListener('DOMContentLoaded', function() {
              const select = document.getElementById('contact_id');
              const typeInput = document.getElementById('contact_type');
              select.addEventListener('change', function() {
                const selected = select.options[select.selectedIndex];
                typeInput.value = selected.getAttribute('data-type') || '';
              });
            });
          </script>
        </div>
        <div>
          <label for="motif" class="block text-sm font-medium text-gray-700 mb-1">Motif</label>
          <input type="text" name="motif" id="motif" class="w-full rounded border-gray-300 focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50" placeholder="Réunion, prospection..." required>
        </div>
        <div>
          <label for="date_action" class="block text-sm font-medium text-gray-700 mb-1">Date</label>
          <input type="date" name="date_action" id="date_action" class="w-full rounded border-gray-300 focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50" required>
        </div>
        <div>
          <label for="commentaire" class="block text-sm font-medium text-gray-700 mb-1">Type d'action</label>
          <textarea name="commentaire" id="commentaire" rows="1" class="w-full rounded border-gray-300 focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50"></textarea>
        </div>
        <div class="md:col-span-4 flex justify-end mt-2" style="overflow:visible;width:100%;">
        <button type="submit" class="bg-[#152C54] text-white px-4 py-2 rounded-md hover:bg-[#2748E9] transition-colors">Enregistrer</button>
        </div>
      </div>
    </form>
    <div>
      <h4 class="font-semibold text-[#152C54] mb-2">Historique des actions :</h4>
      @include('admin.partials.societe-actions-table', ['actions' => $actions])
      <div class="flex justify-end mt-2">
        <a href="{{ route('admin.societes.exportActions', $contact->id) }}" class="bg-[#152C54] text-white px-4 py-2 rounded-md hover:bg-[#2748E9] transition-colors">Exporter les actions</a>
      </div>
    </div>
    <script>
      document.addEventListener('DOMContentLoaded', function() {
        const form = document.querySelector('form[action*="actions.store"]');

        form.addEventListener('submit', function(e) {
          e.preventDefault();
          submitActionFormAjax();
        });
        function submitActionFormAjax() {
          const formData = new FormData(form);
          fetch(form.action, {
            method: 'POST',
            headers: {
              'X-CSRF-TOKEN': form.querySelector('[name=_token]').value,
              'Accept': 'application/json',
            },
            body: formData,
          })
          .then(res => res.json())
          .then(data => {
            if (data.success || data.id) {
              // Recharge le tableau des actions sans recharger la page
              fetch(window.location.href, {headers: {'X-Requested-With': 'XMLHttpRequest'}})
                .then(r => r.text())
                .then(html => {
                  const parser = new DOMParser();
                  const doc = parser.parseFromString(html, 'text/html');
                  const newTable = doc.querySelector('#actionsTableBody');
                  document.querySelector('#actionsTableBody').innerHTML = newTable.innerHTML;
                  form.reset();
                });
            } else {
              alert('Erreur lors de l\'enregistrement de l\'action.');
            }
          })
          .catch(() => alert('Erreur lors de l\'enregistrement de l\'action.'));
        }
      });
    </script>
  </div>
</div>
</x-admin-layout>
