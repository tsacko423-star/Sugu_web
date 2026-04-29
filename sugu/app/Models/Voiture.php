<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Voiture extends Model
{
    protected $fillable = [
        'marque',
        'modele',
        'annee',
        'prix',
        'image',
        'user_id',
    ];
    public function user()
{
    return $this->belongsTo(User::class);
}
}
