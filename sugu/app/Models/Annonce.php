<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Annonce extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'categorie_id',
        'titre',
        'description',
        'prix',
        'images',
    ];

    protected $casts = [
        'images' => 'array',
        'prix' => 'decimal:2',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function categorie(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'categorie_id');
    }

    public function annonceAttributs(): HasMany
    {
        return $this->hasMany(AnnonceAttribut::class);
    }

    public function attributs(): HasMany
    {
        return $this->annonceAttributs();
    }
}
