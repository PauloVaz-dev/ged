<?php

namespace Serbinario\Entities;

use Illuminate\Database\Eloquent\Model;

class Instituicao extends Model
{


    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'franquias';

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
        'nome',
        'cpf_cnpj',
        'contato',
        'telefone',
        'email',
        'cidade',
        'estado',
        'endereco',
        'cep',
        'bairro',
        'numero',
        'complemento',
        'is_active',
        'base_preco_revenda_id',
        'franqueadora',
        'slug',
        'file'
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



}
