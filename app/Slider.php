<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Slider extends Model
{
    //
    use SoftDeletes;

    protected $guarded = [
        'id'
    ];

    protected $dates = ['deleted_at'];
    protected $appends = ['seccion'];

    public function getSeccionAttribute(){
        $link = substr($this->link, -1);
        switch ($link) {
            case 0: 
                return "Sin sección";
                break;
            case 1:
                return "Mi perfil";
                break;
            case 2:
                return "Pide documento";
                break;
            case 3:
                return "Sorteos";
                break;
            case 4:
                return "Promociones";
                break;
            case 6:
                return "Seminarios";
                break;
            case 7:
                return "Visitas a terreno";
                break;
            case 8:
                return "Recomiéndanos";
                break;
            case 11:
                return "Subir documento";
                break;
            case 12:
                return "Recargar";
                break;
        
        }
    }
}
