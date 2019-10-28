<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ParticipanteSorteo extends Model
{
    //
    protected $fillable = [
        'id','sorteo_id', 'user_id', 'ganador'
    ];
}
