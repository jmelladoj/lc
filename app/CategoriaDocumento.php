<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CategoriaDocumento extends Model
{
    //
    use SoftDeletes;

    protected $fillable = [
        'id','nombre'
    ];

    protected $dates = ['deleted_at'];
    protected $appends = ['cantidad_documentos'];

    public function getCantidadDocumentosAttribute(){
        return $this->hasMany(Documento::class, 'categorias_documentos_id')->count();
    }
}
