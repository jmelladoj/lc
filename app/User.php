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

    protected $appends = ['region', 'porcentaje_like', 'like_porcentaje_admin'];

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

    public function getLikePorcentajeAdminAttribute(){
        $porcentaje = 0;

        $total_likes = $this->cantidadLike + $this->likes;
        $total_dislikes = $this->cantidadDislike + $this->dislikes;
        $total_valoraciones_admin = $total_likes + $total_dislikes;

        $porcentaje_likes_admin = $this->CantidadValoracionesAdmin > 0 ? (int) ($this->cantidadLikeAdmin * 100 / $this->CantidadValoracionesAdmin) : 0;
        $porcentaje_dislike_admin = $porcentaje_likes_admin > 0 ? 100 - $porcentaje_likes_admin : 0;

        $diferencia_porcentajes_admin = $porcentaje_likes_admin - $porcentaje_dislike_admin;

        //likes
        //dislikes

        if($this->likes > 0 || $this->dislikes > 0){
            $porcentaje = ($total_likes / $total_valoraciones_admin) + $diferencia_porcentajes_admin;
        } else if($this->cantidadLikeAdmin > 0 || $this->cantidadDislikeAdmin > 0){
            $porcentaje = ($this->cantidad_like / $this->cantidad_valoraciones) + $diferencia_porcentajes_admin;
        } else {
            $porcentaje = $this->porcentajeLike;
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

    public function valoraciones(){
        return $this->hasMany(Valoracion::class, 'user_id');
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
