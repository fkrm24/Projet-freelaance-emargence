<x-admin-layout>

<div class="max-w-3xl mx-auto bg-white rounded-xl shadow p-8 mt-8">
    <a href="{{ route('admin.contacts.index') }}" class="text-blue-700 hover:underline mb-4 inline-block">← Retour à la liste des contacts</a>
    <h1 class="text-2xl font-bold text-[#152C54] mb-4">Détail du contact</h1>
    <div class="mb-6">
        <div class="grid grid-cols-2 gap-x-8 gap-y-2">
            <div>
                <div class="font-semibold">Nom :</div>
                <div>{{ $contact->nom ?? '-' }}</div>
            </div>
            <div>
                <div class="font-semibold">Prénom :</div>
                <div>{{ $contact->prenom ?? '-' }}</div>
            </div>
            <div>
                <div class="font-semibold">Email :</div>
                <div>{{ $contact->email ?? '-' }}</div>
            </div>
            <div>
                <div class="font-semibold">Téléphone :</div>
                <div>{{ $contact->telephone ?? '-' }}</div>
            </div>
            <div>
                <div class="font-semibold">Fonction :</div>
                <div>{{ $contact->fonction ?? '-' }}</div>
            </div>
            <div>
                <div class="font-semibold">Type :</div>
                <div>{{ $type === 'manual' ? 'Manuel' : 'Référence' }}</div>
            </div>
        </div>
    </div>
    <div class="mb-6">
        <div class="font-semibold">Société liée :</div>
        @if($societe && is_object($societe))
            <a href="{{ route('admin.societes.show', $societe->id) }}" class="text-blue-700 hover:underline">{{ $societe->nom }}</a>
        @elseif($contact->societe)
            <span class="text-gray-500 italic">{{ $contact->societe }}</span>
        @else
            <span class="text-gray-500 italic">Aucune société liée</span>
        @endif
    </div>
    <div>
        <h2 class="font-semibold text-lg mb-2">Actions rattachées à ce contact :</h2>
        @if($actions->count())
        <table class="min-w-full border rounded-xl overflow-hidden shadow mt-2">
            <thead>
                <tr class="bg-[#152C54] text-white">
                    <th class="px-4 py-3 text-left text-xs font-bold uppercase">Société</th>
                    <th class="px-4 py-3 text-left text-xs font-bold uppercase">Motif</th>
                    <th class="px-4 py-3 text-left text-xs font-bold uppercase">Date</th>
                    <th class="px-4 py-3 text-left text-xs font-bold uppercase">Type d'action</th>
                    <th class="px-4 py-3 text-left text-xs font-bold uppercase">Ajouté par</th>
                    <th class="px-4 py-3 text-left text-xs font-bold uppercase">Action à venir</th>
                    <th class="px-4 py-3 text-left text-xs font-bold uppercase">Évaluation</th>
                </tr>
            </thead>
            <tbody>
                @foreach($actions as $action)
                    <tr>
                        <td class="px-4 py-2 text-[#152C54]">{{ $action->societe ? $action->societe->nom : '-' }}</td>
                        <td class="px-4 py-2 text-[#152C54]">{{ $action->motif }}</td>
                        <td class="px-4 py-2 text-[#152C54]">{{ $action->date_action ? \Carbon\Carbon::parse($action->date_action)->format('d/m/Y') : '' }}</td>
                        <td class="px-4 py-2 text-[#152C54]">{{ $action->commentaire }}</td>
                        <td class="px-4 py-2 text-[#152C54]">{{ $action->user ? $action->user->name : '-' }}</td>
                        <td class="px-4 py-2 text-[#152C54]">{{ $action->action_a_venir }}</td>
                        <td class="px-4 py-2 text-[#152C54]">
                            <div style="display: flex; gap: 2px; align-items: center;">
                                @for ($i = 1; $i <= 5; $i++)
                                    <span style="font-size: 1em; line-height: 1; {{ $i <= $action->evaluation ? 'color: #facc15;' : 'color: #cbd5e1;' }}">
                                        &#9733;
                                    </span>
                                @endfor
                            </div>
                        </td>
                         
                    </tr>
                @endforeach
            </tbody>
        </table>
        @else
            <div class="text-gray-500 italic">Aucune action rattachée à ce contact.</div>
        @endif
    </div>
</div>
</x-admin-layout>
