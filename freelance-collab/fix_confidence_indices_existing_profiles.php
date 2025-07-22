<?php
// Script à lancer avec: php fix_confidence_indices_existing_profiles.php

use App\Models\Profil;

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);

$defaultIndices = [
    ['percentage' => 100, 'color_code' => 'vert', 'is_active' => true, 'commentaire' => 'Confiance totale'],
    ['percentage' => 75, 'color_code' => 'jaune', 'is_active' => false, 'commentaire' => 'Confiance moyenne'],
    ['percentage' => 50, 'color_code' => 'orange', 'is_active' => false, 'commentaire' => 'Confiance faible'],
    ['percentage' => 25, 'color_code' => 'rouge', 'is_active' => false, 'commentaire' => 'Confiance très faible'],
    ['percentage' => 0, 'color_code' => 'noir', 'is_active' => false, 'commentaire' => 'Aucune confiance'],
];

foreach (Profil::all() as $profil) {
    if ($profil->confidenceIndices()->count() == 0) {
        foreach ($defaultIndices as $index) {
            $profil->confidenceIndices()->create($index);
        }
        echo "Indices ajoutés au profil ID {$profil->id}\n";
    }
}

echo "Terminé.\n";
