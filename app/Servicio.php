<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Servicio extends Model
{
    //
    protected $guarded = [
        'id'
    ];

    protected $appends = ['cantidad'];

    public function getCantidadAttribute($key){
        return $this->servicios->count();
    }

    public function servicios(){
        return $this->hasMany(Subservicio::class, 'servicio_id');
    }

}
