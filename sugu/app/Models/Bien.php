<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bien extends Model
{
    protected $fillable = [
        'titre',
        'prix',
        'ville',
        'image',
        'user_id'
    ];
    public function user()
{
    return $this->belongsTo(User::class);
}
}
