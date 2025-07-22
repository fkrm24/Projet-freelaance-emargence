<?php

namespace App\Http\Controllers;

use App\Models\Profil;
use App\Models\ConfidenceIndex;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Cell\DataType;

class AdminController extends Controller
{
    // Mise à jour de la date modifiée d'un utilisateur (admin)
    public function updateDateModifiee(Request $request, User $user)
    {
        $request->validate([
            'date_modifiee' => 'nullable|date',
        ]);
        $user->date_modifiee = $request->date_modifiee ? \Carbon\Carbon::parse($request->date_modifiee) : null;
        $user->save();
        return redirect()->route('admin.dashboard')->with('success', 'Date modifiée enregistrée avec succès.');
    }

    // Mise à jour AJAX de la date de disponibilité d'un utilisateur
    public function updateDisponibilite(Request $request, User $user)
    {
        \Log::info('Update dispo', [
            'user_id' => $user->id,
            'avant' => $user->date_disponibilite,
            'nouvelle_valeur' => $request->date_disponibilite
        ]);
        $request->validate(['date_disponibilite' => 'required|date']);
        $user->date_disponibilite = \Carbon\Carbon::parse($request->date_disponibilite);
        $user->save();
        \Log::info('Après save', [
            'après' => $user->fresh()->date_disponibilite
        ]);
        return response()->json(['success' => true]);
    }

    public function dashboard(Request $request)
    {
        $query = Profil::with(['user', 'confidenceIndices']);

        // Filtre par date de disponibilité
        if ($request->filled(['date_debut', 'date_fin'])) {
            $query->whereHas('user', function ($q) use ($request) {
                $q->whereBetween('date_disponibilite', [$request->date_debut, $request->date_fin]);
            });
        }

        // Filtre par profil
        if ($request->filled('profil')) {
            $query->where('profil', $request->profil);
        }

        // Filtre par type d'expertise (multi)
        $expertises = (array) $request->input('expertise', []);
        if (!empty($expertises)) {
            $query->where(function ($q) use ($expertises) {
                foreach ($expertises as $exp) {
                    $q->orWhere('expertise', 'like', '%' . $exp . '%');
                }
            });
        }

        // Filtre par compétences (multi)
        $competences = (array) $request->input('competence', []);
        if (!empty($competences)) {
            $query->where(function ($q) use ($competences) {
                foreach ($competences as $comp) {
                    $q->orWhere('competences', 'like', '%' . $comp . '%');
                }
            });
        }

        // Filtre par recherche texte (nom, prénom, ou entreprise dans les expériences)
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function($q) use ($search) {
                $q->where('nom', 'like', "%$search%")
                  ->orWhere('prenom', 'like', "%$search%")
                  ->orWhereHas('experiences', function($expQ) use ($search) {
                      $expQ->where('societe', 'like', "%$search%")
                           ;
                  });
            });
        }

        $profils = $query->paginate(6);

        // Récupérer les listes pour les filtres
        $listeProfils = Profil::distinct('profil')->pluck('profil');
        
        // Récupérer et formater la liste des expertises
        $listeExpertises = collect();
        Profil::all()->each(function ($profil) use ($listeExpertises) {
            $expField = $profil->expertise;
            // Si c'est une chaîne JSON
            if (is_string($expField) && str_starts_with(trim($expField), '[')) {
                $decoded = json_decode($expField, true);
                if (is_array($decoded)) {
                    foreach ($decoded as $exp) {
                        if (is_array($exp) && isset($exp['text'])) $listeExpertises->push($exp['text']);
                    }
                }
            }
            // Si c'est un tableau
            elseif (is_array($expField)) {
                foreach ($expField as $exp) {
                    if (is_array($exp) && isset($exp['text'])) $listeExpertises->push($exp['text']);
                    elseif (is_string($exp)) $listeExpertises->push($exp);
                }
            }
            // Si c'est une chaîne simple
            elseif (is_string($expField) && trim($expField) !== '') {
                $listeExpertises->push($expField);
            }
        });
        $listeExpertises = $listeExpertises->unique()->values();
        $listeCompetences = collect();
        Profil::all()->each(function ($profil) use ($listeCompetences) {
            collect($profil->competences)->each(function ($comp) use ($listeCompetences) {
                $listeCompetences->push($comp);
            });
        });
        $listeCompetences = $listeCompetences->unique();

        return view('admin.dashboard', compact(
            'profils',
            'listeProfils',
            'listeExpertises',
            'listeCompetences'
        ));
    }

    public function exportCsv()
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // En-têtes des colonnes
        $headers = [
            'ID',
            'Nom',
            'Prénom',
            'Téléphone',
            'Date de naissance',
            'Date de disponibilité',
            'Profil',
            "Type d'expertise",
            'Compétences outils',
            "Nombre d'années d'expérience",
            'Date dernier diplôme',
            'CV',
            'Indices de confiance'
        ];

        // Écrire les en-têtes
        foreach ($headers as $colNum => $header) {
            $col = chr(65 + $colNum); // Convertir le numéro en lettre (A, B, C, etc.)
            $sheet->setCellValue($col . '1', $header);
            $sheet->getColumnDimension($col)->setWidth(20); // Largeur par défaut
        }

        // Style pour les en-têtes
        $sheet->getStyle('A1:M1')->getFont()->setBold(true);
        // Activer les filtres automatiques Excel
        $sheet->setAutoFilter('A1:M1');

        // Récupérer les données
        $profils = Profil::with(['user', 'confidenceIndices', 'experiences'])->get();

        // Remplir les données
        $row = 2;
        foreach ($profils as $profil) {
            $dateNaissance = $profil->date_naissance ? date('d/m/Y', strtotime($profil->date_naissance)) : '';
            $dateDisponibilite = $profil->user->date_disponibilite ? date('d/m/Y', strtotime($profil->user->date_disponibilite)) : '';
            $dateDiplome = $profil->date_diplome ? date('d/m/Y', strtotime($profil->date_diplome)) : '';

            $indices = $profil->confidenceIndices->map(function($indice) {
                return $indice->percentage . '% - ' . ($indice->commentaire ?? 'Pas de commentaire');
            })->implode("\n");

            $data = [
                $profil->user->id,
                $profil->nom,
                $profil->prenom,
                $profil->telephone,
                $dateNaissance,
                $dateDisponibilite,
                $profil->profil,
                $profil->formatted_expertise ?: (
    (is_string($profil->expertise) && str_starts_with(trim($profil->expertise), '['))
        ? collect(json_decode($profil->expertise, true))->pluck('text')->filter()->implode(', ')
        : (is_array($profil->expertise)
            ? collect($profil->expertise)->map(function($exp) {
                if (is_array($exp) && isset($exp['text'])) return $exp['text'];
                if (is_object($exp) && isset($exp->text)) return $exp->text;
                return null;
            })->filter()->implode(', ')
            : (is_string($profil->expertise) ? $profil->expertise : '')
        )
),
                is_array($profil->competences)
    ? implode(", ", array_map(function($c) {
        if (is_array($c)) return implode(' ', array_map('strval', $c));
        if (is_object($c)) return json_encode($c);
        return (string)$c;
    }, $profil->competences))
    : (is_string($profil->competences) ? $profil->competences : implode(", ", (array) $profil->competences)),
                $profil->experience . ' ans',
                $dateDiplome,
                basename($profil->cv_path ?? ''),
                $indices
            ];

            foreach ($data as $colNum => $value) {
                $col = chr(65 + $colNum);
                $cellCoordinate = $col . $row;
                
                // Définir la valeur
                $sheet->setCellValue($cellCoordinate, $value);
                
                // Appliquer le style
                $sheet->getStyle($cellCoordinate)->getAlignment()
                    ->setWrapText(true)
                    ->setVertical(Alignment::VERTICAL_TOP);
            }

            $row++;
        }

        // Ajuster les largeurs spécifiques
        $sheet->getColumnDimension('H')->setWidth(40); // Expertise
        $sheet->getColumnDimension('I')->setWidth(40); // Compétences
        $sheet->getColumnDimension('M')->setWidth(50); // Indices de confiance

        // Créer le fichier Excel
        $writer = new Xlsx($spreadsheet);
        $filename = 'candidatures_' . now()->format('Y-m-d_His') . '.xlsx';
        $tempFile = tempnam(sys_get_temp_dir(), 'export');
        $writer->save($tempFile);

        return response()->download($tempFile, $filename, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        ])->deleteFileAfterSend(true);
    }

    public function addConfidenceIndex(Request $request, Profil $profil)
    {
        $request->validate([
            'color_code' => 'required|in:vert,orange,rouge,noir',
            'commentaire' => 'nullable|string'
        ]);

        // Associer la couleur à un pourcentage
        $colorToPercentage = [
            'vert' => 100,
            'orange' => 50,
            'rouge' => 25,
            'noir' => 0,
        ];
        $percentage = $colorToPercentage[$request->color_code];

        ConfidenceIndex::create([
            'profil_id' => $profil->id,
            'admin_id' => auth()->id(),
            'percentage' => $percentage,
            'color_code' => $request->color_code,
            'commentaire' => $request->commentaire
        ]);

        return back()->with('success', 'Indice de confiance ajouté avec succès');
    }

    public function setActiveConfidenceIndex(Request $request, $profilId, $indiceId)
    {
        \App\Models\ConfidenceIndex::where('profil_id', $profilId)->update(['is_active' => false]);
        $indice = \App\Models\ConfidenceIndex::where('profil_id', $profilId)->where('id', $indiceId)->firstOrFail();
        $indice->is_active = true;
        $indice->save();
        return response()->json(['success' => true]);
    }

    public function downloadCV(Profil $profil)
    {
        if (!$profil->cv_path || !Storage::disk('public')->exists($profil->cv_path)) {
            abort(404);
        }

        $path = Storage::disk('public')->path($profil->cv_path);
        $filename = basename($path);
        $mime = mime_content_type($path);

        return response()->download($path, $filename, [
            'Content-Type' => $mime,
        ]);
    }

    // Suppression d'une candidature/profil
    public function destroyProfil(Profil $profil)
    {
        // Suppression des indices de confiance liés
        $profil->confidenceIndices()->delete();
        // Suppression du profil
        $profil->delete();
        return redirect()->route('admin.dashboard')->with('success', 'Candidature supprimée avec succès.');
    }
}
