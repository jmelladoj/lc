<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Avatar extends Model
{
    //
    protected $table = 'avatares';

    protected $guarded = [
        'id'
    ];
}
