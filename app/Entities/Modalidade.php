<?php

namespace Serbinario\Entities;

use Illuminate\Database\Eloquent\Model;

class Modalidade extends Model
{


    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'modalidades';

    /**
     * The database primary key value.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = [
        'descricao',
        'ativo'
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [];

}
