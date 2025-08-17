<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Telefono extends Model
{
    protected $fillable = [
        'telefono',
        'persona_id'
    ];

    public function persona_id()
    {
        return $this->belongsTo(Persona::class, 'user_id', 'id');
    }
}
