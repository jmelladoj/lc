<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CategoriaDocumento extends Model
{
    //
    use SoftDeletes;

    protected $guarded = ['id','nombre'];
    protected $appends = ['cantidad_documentos'];

    protected $dates = ['deleted_at'];

    public function getCantidadDocumentosAttribute(){
        return $this->hasMany(Documento::class, 'categorias_documentos_id')->count();
    }
}
