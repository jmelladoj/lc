<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ParticipanteSeminario extends Model
{
    //
    protected $guarded = [];
    
    public function usuario(){
        return $this->belongsTo(User::class, 'user_id');
    }

    public function seminario(){
        return $this->belongsTo(Seminario::class, 'seminario_id');
    }
}
