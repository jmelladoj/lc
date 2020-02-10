<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CategoriaUsuario extends Model
{
    //
    use SoftDeletes;

    protected $guard = ['id'];

    protected $dates = ['deleted_at'];

}
