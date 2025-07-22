<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    public function actions()
    {
        return $this->hasMany(\App\Models\SocieteAction::class, 'societe_id');
    }
    public function contactsReferences()
    {
        return $this->belongsToMany(Reference::class, 'contact_societe', 'societe_id', 'reference_id');
    }
    public function contactsManuels()
    {
        return $this->belongsToMany(ManualContact::class, 'contact_societe_manuel', 'societe_id', 'manual_contact_id');
    }
    use HasFactory;

    protected $fillable = [
        'societe',
        'secteur',
        'nom',
        'prenom',
        'fonction',
        'email',
        'telephone',
        'adresse',
        'siren',
        'code_naf',
        'tva',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];
}
