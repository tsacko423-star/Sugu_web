<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attribut extends Model
{
    protected $fillable = ['nom'];

    public function annonceAttributs()
    {
        return $this->hasMany(AnnonceAttribut::class);
    }
}

