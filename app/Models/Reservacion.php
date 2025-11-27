<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Reservacion extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'mesa_id',
        'cliente_id',
        'fecha_hora',
        'numero_personas',
    ];
}
