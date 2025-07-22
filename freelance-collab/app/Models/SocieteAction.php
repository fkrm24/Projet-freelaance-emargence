<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SocieteAction extends Model
{
    use HasFactory;
    protected $fillable = [
        'societe_id',
        'contact_id',
        'contact_type',
        'motif',
        'date_action',
        'commentaire',
        'user_id',
        'action_a_venir',
        'evaluation',
    ];
    public function societe() {
        return $this->belongsTo(Contact::class, 'societe_id');
    }
    public function user() {
        return $this->belongsTo(User::class);
    }
    // Relation polymorphe vers le contact lié (manuel ou référence)
    public function contactable() {
        return $this->morphTo(null, 'contact_type', 'contact_id');
    }
}
