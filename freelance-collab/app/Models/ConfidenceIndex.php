<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ConfidenceIndex extends Model
{
    protected $fillable = ['profil_id', 'admin_id', 'commentaire', 'percentage', 'color_code'];

    public function profil(): BelongsTo
    {
        return $this->belongsTo(Profil::class);
    }

    public function admin(): BelongsTo
    {
        return $this->belongsTo(User::class, 'admin_id');
    }
}
