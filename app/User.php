<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [
        'id'
    ];

    protected $appends = ['persona', 'region', 'porcentaje_like', 'like_porcentaje_admin', 'nombre_comuna', 'nombre_rubro', 'ultima_recarga', 'total_invertido', 'nivel_cliente', 'nombre_profesion', 'total_bono_acumulado'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getCantidadValoracionesAttribute(){
        return $this->hasMany(Valoracion::class, 'user_id')->where('tipo_usuario_votacion', 3)->count();
    }

    public function getCantidadValoracionesAdminAttribute(){
        return $this->hasMany(Valoracion::class, 'user_id')->where('tipo_usuario_votacion', '<', 3)->count();
    }

    public function getCantidadLikeAttribute(){
        return $this->hasMany(Valoracion::class, 'user_id')->where('tipo_votacion', 1)->where('tipo_usuario_votacion', 3)->count();
    }

    public function getCantidadDislikeAttribute(){
        return $this->hasMany(Valoracion::class, 'user_id')->where('tipo_votacion', 2)->where('tipo_usuario_votacion', 3)->count();
    }

    public function getCantidadLikeAdminAttribute(){
        return $this->hasMany(Valoracion::class, 'user_id')->where('tipo_votacion', 1)->where('tipo_usuario_votacion', '<', 3)->count();
    }

    public function getCantidadDislikeAdminAttribute(){
        return $this->hasMany(Valoracion::class, 'user_id')->where('tipo_votacion', 2)->where('tipo_usuario_votacion', '<', 3)->count();
    }

    public function getNombreComunaAttribute(){
        return $this->comuna ? $this->comuna->nombre : 'Sin comuna';
    }

    public function getNombreRubroAttribute(){
        return $this->rubro ? $this->rubro->nombre : 'Sin rubro';
    }

    public function getUltimaRecargaAttribute(){
        return $this->recargas()->count() > 0 ? $this->recargas()->first()->created_at->format('Y-m-d h:m:s') : 'Sin recargas aún.';
    }

    public function getTotalInvertidoAttribute(){
        return $this->recargas()->count() > 0 ? $this->recargas()->sum('monto_venta') : 0;
    }
    
    public function getTotalBonoAcumuladoAttribute(){
        return $this->recargas()->count() > 0 ? $this->recargas()->sum('monto_bonificacion') : 0;
    }

    public function getLikePorcentajeAdminAttribute(){
        $porcentaje = 0;

        $total_numero_likes = $this->cantidadLike + $this->cantidadLikeAdmin;
        $total_numero_dislikes = $this->cantidadDislike + $this->cantidadDislikeAdmin;

        $total_valoraciones_usuario = $this->cantidadLike + $this->cantidadDislike;
        $total_valoraciones_admin = $this->cantidadLikeAdmin + $this->cantidadDislikeAdmin;
        $total_valoraciones = $total_valoraciones_admin + $total_valoraciones_usuario;

        $diferencia_porcentaje_admin = $this->likes - $this->dislikes;

        if($this->likes > 0 || $this->dislikes > 0 && $total_valoraciones > 0 ){
            $porcentaje = (($total_numero_likes * 100) / $total_valoraciones) + $diferencia_porcentaje_admin;
        } else if($this->likes > 0 || $this->dislikes > 0 && $total_valoraciones == 0){
            $porcentaje = (($this->cantidadLike * 100) / $total_valoraciones_usuario) + $diferencia_porcentaje_admin;
        } else if($this->cantidadLike > 0 || $this->cantidadDislike > 0){
            $porcentaje = ($this->cantidadLike * 100) / ($this->cantidadLike + $this->cantidadDislike);
        }

        return $porcentaje;
    }

    public function getPorcentajeLikeAttribute(){
        $porcentaje = 0;

        if($this->cantidadLike > 0 && $this->cantidad_valoraciones > 0 && $this->cantidadLike > 0){
            $porcentaje = $this->cantidadLike * 100 / $this->cantidad_valoraciones;
        }

        return $porcentaje;
    }

    public function getPorcentajeLikeVipAttribute(){
        $porcentaje = 0;

        if($this->cantidadLike > 0 && $this->cantidad_valoraciones > 0 && $this->cantidadLike > 0){
            $porcentaje = (int) (($this->cantidadLike + $this->cantidadDislike) + ($this->likePorcentajeAdmin - (100 - $this->likePorcentajeAdmin)) / $this->cantidad_valoraciones);
        }

        return $porcentaje;
    }

    public function getRegionAttribute(){
        return isset($this->comuna) ? $this->comuna->provincia->region_id : null;
    }

    public function categoria(){
        return $this->belongsTo(CategoriaUsuario::class, 'categorias_usuarios_id');
    }

    public function comuna(){
        return $this->belongsTo(Comuna::class, 'comuna_id');
    }

    public function rubro(){
        return $this->belongsTo(Rubro::class, 'rubro_id');
    }

    public function profesion(){
        return $this->belongsTo(Profesion::class, 'profesion_id');
    }

    public function valoraciones(){
        return $this->hasMany(Valoracion::class, 'user_id');
    }

    public function recargas(){
        return $this->hasMany(Venta::class, 'user_id')->orderBy('created_at', 'desc')->get();
    }

    public function getNivelClienteAttribute(){
        return isset($this->categoria) ? $this->categoria->nivel : 'Sin información';
    }

    public function getNombreProfesionAttribute(){
        return isset($this->profesion) ? $this->profesion->nombre : 'Sin información';
    }

    public function getPersonaAttribute(){
        switch ($this->tipo_persona) {
            case 1:
                return "Persona";
                break;
            case 2:
                return "Pyme";
                break;
            case 3:
                return "Estudiante";
                break;
        }
    }
}
