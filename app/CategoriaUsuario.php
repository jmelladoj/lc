<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CategoriaUsuario extends Model
{
    //
    use SoftDeletes;

    protected $fillable = [
        'id','nombre', 'nivel', 'gasto_inicio', 'gasto_fin', 'color', 'bonificacion'
    ];

    protected $dates = ['deleted_at'];

}
