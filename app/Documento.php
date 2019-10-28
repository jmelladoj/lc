<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Documento extends Model
{
    //
    use SoftDeletes;

    protected $fillable = [
        'id','titulo', 'descripcion', 'codigo', 'codigo_interno', 'documento_url', 'valor', 'clasificacion', 'cantidad_descargas', 'extension', 'version', 'categorias_documentos_id', 'estado', 'user_id'
    ];

    protected $dates = ['deleted_at'];

    public function getImgAttribute(){
        switch ($this->extension) {
            case "pdf":
                return "img/pdf.png";
                break;
            case "docx":
                return "img/word.png";
                break;
            case "xlsx":
                return "img/excel.png";
                break;
            case "mp4":
                return "img/video.png";
                break;
            case "pptx":
                return "img/ppt.png";
                break;
            case "mp3":
                return "img/mp3.png";
                break;
        }
    }

}
