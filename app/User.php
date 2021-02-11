<?php

namespace Serbinario;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Serbinario\Entities\Parametro;
use Spatie\Permission\Traits\HasRoles;


class User extends Authenticatable
{
    use Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'franquia_id', 'is_active', 'secretaria_id',
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
     * Get the projeto for this model.
     */
    public function franquia()
    {
        return $this->hasOne('Serbinario\Entities\Instituicao','id','franquia_id');
    }
    public function secretaria()
    {
        return $this->hasOne('Serbinario\Entities\Secretaria','id','secretaria_id');
    }
}
