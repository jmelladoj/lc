<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Documento extends Model
{
    //
    use SoftDeletes;

    protected $fillable = [
        'id','titulo', 'descripcion', 'codigo', 'codigo_interno', 'documento_url', 'valor', 'clasificacion', 'cantidad_descargas', 'extension', 'version', 'categoria_documentos_id', 'estado', 'user_id'
    ];

    protected $dates = ['deleted_at'];

}
