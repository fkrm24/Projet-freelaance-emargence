<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Profil;
use App\Models\ConfidenceIndex;

class ConfidenceIndexSeeder extends Seeder
{
    public function run()
    {
        // Pour chaque profil existant, on crée un indice de confiance de test
        $adminId = 1; // À adapter si besoin
        foreach (Profil::all() as $profil) {
            ConfidenceIndex::create([
                'profil_id' => $profil->id,
                'admin_id' => $adminId,
                'percentage' => 100,
                'color_code' => 'vert',
                'commentaire' => 'Indice 100% (vert)',
            ]);
            ConfidenceIndex::create([
                'profil_id' => $profil->id,
                'admin_id' => $adminId,
                'percentage' => 50,
                'color_code' => 'orange',
                'commentaire' => 'Indice 50% (orange)',
            ]);
            ConfidenceIndex::create([
                'profil_id' => $profil->id,
                'admin_id' => $adminId,
                'percentage' => 25,
                'color_code' => 'rouge',
                'commentaire' => 'Indice 25% (rouge)',
            ]);
            ConfidenceIndex::create([
                'profil_id' => $profil->id,
                'admin_id' => $adminId,
                'percentage' => 0,
                'color_code' => 'noir',
                'commentaire' => 'Indice 0% (noir)',
            ]);
        }
    }
}
