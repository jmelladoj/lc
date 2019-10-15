<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SubCategoriaDocumento extends Model
{
    //
    use SoftDeletes;

    protected $fillable = [
        'id','nombre', 'categoria_documento_id'
    ];

    protected $dates = ['deleted_at'];
}
