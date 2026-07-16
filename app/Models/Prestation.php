<?php

namespace App\Models;

use App\Enums\PrestationCategorie;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Prestation extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $casts = [
        'categorie' => PrestationCategorie::class,
    ];

    public function devisLignes(): HasMany
    {
        return $this->hasMany(DevisLigne::class);
    }
}
