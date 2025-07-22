<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\User;
use App\Models\Reference;
use App\Models\ConfidenceIndex;

class Profil extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'nom',
        'prenom',
        'date_naissance',
        'telephone',
        'profil',
        'expertise',
        'competences',
        'experience',
        'date_diplome',
        'niveau_diplome',
        'sexe',
        'linkedin',
        'tjm',
        'cv_path',
        'taux_disponibilite'
    ];

    protected $casts = [
        'competences' => 'array',
        'expertise' => 'array',
        'date_naissance' => 'date',
        'date_diplome' => 'date'
    ];

    public function getFormattedExpertiseAttribute()
    {
        if (!is_array($this->expertise)) {
            return '';
        }
        return collect($this->expertise)
            ->pluck('text')
            ->implode(', ');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function references()
    {
        return $this->hasMany(Reference::class);
    }

    public function experiences()
    {
        return $this->hasMany(Experience::class);
    }

    public function confidenceIndices()
    {
        return $this->hasMany(ConfidenceIndex::class);
    }
}
