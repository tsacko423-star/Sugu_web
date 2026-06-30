<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AnnonceAttribut extends Model
{
    use HasFactory;

    protected $fillable = [
        'annonce_id',
        'nom',
        'valeur',
    ];

    public function annonce(): BelongsTo
    {
        return $this->belongsTo(Annonce::class);
    }
}
