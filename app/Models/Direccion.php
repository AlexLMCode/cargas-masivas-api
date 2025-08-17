<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Direccion extends Model
{
    protected $fillable = [
        'calle',
        'numero_exterior',
        'numero_interior',
        'colonia',
        'cp',
        'persona_id'
    ];

    public function persona_id()
    {
        return $this->belongsTo(Persona::class, 'user_id', 'id');
    }
}
