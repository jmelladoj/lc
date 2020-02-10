<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Servicio extends Model
{
    //
    protected $fillable = [
        'id', 'nombre', 'descripcion', 'imagen_url'
    ];
}
