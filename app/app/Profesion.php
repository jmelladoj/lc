<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Profesion extends Model
{
    //
    protected $table = 'profesiones';

    use SoftDeletes;

    protected $fillable = [
        'id', 'nombre', 'tipo_persona'
    ];
}
