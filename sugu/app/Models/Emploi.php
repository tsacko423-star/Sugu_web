<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Emploi extends Model
{
    protected $fillable = [
        'titre',
        'ville',
        'description',
        'salaire',
        'user_id',
    ];
    public function user()
{
    return $this->belongsTo(User::class);
}
}
