<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Categorie extends Model
{
    protected $fillable = ['name', 'icon'];

    public function annonces()
    {
        return $this->hasMany(Annonce::class);
    }
}
