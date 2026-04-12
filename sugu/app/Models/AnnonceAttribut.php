<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AnnonceAttribut extends Model
{
    protected $fillable = ['annonce_id', 'attribut_id', 'valeur'];

    public function annonce()
    {
        return $this->belongsTo(Annonce::class);
    }

    public function attribut()
    {
        return $this->belongsTo(Attribut::class);
    }
}
