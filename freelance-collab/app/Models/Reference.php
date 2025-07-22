<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Profil;

class Reference extends Model
{
    public function societes()
    {
        return $this->belongsToMany(Contact::class, 'contact_societe', 'reference_id', 'societe_id');
    }
    use HasFactory;

    protected $fillable = [
        'profil_id',
        'experience_id', // Ajouté pour l'association automatique
        'entreprise',
        'secteur',
        'nom',
        'prenom',
        'fonction',
        'email',
        'telephone',
        'societe',
    ];

    public function profil()
    {
        return $this->belongsTo(Profil::class);
    }

    public function experience()
    {
        return $this->belongsTo(Experience::class);
    }

}
