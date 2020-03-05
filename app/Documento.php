<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Documento extends Model
{
    //
    use SoftDeletes;

    protected $guarded = ['id'];
    protected $appends = ['nombre_categoria', 'extension_documento'];

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

    public function usuario(){
        return $this->belongsTo(User::class, 'user_id');
    }

    public function categoria(){
        return $this->belongsTo(CategoriaDocumento::class, 'categorias_documentos_id');
    }

    public function getNombreCategoriaAttribute(){
        return $this->categorias_documentos_id != null ? $this->categoria->nombre : 'Sin categoría';
    }

    public function getExtensionDocumentoAttribute(){
        switch ($this->extension) {
            case "pdf":
                return "PDF";
                break;
            case "docx":
                return "WORD";
                break;
            case "xlsx":
                return "EXCEL";
                break;
            case "mp4":
                return "MP4";
                break;
            case "pptx":
                return "POWER POINT";
                break;
            case "mp3":
                return "MP3";
                break;
        }
    }
}
