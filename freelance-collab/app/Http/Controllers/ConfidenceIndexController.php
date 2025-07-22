<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Profil;

class ConfidenceIndexController extends Controller
{
    // Remet tous les indices à inactif pour un profil (pour l'option "à compléter")
    public function reset(Profil $profil)
    {
        $profil->confidenceIndices()->update(['is_active' => false]);
        return response()->json(['success' => true]);
    }
}
