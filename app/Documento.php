<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Documento extends Model
{
    //
    use SoftDeletes;

    protected $guarded = ['id'];
    protected $appends = ['nombre_categoria', 'extension_documento', 'timer'];

    protected $dates = ['created_at', 'deleted_at'];

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
            case "rar":
            case "zip":
            case "7zip":
                return 'img/compress.png';
            break;
        }
    }

    public function usuario(){
        return $this->belongsTo(User::class, 'user_id');
    }

    public function categoria(){
        return $this->belongsTo(CategoriaDocumento::class, 'categorias_documentos_id');
    }

    public function getTimerAttribute(){
        $fecha = '';

        if($this->timer_dias && $this->timer_hora){
            $fecha = $this->timer_dias . ' ' . $this->timer_hora . ':00';
        } else if($this->timer_dias && !$this->timer_hora){
            $fecha = $this->timer_dias;
        } else if(!$this->timer_dias && $this->timer_hora){
            $horas = (int)substr($this->timer_hora, 0, 2);

            $fecha = Carbon::parse($this->created_at)->addHour($horas);

        }
        
        //$diferencia_dias = Carbon::parse($fecha)->diffInDays(Carbon::now());
        //$diferencia_horas = Carbon::parse($fecha)->diffInHours(Carbon::now());
        //$diferencia_minutos = Carbon::parse($fecha)->diffInMinutes(Carbon::now());
        
        $diferencia_segundos = Carbon::parse($fecha)->diffInSeconds(Carbon::now());

        if(Carbon::now()->lessThanOrEqualTo(Carbon::parse($fecha))){
            return $diferencia_segundos;
        } else {
            return 0;
        }
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
            case "zip":
                return "ZIP";
            break;
            case "rar":
                return "RAR";
            break;
            case "zip":
                return "7ZIP";
            break;
        }
    }
}
