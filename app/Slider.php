<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Slider extends Model
{
    //
    use SoftDeletes;

    protected $fillable = [
        'id','texto', 'color', 'url_imagen', 'link', 'inicio', 'descanso_uno', 'descanso_dos', 'pagina_nosotros', 'pagina_contacto', 'pagina_comunidad', 'pagina_servicios'
    ];

    protected $dates = ['deleted_at'];
}
