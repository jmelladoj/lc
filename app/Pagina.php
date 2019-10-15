<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pagina extends Model
{
    //
    protected $fillable = [
        'id','nombre', 'contenido', 'mensaje_uno', 'mensaje_dos', 'video_url'
    ];
}
