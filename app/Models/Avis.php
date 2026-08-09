<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Avis extends Model
{
    protected $table = 'avis';

    protected $guarded = ['id'];

    protected $casts = [
        'note' => 'integer',
        'actif' => 'boolean',
    ];
}
