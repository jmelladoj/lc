<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SolicitudDocumento extends Model
{
    //
    protected $guarded = [];
    
    public function usuario(){
        return $this->belongsTo(User::class, 'user_id');
    }
}
