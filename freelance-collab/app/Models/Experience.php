<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Profil;

class Experience extends Model
{
    use HasFactory;

    protected $fillable = [
        'date_debut',
        'date_fin',
        'societe',
        'secteur',
        'poste',
        'detail',
        'profil_id'
    ];

    protected $casts = [
        'date_debut' => 'date',
        'date_fin' => 'date'
    ];

    public function profil()
    {
        return $this->belongsTo(Profil::class);
    }
    public function references()
    {
        return $this->hasMany(Reference::class);
    }
}
