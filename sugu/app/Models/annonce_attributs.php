<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class annonce_attributs extends Model
{
    protected $fillable = ['annonce_id', 'attribut_id', 'valeur'];
}
