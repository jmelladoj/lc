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



    public function getCantidadLikeAttribute(){
        return $this->hasMany(Valoracion::class, 'user_id')->where('tipo_votacion', 1)->count();
    }

    public function getCantidadDislikeAttribute(){
        return $this->hasMany(Valoracion::class, 'user_id')->where('tipo_votacion', 2)->count();
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
