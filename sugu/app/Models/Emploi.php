<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Emploi extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'titre',
        'ville',
        'description',
        'salaire',
    ];

    protected $casts = [
        'salaire' => 'decimal:2',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
