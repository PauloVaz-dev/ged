<?php

namespace Serbinario\Entities;

use Illuminate\Database\Eloquent\Model;

class DigitalizacaoFile  extends Model
{


    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'digitalizacao_files';

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
        'digitalizacao_id',
        'descricao',
        'ativo',
        'file',
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



    /**
     * Get updated_at in array format
     *
     * @param  string  $value
     * @return array
     */
    public function getUpdatedAtAttribute($value)
    {
        return $value == "" ? "" : date('d/m/Y', strtotime($value));


    }

    /**
     * Get created_at in array format
     *
     * @param  string  $value
     * @return array
     */
    public function getCreatedAtAttribute($value)
    {
        return $value == "" ? "" : date('d/m/Y', strtotime($value));

    }
    /**
     * Get the projeto for this model.
     */
    public function parametro()
    {
        return $this->hasOne('Serbinario\Entities\Parametro','franquia_id','id');
    }

    /**
     * Get the projeto for this model.
     */
    public function basePrecoRevenda()
    {
        return $this->hasOne('Serbinario\Entities\BasePrecoRevenda','id','base_preco_revenda_id');
    }



}
