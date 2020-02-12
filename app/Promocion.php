<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Promocion extends Model
{
    //
    protected $table = 'promociones';

    protected $fillable = [
        'id','titulo', 'fecha', 'categoria_usuario', 'url_imagen'
    ];
}
