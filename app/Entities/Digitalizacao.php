<?php

namespace Serbinario\Entities;

use Illuminate\Database\Eloquent\Model;

class Digitalizacao extends Model
{


    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'digitalizacao';

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
        'numero_processo',
        'competencia',
        'convenio',
        'conta',
        'despesa_id',
        'secretaria_id',
        'unidade_orcamento',
        'fornecedor',
        'cpf_fornecedor',
        'empenho_id',
        'data_empenho',
        'numero_empenho',
        'data_pagto',
        'numero_licitacao',
        'modalidade_id',
        'objeto_licitacao',
        'data_homologa',
        'vencedor',
        'valor',
        'funcionario',
        'cpf',
        'matricula',
        'portaria',
        'data_admissao',
        'lotacao',
        'descricaolei',
        'resumolei',
        'data_lei',
        'data_publica',
        'documento',
        'data_docto',
        'objeto_docto',
        'tipodoc_id',
        'localizacao',
        'observacao',
        'arquivo',
        'user_id',
        'ativo',
        'excluido'
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
    public function getDataHomologaAttribute($value)
    {
        return $value == "" ? "" : date('d/m/Y', strtotime($value));
    }

    public function setDataHomologaAttribute($value)
    {
        $this->attributes['data_homologa'] =  !empty($value) ? substr($value,6,4)."-".substr($value,3,2)."-".substr($value,0,2) : null;
    }

    public function getDataDoctoAttribute($value)
    {
        return $value == "" ? "" : date('d/m/Y', strtotime($value));
    }

    public function setDataDoctoAttribute($value)
    {
        $this->attributes['data_docto'] =  !empty($value) ? substr($value,6,4)."-".substr($value,3,2)."-".substr($value,0,2) : null;
    }

    public function getDataPagtoAttribute($value)
    {
        return $value == "" ? "" : date('d/m/Y', strtotime($value));
    }

    public function setDataPagtoAttribute($value)
    {
        $this->attributes['data_pagto'] =  !empty($value) ? substr($value,6,4)."-".substr($value,3,2)."-".substr($value,0,2) : null;
    }

    public function getDataLeiAttribute($value)
    {
        return $value == "" ? "" : date('d/m/Y', strtotime($value));
    }

    public function setDataLeiAttribute($value)
    {
        $this->attributes['data_lei'] =  !empty($value) ? substr($value,6,4)."-".substr($value,3,2)."-".substr($value,0,2) : null;
    }

    public function getDataPublicaAttribute($value)
    {
        return $value == "" ? "" : date('d/m/Y', strtotime($value));
    }

    public function setdataPublicaAttribute($value)
    {
        $this->attributes['data_publica'] =  !empty($value) ? substr($value,6,4)."-".substr($value,3,2)."-".substr($value,0,2) : null;
    }

    public function getDataAdmissaoAttribute($value)
    {
        return $value == "" ? "" : date('d/m/Y', strtotime($value));
    }

    public function setDataAdmissaoAttribute($value)
    {
        $this->attributes['data_admissao'] =  !empty($value) ? substr($value,6,4)."-".substr($value,3,2)."-".substr($value,0,2) : null;
    }

    public function getDataEmpenhoAttribute($value)
    {
        return $value == "" ? "" : date('d/m/Y', strtotime($value));
    }

    public function setDataEmpenhoAttribute($value)
    {
        $this->attributes['data_empenho'] =  !empty($value) ? substr($value,6,4)."-".substr($value,3,2)."-".substr($value,0,2) : null;
    }


    public function files()
    {
        return $this->hasMany('Serbinario\Entities\DigitalizacaoFile','digitalizacao_id','id');
    }

    public function despesa(){
        return $this->hasOne('Serbinario\Entities\Despesa','id','despesa_id');
    }

    public function tipoDoc(){
        return $this->hasOne('Serbinario\Entities\TipoDocumento','id','tipodoc_id');
    }




}
