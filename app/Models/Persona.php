<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Persona extends Model
{
    protected $fillable = [
        'nombre',
        'paterno',
        'materno'
    ];

    public function direcciones()
    {
        return $this->hasMany(Direccion::class, 'persona_id', 'id');
    }

    public function telefonos()
    {
        return $this->hasMany(Telefono::class, 'persona_id', 'id');
    }
}
