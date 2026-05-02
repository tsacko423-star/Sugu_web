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

    public function getImageUrlAttribute()
    {
        $image = $this->attributes['image'] ?? null;
        if (!$image) {
            return null;
        }

        $decoded = json_decode($image, true);
        if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
            $path = $decoded[0] ?? null;
        } else {
            $path = $image;
        }

        return $path ? asset('storage/' . $path) : null;
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
