<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ManualContact extends Model
{
    use HasFactory;

    protected $fillable = [
        'societe_id',
        'societe',
        'secteur',
        'nom',
        'prenom',
        'fonction',
        'email',
        'telephone',
    ];

    public function societe()
    {
        return $this->belongsTo(\App\Models\Contact::class, 'societe_id');
    }
}
