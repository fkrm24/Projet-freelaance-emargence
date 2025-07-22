<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Profil;

class DashboardController extends Controller
{
    public function menu(Request $request)
    {
        $user = $request->user();
        $mode = $request->query('mode', null); // null par défaut

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

        if ($mode === 'edit') {
            $profil = $user->profil()->with(['experiences', 'references'])->first();
            if (!$profil) {
                // Si pas de profil, redirige vers formulaire vide
                return redirect()->route('dashboard.menu', ['mode' => 'create']);
            }
            return view('dashboard', [
                'profil' => $profil,
                'mode' => 'edit',
                'secteurs' => $secteurs,
                'user' => $user,
            ]);
        } elseif ($mode === 'create') {
            $profil = new Profil();
            return view('dashboard', [
                'profil' => $profil,
                'mode' => 'create',
                'secteurs' => $secteurs,
                'user' => $user,
            ]);
        } else {
            // Affiche TOUJOURS le menu si aucun mode explicite n'est passé
            return view('dashboard_menu');
        }
    }
}
