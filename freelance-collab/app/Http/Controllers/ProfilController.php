<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Profil;
use App\Models\Reference;
use App\Models\User;
use App\Notifications\NewCandidatureNotification;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class ProfilController extends Controller
{

    public function index()
    {
        $profils = json_decode(File::get(resource_path('data/profils.json')), true)['profils'];
        $competences = json_decode(File::get(resource_path('data/competences.json')), true)['competences'];
        $expertises = json_decode(File::get(resource_path('data/expertises.json')), true)['expertises'];

        $secteurs = [
            'Agriculture',
            'Industrie',
            'Construction',
            'Tertiaire',
            'Commerce',
            'Transports',
            'Hébergement et restauration',
            'Information et communication',
            'Finance',
            'Banque',
            'Assurance',
            'Immobilier',
            'Services principalement aux entreprises',
            'Administration publique',
            'Enseignement',

            'Santé',
            'Hébergement médico-social, action sociale',
            'Services aux ménages',
            'Activité indéterminée'
        ];

        // Récupérer le profil de l'utilisateur connecté s'il existe
        $profil = auth()->user()->profils()->latest()->first();

        return view('dashboard', compact('profils', 'competences', 'expertises', 'profil', 'secteurs'));
    }
    public function submit(Request $request)
    {
        // Log d'entrée de la requête (avant validation)
        \Log::info('ProfilController@submit: requête reçue', ['input' => $request->all()]);
        try {
            $validated = $request->validate([
                'nom' => 'required|string|max:255',
                'prenom' => 'required|string|max:255',
                'date_naissance' => 'required|date',
                'date_disponibilite' => 'required|date',
                'telephone' => 'required|string',
                'profil' => 'required|string',
                'expertise' => 'required|string',
                'competences' => ['required', function ($attribute, $value, $fail) {
                    if (!is_string($value) || !is_array(json_decode($value, true))) {
                        $fail('Le champ compétences doit être un tableau JSON valide.');
                    }
                }],
                'experience' => 'required|integer',
                'date_diplome' => 'required|date',
                'niveau_diplome' => 'required|in:Licence,M1,M2,Doctorat',
                'sexe' => 'required|in:Homme,Femme',
                'linkedin' => 'nullable|url|max:255',
                'tjm' => 'nullable|integer',
                'cv' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
                'experiences' => 'required|array',
                'experiences.*.date_debut' => 'required|date',
                'experiences.*.date_fin' => 'required|date',
                'experiences.*.societe' => 'required|string',
                'experiences.*.secteur' => 'required|string',
                'experiences.*.poste' => 'required|string',
                'experiences.*.detail' => 'required|string',
                'experiences.*.references.*.telephone' => 'nullable|string',
                'experiences.*.references.*.nom' => 'nullable|string',
                'experiences.*.references.*.prenom' => 'nullable|string',
                'experiences.*.references.*.fonction' => 'nullable|string',
                'experiences.*.references.*.email' => 'nullable|email',
                'experiences.*.references.*.societe' => 'nullable|string',
                'experiences.*.references.*.secteur' => 'nullable|string',
            ]);

            // Gestion du CV si présent
            $cvPath = null;
            if ($request->hasFile('cv')) {
                $cvPath = $request->file('cv')->store('cvs', 'public');
            }

            // Mettre à jour la date de disponibilité de l'utilisateur
            auth()->user()->update([
                'date_disponibilite' => $request->date_disponibilite
            ]);

            // Détecter si édition ou création
            $profilId = $request->input('profil_id');
            if ($profilId) {
                $profil = Profil::find($profilId);
                if ($profil && $profil->user_id == auth()->id()) {
                    $profil->update([
                        'nom' => $request->nom,
                        'prenom' => $request->prenom,
                        'date_naissance' => $request->date_naissance,
                        'telephone' => $request->telephone,
                        'profil' => $request->profil,
                        'expertise' => $request->expertise,
                        'competences' => json_decode($request->competences, true),
                        'experience' => $request->experience,
                        'date_diplome' => $request->date_diplome,
                        'linkedin' => $request->linkedin,
                        'tjm' => $request->tjm,
                        'cv_path' => $cvPath,
                        'niveau_diplome' => $request->niveau_diplome,
                        'sexe' => $request->sexe,
                    ]);
                } else {
                    return back()->withErrors(['error' => 'Profil non trouvé ou non autorisé.']);
                }
            } else {
                $profil = auth()->user()->profils()->create([
                    'nom' => $request->nom,
                    'prenom' => $request->prenom,
                    'date_naissance' => $request->date_naissance,
                    'telephone' => $request->telephone,
                    'profil' => $request->profil,
                    'expertise' => $request->expertise,
                    'competences' => json_decode($request->competences, true),
                    'experience' => $request->experience,
                    'date_diplome' => $request->date_diplome,
                    'linkedin' => $request->linkedin,
                    'tjm' => $request->tjm,
                    'cv_path' => $cvPath,
                    'niveau_diplome' => $request->niveau_diplome,
                    'sexe' => $request->sexe,
                    'taux_disponibilite' => $request->taux_disponibilite,
                ]);
            }

            // Notifier les admins
            $admins = User::where('is_admin', true)->get();
            foreach ($admins as $admin) {
                $admin->notify(new NewCandidatureNotification($profil));
            }

            // Création automatique des indices de confiance (comme dans le seeder)
            $defaultIndices = [
                ['percentage' => 100, 'color_code' => 'vert', 'is_active' => true, 'commentaire' => 'Confiance totale', 'admin_id' => 1],
                ['percentage' => 50, 'color_code' => 'orange', 'is_active' => false, 'commentaire' => 'Confiance moyenne', 'admin_id' => 1],
                ['percentage' => 25, 'color_code' => 'rouge', 'is_active' => false, 'commentaire' => 'Confiance faible', 'admin_id' => 1],
                ['percentage' => 0, 'color_code' => 'noir', 'is_active' => false, 'commentaire' => 'Aucune confiance', 'admin_id' => 1],
            ];
            foreach ($defaultIndices as $index) {
                $profil->confidenceIndices()->create($index);
            }

            // LOG: Contenu des expériences reçues
            \Log::info('ProfilController@submit - Expériences reçues', ['experiences' => $validated['experiences']]);

            // Création des expériences et des références
            foreach ($validated['experiences'] as $experience) {
                try {
                    \Log::info('ProfilController@submit - Tentative création expérience', ['experience' => $experience]);
                    $exp = $profil->experiences()->create([
                        'date_debut' => $experience['date_debut'],
                        'date_fin' => $experience['date_fin'],
                        'societe' => $experience['societe'],
                        'secteur' => $experience['secteur'],
                        'poste' => $experience['poste'],
                        'detail' => $experience['detail'],
                    ]);

                    // Références
                    if (isset($experience['references']) && is_array($experience['references'])) {
                        \Log::info('ProfilController@submit - Références trouvées pour expérience', ['references' => $experience['references']]);
                        foreach ($experience['references'] as $reference) {
                            if (empty($reference['nom']) || empty($reference['prenom']) || empty($reference['email'])) {
                                \Log::warning('Référence ignorée car incomplète', ['reference' => $reference]);
                                continue;
                            }
                            try {
                                \Log::info('ProfilController@submit - Tentative création référence', ['reference' => $reference]);
                                $exp->references()->create([
                                    'nom' => $reference['nom'],
                                    'prenom' => $reference['prenom'],
                                    'fonction' => $reference['fonction'] ?? null,
                                    'email' => $reference['email'],
                                    'telephone' => $reference['telephone'] ?? null,
                                    'profil_id' => $profil->id, // Ajout explicite
                                ]);
                            } catch (\Exception $e) {
                                \Log::error('ProfilController@submit - Erreur création référence', ['exception' => $e->getMessage(), 'reference' => $reference]);
                            }
                        }
                    } else {
                        \Log::info('ProfilController@submit - Aucune référence pour cette expérience', ['experience' => $experience]);
                    }
                } catch (\Exception $e) {
                    \Log::error('ProfilController@submit - Erreur création expérience', ['exception' => $e->getMessage(), 'experience' => $experience]);
                }
            }

            \Log::info('Profil créé avec succès. ID:', ['id' => $profil->id]);
            return redirect()->route('merci');
        } catch (\Illuminate\Validation\ValidationException $e) {
            \Log::error('Erreur de validation profil', ['errors' => $e->errors(), 'input' => $request->all()]);
            throw $e;
        } catch (\Exception $e) {
            \Log::error('Erreur création profil', ['exception' => $e, 'stack' => $e->getTraceAsString()]);
            return back()->withInput()->withErrors(['error' => 'Une erreur est survenue lors de la création du profil.']);
        }
    }
}
