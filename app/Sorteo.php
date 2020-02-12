<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sorteo extends Model
{
    //
    protected $fillable = [
        'id','titulo', 'valor', 'premio', 'fecha', 'categoria_usuario', 'url_imagen'
    ];
}
