<?php

namespace App\Http\Controllers;

use App\Models\Reference;
use App\Models\Profil;
use App\Models\Experience;
use App\Models\ManualContact;
use Illuminate\Http\Request;

// Affichage des contacts (références + manuels)
class ContactController extends Controller
{
    // Afficher la liste des sociétés (vue)
    public function societes()
    {
        $societes = \App\Models\Contact::orderBy('nom')->paginate(10);
        $sidebarSocietesCount = $societes->total();
        return view('admin.societes', compact('societes', 'sidebarSocietesCount'));
    }

    // Supprimer une société
    public function destroySociete($contactId)
    {
        $societe = \App\Models\Contact::findOrFail($contactId);
        $societe->delete();
        return redirect()->back()->with('success', 'Société supprimée avec succès.');
    }

    // Détacher un contact d'une société
    public function detachContact($societeId, $contactId, $type = null)
    {
        $societe = \App\Models\Contact::findOrFail($societeId);
        if ($type === 'manuel') {
            $societe->contactsManuels()->detach($contactId);
        } else {
            $societe->contactsReferences()->detach($contactId);
        }
        return redirect()->route('admin.societes.show', ['contact' => $societeId])
            ->with('success', 'Contact retiré de la société avec succès.');
    }

    // Enregistrer les champs 'action_a_venir' pour chaque action de société
    public function updateActionsAVenir(Request $request)
    {
        foreach ($request->input('action_a_venir', []) as $id => $valeur) {
            $action = \App\Models\SocieteAction::find($id);
            if ($action) {
                $action->action_a_venir = $valeur;
                // Ajout de la sauvegarde de l'évaluation
                if ($request->has('evaluation') && isset($request->evaluation[$id])) {
                    $action->evaluation = $request->evaluation[$id];
                }
                $action->save();
            }
        }
        return back()->with('success', 'Actions à venir enregistrées !');
    }

    // Affecter un contact existant à une société
    public function affecterContact(Request $request, \App\Models\Contact $contact)
    {
        $request->validate([
            'contact_id' => 'required',
        ]);

        // On tente d'abord de trouver dans Reference
        $reference = \App\Models\Reference::find($request->contact_id);
        if ($reference) {
            // Vérifie si le contact de référence est déjà affecté à une autre société
            $autresSocietes = $reference->societes()->where('contacts.id', '!=', $contact->id)->exists();
            if ($autresSocietes) {
                return redirect()->route('admin.societes.show', $contact->id)
                    ->with('error', 'Ce contact de référence est déjà affecté à une autre société.');
            }
            $contact->contactsReferences()->syncWithoutDetaching([$request->contact_id]);
            return redirect()->route('admin.societes.show', $contact->id)
                ->with('success', 'Contact de référence affecté à la société !');
        }

        // Sinon, on tente dans ManualContact
        $manualContact = \App\Models\ManualContact::find($request->contact_id);
        if ($manualContact) {
            \Log::info('Affectation manuel', [
                'contact_id' => $request->contact_id,
                'manualContact' => $manualContact,
                'contactManuelsCount_before' => $contact->contactsManuels()->count(),
            ]);
            $contact->contactsManuels()->syncWithoutDetaching([$request->contact_id]);
            \Log::info('Affectation manuel après sync', [
                'contactManuelsCount_after' => $contact->contactsManuels()->count(),
            ]);
            return redirect()->route('admin.societes.show', $contact->id)
                ->with('success', 'Contact manuel affecté à la société !');
        }

        return redirect()->route('admin.societes.show', $contact->id)
            ->with('error', 'Contact introuvable.');
    }
    // Liste AJAX ou page des sociétés (nom uniquement)
    public function listSocietes()
    {
        $societes = \App\Models\Contact::orderBy('nom')->get(['id', 'nom']);
        // Peut renvoyer une vue ou du JSON selon usage
        if (request()->wantsJson()) {
            return response()->json($societes);
        }
        return view('admin.societes', compact('societes'));
    }

    // Ajout rapide (nom seul)
    public function storeSociete(Request $request)
    {
        // Pour fetch() en JSON, il faut décoder le body
        $data = $request->isJson() ? $request->json()->all() : $request->all();
        try {
            $validated = validator($data, [
                'nom' => 'required|string|max:255|unique:contacts,nom',
                'adresse' => 'nullable|string|max:255',
                'siren' => 'nullable|string|max:9|unique:contacts,siren',
                'code_naf' => 'nullable|string|max:7',
                'tva' => 'nullable|string|max:13|unique:contacts,tva',
            ])->validate();
            $societe = \App\Models\Contact::create($validated);
            if ($request->wantsJson() || $request->isJson()) {
                return response()->json(['success' => true, 'societe' => $societe]);
            }
            return redirect()->route('admin.societes.index')->with('success', 'Société ajoutée avec succès !');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['success' => false, 'errors' => $e->errors()], 422);
        }
    }

    // Mise à jour société (depuis modal)
    public function updateSociete(Request $request, \App\Models\Contact $contact)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'adresse' => 'nullable|string|max:255',
            'siren' => 'nullable|string|max:9|unique:contacts,siren,' . $contact->id,
            'code_naf' => 'nullable|string|max:7',
        ]);
        $contact->update($validated);
        return redirect()->route('admin.societes.index')->with('success', 'Société modifiée avec succès !');
    }

    // Détail société
    public function showSociete(\App\Models\Contact $contact)
    {
        // Recharge explicitement les relations pour éviter le cache
        $contact->load('contactsManuels', 'contactsReferences');
        $contactsReferences = \App\Models\Reference::whereDoesntHave('societes', function($q) use ($contact) {
            $q->where('contacts.id', '!=', $contact->id);
        })->orWhereHas('societes', function($q) use ($contact) {
            $q->where('contacts.id', $contact->id);
        })->get();
        $manualContacts = \App\Models\ManualContact::all();
        $contacts = collect($contactsReferences)->concat($manualContacts);
        $actions = $contact->actions()->with('user')->latest()->get();
        return view('admin.societe-detail', compact('contact', 'contacts', 'actions'));
    }

    // Ajout d'une action (démarche, réunion, etc.)
    public function storeSocieteAction(Request $request, $societeId)
    {
        $request->validate([
            'contact_id' => 'required|integer',
            'contact_type' => 'required|string',
            'motif' => 'required|string',
            'date_action' => 'required|date',
            'commentaire' => 'nullable|string',
        ]);
        $action = new \App\Models\SocieteAction();
        $action->societe_id = $societeId;
        $action->contact_id = $request->contact_id;
        $action->contact_type = $request->contact_type === 'manual' ? \App\Models\ManualContact::class : \App\Models\Reference::class;
        $action->motif = $request->motif;
        $action->date_action = $request->date_action;
        $action->commentaire = $request->commentaire;
        $action->user_id = auth()->id();
        $action->save();
        if ($request->ajax()) {
            return response()->json(['success' => true, 'id' => $action->id]);
        }
        return redirect()->route('admin.societes.show', $societeId)->with('success', 'Action ajoutée !');
    }

    public function index()
    {
        // Récupérer les références issues des expériences (pagination)
        $references = Reference::with('experience')->paginate(10, ['*'], 'references_page');
        $profils = Profil::all();
        $listeExpertises = Experience::select('secteur')->distinct()->get();
        $manualContacts = \App\Models\ManualContact::paginate(10, ['*'], 'manualcontacts_page');
        $sidebarContactsCount = $references->total() + $manualContacts->total();
        return view('admin.contacts', compact('references', 'profils', 'listeExpertises', 'sidebarContactsCount', 'manualContacts'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'societe' => 'required|string|max:255',
            'secteur' => 'required|string|max:255',
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'fonction' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'telephone' => 'required|string|max:20',
        ]);

        \App\Models\ManualContact::create($validated);

        return redirect()->route('admin.contacts.index')
            ->with('success', 'Contact créé avec succès');
    }

    public function show(Reference $reference)
    {
        return response()->json($reference);
    }

    public function update(Request $request, Reference $reference)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'fonction' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'telephone' => 'required|string|max:20',
            'societe' => 'nullable|string|max:255',
            'secteur' => 'nullable|string|max:255',
        ]);

        $reference->update($validated);

        return redirect()->route('admin.contacts.index')
            ->with('success', 'Contact modifié avec succès');
    }

    public function destroy(Reference $reference)
    {
        $reference->delete();
        return redirect()->route('admin.contacts.index')
            ->with('success', 'Contact supprimé avec succès');
    }

    // Affichage détail d'un contact (manuel ou référence)
    public function showContact($type, $id)
    {
        if ($type === 'manual') {
            $contact = \App\Models\ManualContact::findOrFail($id);
            // Cherche la société liée via la table pivot contact_societe_manuel
            $societe = \App\Models\Contact::whereHas('contactsManuels', function($q) use ($id) {
                $q->where('manual_contact_id', $id);
            })->first();
            $actions = \App\Models\SocieteAction::where('contact_id', $contact->id)
                ->where('contact_type', \App\Models\ManualContact::class)
                ->with(['societe', 'user'])
                ->latest()
                ->get();
        } else {
            $contact = \App\Models\Reference::findOrFail($id);
            // Une référence peut avoir plusieurs sociétés, on prend la première ou null
            $societe = $contact->societes()->first();
            $actions = \App\Models\SocieteAction::where('contact_id', $contact->id)
                ->where('contact_type', \App\Models\Reference::class)
                ->with(['societe', 'user'])
                ->latest()
                ->get();
        }
        return view('admin.contact-detail', compact('contact', 'societe', 'actions', 'type'));
    }

    /**
     * Exporte les contacts affectés à une société (Excel)
     */
    public function exportContacts($contactId)
    {
        $societe = \App\Models\Contact::findOrFail($contactId);
        $references = $societe->contactsReferences;
        $manuels = $societe->contactsManuels;

        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Contacts société');

        // En-têtes
        $headers = ['Nom', 'Prénom', 'Fonction', 'Email', 'Téléphone', 'Type'];
        foreach ($headers as $col => $header) {
            $colLetter = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($col + 1);
            $sheet->setCellValue($colLetter . '1', $header);
        }

        $row = 2;
        foreach ($references as $ref) {
            $sheet->setCellValue('A' . $row, $ref->nom ?? '');
            $sheet->setCellValue('B' . $row, $ref->prenom ?? '');
            $sheet->setCellValue('C' . $row, $ref->fonction ?? '');
            $sheet->setCellValue('D' . $row, $ref->email ?? '');
            $sheet->setCellValue('E' . $row, $ref->telephone ?? '');
            $sheet->setCellValue('F' . $row, 'Référence');
            $row++;
        }
        foreach ($manuels as $manuel) {
            $sheet->setCellValue('A' . $row, $manuel->nom ?? '');
            $sheet->setCellValue('B' . $row, $manuel->prenom ?? '');
            $sheet->setCellValue('C' . $row, $manuel->fonction ?? '');
            $sheet->setCellValue('D' . $row, $manuel->email ?? '');
            $sheet->setCellValue('E' . $row, $manuel->telephone ?? '');
            $sheet->setCellValue('F' . $row, 'Manuel');
            $row++;
        }

        // Largeur automatique
        foreach (range('A', 'F') as $columnID) {
            $sheet->getColumnDimension($columnID)->setAutoSize(true);
        }

        $filename = 'contacts_societe_' . $societe->id . '_' . now()->format('Ymd_His') . '.xlsx';
        $tempFile = tempnam(sys_get_temp_dir(), 'export');
        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        $writer->save($tempFile);

        return response()->download($tempFile, $filename, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        ])->deleteFileAfterSend(true);
    }

    /**
     * Exporter les actions d'une société au format Excel
     */
    public function exportActions($contactId)
    {
        $societe = \App\Models\Contact::findOrFail($contactId);
        $actions = $societe->actions()->with('user')->latest()->get();

        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Actions société');

        // En-têtes
        $headers = ['Date', 'Motif', 'Commentaire', 'Contact', 'Utilisateur'];
        foreach ($headers as $col => $header) {
            $colLetter = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($col + 1);
            $sheet->setCellValue($colLetter . '1', $header);
        }

        $row = 2;
        foreach ($actions as $action) {
            $sheet->setCellValue('A' . $row, $action->date_action ? (method_exists($action->date_action, 'format') ? $action->date_action->format('d/m/Y') : $action->date_action) : '');
            $sheet->setCellValue('B' . $row, $action->motif ?? '');
            $sheet->setCellValue('C' . $row, $action->commentaire ?? '');
            // Contact concerné
            $contactName = '';
            if ($action->contact_type === \App\Models\Reference::class) {
                $ref = \App\Models\Reference::find($action->contact_id);
                $contactName = $ref ? ($ref->nom . ' ' . ($ref->prenom ?? '')) : '';
            } elseif ($action->contact_type === \App\Models\ManualContact::class) {
                $manuel = \App\Models\ManualContact::find($action->contact_id);
                $contactName = $manuel ? ($manuel->nom . ' ' . ($manuel->prenom ?? '')) : '';
            }
            $sheet->setCellValue('D' . $row, trim($contactName));
            $sheet->setCellValue('E' . $row, $action->user ? ($action->user->name ?? $action->user->email) : '');
            $row++;
        }

        foreach (range('A', 'E') as $columnID) {
            $sheet->getColumnDimension($columnID)->setAutoSize(true);
        }

        $filename = 'actions_societe_' . $societe->id . '_' . now()->format('Ymd_His') . '.xlsx';
        $tempFile = tempnam(sys_get_temp_dir(), 'export');
        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        $writer->save($tempFile);

        return response()->download($tempFile, $filename, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        ])->deleteFileAfterSend(true);
    }

    /**
     * Exporter tous les contacts au format Excel
     */
    public function exportAllContacts()
    {
        // Récupérer tous les contacts références et manuels
        $references = \App\Models\Reference::with('experience')->get();
        $manuels = \App\Models\ManualContact::with('societe')->get();

        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Contacts');

        // En-têtes
        $headers = ['Nom', 'Prénom', 'Fonction', 'Email', 'Téléphone', 'Société', 'Secteur', 'Type'];
        foreach ($headers as $col => $header) {
            $colLetter = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($col + 1);
            $sheet->setCellValue($colLetter . '1', $header);
        }

        $row = 2;
        // Références
        foreach ($references as $ref) {
            $sheet->setCellValue('A' . $row, $ref->nom ?? '');
            $sheet->setCellValue('B' . $row, $ref->prenom ?? '');
            $sheet->setCellValue('C' . $row, $ref->fonction ?? '');
            $sheet->setCellValue('D' . $row, $ref->email ?? '');
            $sheet->setCellValue('E' . $row, $ref->telephone ?? '');
            $sheet->setCellValue('F' . $row, $ref->experience->societe ?? '');
            $sheet->setCellValue('G' . $row, $ref->experience->secteur ?? '');
            $sheet->setCellValue('H' . $row, 'Référence');
            $row++;
        }
        // Manuels
        foreach ($manuels as $manuel) {
            $sheet->setCellValue('A' . $row, $manuel->nom ?? '');
            $sheet->setCellValue('B' . $row, $manuel->prenom ?? '');
            $sheet->setCellValue('C' . $row, $manuel->fonction ?? '');
            $sheet->setCellValue('D' . $row, $manuel->email ?? '');
            $sheet->setCellValue('E' . $row, $manuel->telephone ?? '');
            $sheet->setCellValue('F' . $row, $manuel->societe ?? '');
            $sheet->setCellValue('G' . $row, $manuel->secteur ?? '');
            $sheet->setCellValue('H' . $row, 'Manuel');
            $row++;
        }

        foreach (range('A', 'H') as $columnID) {
            $sheet->getColumnDimension($columnID)->setAutoSize(true);
        }

        $filename = 'contacts_' . now()->format('Ymd_His') . '.xlsx';
        $tempFile = tempnam(sys_get_temp_dir(), 'export');
        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        $writer->save($tempFile);

        return response()->download($tempFile, $filename, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        ])->deleteFileAfterSend(true);
    }

    /**
     * Exporter la liste des sociétés au format Excel
     */
    public function exportSocietes()
    {
        $societes = \App\Models\Contact::orderBy('nom')->get();

        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Sociétés');

        // En-têtes
        $headers = ['Nom', 'Siren', 'Code NAF', 'Adresse'];
        foreach ($headers as $col => $header) {
            $colLetter = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($col + 1);
            $sheet->setCellValue($colLetter . '1', $header);
        }

        $row = 2;
        foreach ($societes as $societe) {
            $sheet->setCellValue('A' . $row, $societe->nom ?? '');
            $sheet->setCellValue('B' . $row, $societe->siren ?? '');
            $sheet->setCellValue('C' . $row, $societe->code_naf ?? '');
            $sheet->setCellValue('D' . $row, $societe->adresse ?? '');
            $row++;
        }

        foreach (range('A', 'D') as $columnID) {
            $sheet->getColumnDimension($columnID)->setAutoSize(true);
        }

        $filename = 'societes_' . now()->format('Ymd_His') . '.xlsx';
        $tempFile = tempnam(sys_get_temp_dir(), 'export');
        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        $writer->save($tempFile);

        return response()->download($tempFile, $filename, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        ])->deleteFileAfterSend(true);
    }

    /**
     * Exporter toutes les actions de toutes les sociétés au format Excel
     */
    public function exportAllActions()
    {
        $actions = \App\Models\SocieteAction::with(['societe', 'user'])->latest()->get();

        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Toutes les actions');

        // En-têtes
        $headers = ['Société', 'Date', 'Motif', 'Commentaire', 'Contact', 'Utilisateur'];
        foreach ($headers as $col => $header) {
            $colLetter = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($col + 1);
            $sheet->setCellValue($colLetter . '1', $header);
        }

        $row = 2;
        foreach ($actions as $action) {
            $societeName = $action->societe ? $action->societe->nom : '';
            $sheet->setCellValue('A' . $row, $societeName);
            $sheet->setCellValue('B' . $row, $action->date_action ? (method_exists($action->date_action, 'format') ? $action->date_action->format('d/m/Y') : $action->date_action) : '');
            $sheet->setCellValue('C' . $row, $action->motif ?? '');
            $sheet->setCellValue('D' . $row, $action->commentaire ?? '');
            // Contact concerné
            $contactName = '';
            if ($action->contact_type === \App\Models\Reference::class) {
                $ref = \App\Models\Reference::find($action->contact_id);
                $contactName = $ref ? ($ref->nom . ' ' . ($ref->prenom ?? '')) : '';
            } elseif ($action->contact_type === \App\Models\ManualContact::class) {
                $manuel = \App\Models\ManualContact::find($action->contact_id);
                $contactName = $manuel ? ($manuel->nom . ' ' . ($manuel->prenom ?? '')) : '';
            }
            $sheet->setCellValue('E' . $row, trim($contactName));
            $sheet->setCellValue('F' . $row, $action->user ? ($action->user->name ?? $action->user->email) : '');
            $row++;
        }

        foreach (range('A', 'F') as $columnID) {
            $sheet->getColumnDimension($columnID)->setAutoSize(true);
        }

        $filename = 'toutes_actions_' . now()->format('Ymd_His') . '.xlsx';
        $tempFile = tempnam(sys_get_temp_dir(), 'export');
        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        $writer->save($tempFile);

        return response()->download($tempFile, $filename, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        ])->deleteFileAfterSend(true);
    }
}
