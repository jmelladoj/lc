<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sorteo extends Model
{
    //
    protected $guarded = ['id'];

    protected $appends = ['cantidad_participantes'];

    public function getCantidadparticipantesAttribute(){
        return $this->hasMany(ParticipanteSorteo::class, 'sorteo_id')->count();
    }
}
