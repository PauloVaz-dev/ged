<?php

namespace Serbinario\Models;

use Illuminate\Database\Eloquent\Model;

class ClienteWeb extends Model
{
    

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'clientes';

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
                  'tipo',
                  'cpf_cnpj',
                  'celular',
                  'email',
                  'nome_empresa',
                  'cep',
                  'numero',
                  'endereco',
                  'complemento',
                  'cidade',
                  'estado',
                  'is_whatsapp',
                  'obs',
                  'mae',
                  'pai',
                  'conjugue',
                  'conjugue_cpf',
                  'rg',
                  'data_emissao_rg',
                  'orgao_emissor_rg',
                  'naturalidade_uf',
                  'naturalidade_cidade',
                  'data_nascimento'
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
     * Get the projetos for this model.
     */
    public function projetos()
    {
        return $this->hasMany('Serbinario\Models\Projeto','clientes_id','id');
    }

    /**
     * Set the data_emissao_rg.
     *
     * @param  string  $value
     * @return void
     */
    public function setDataEmissaoRgAttribute($value)
    {
        $this->attributes['data_emissao_rg'] = !empty($value) ? date($this->getDateFormat(), strtotime($value)) : null;
    }

    /**
     * Set the data_nascimento.
     *
     * @param  string  $value
     * @return void
     */
    public function setDataNascimentoAttribute($value)
    {
        $this->attributes['data_nascimento'] = !empty($value) ? date($this->getDateFormat(), strtotime($value)) : null;
    }

    /**
     * Get created_at in array format
     *
     * @param  string  $value
     * @return array
     */
    public function getCreatedAtAttribute($value)
    {
        return date('j/n/Y g:i A', strtotime($value));
    }

    /**
     * Get updated_at in array format
     *
     * @param  string  $value
     * @return array
     */
    public function getUpdatedAtAttribute($value)
    {
        return date('j/n/Y g:i A', strtotime($value));
    }

    /**
     * Get data_emissao_rg in array format
     *
     * @param  string  $value
     * @return array
     */
    public function getDataEmissaoRgAttribute($value)
    {
        return date('j/n/Y g:i A', strtotime($value));
    }

    /**
     * Get data_nascimento in array format
     *
     * @param  string  $value
     * @return array
     */
    public function getDataNascimentoAttribute($value)
    {
        return date('j/n/Y g:i A', strtotime($value));
    }

}
