<?php

namespace Serbinario\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;


class Progetov2FormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
                'codigo' => 'nullable|numeric|min:0|max:4294967295',
            'cliente_id' => 'nullable',
            'projeto_status_id' => 'nullable',
            'proposta_id' => 'nullable',
            'endereco_id' => 'nullable',
            'projeto_documento_id' => 'nullable',
            'projeto_execurcao_id' => 'nullable',
            'projeto_finalizando_id' => 'nullable',
            'obs' => 'nullable',
            //'parecer_acesso_image' => 'nullable|mimes:pdf|file|max:2048',
        ];

        return $rules;
    }
    
    /**
     * Get the request's data from the request.
     *
     * 
     * @return array
     */
    public function getData()
    {
        $data = $this->only(['codigo', 'cliente_id', 'projeto_status_id',
            'proposta_id',
            'endereco_id',
            'projeto_documento_id',
            'projeto_prioridade_id',
            'projeto_execurcao_id',
            'projeto_finalizando_id',
            'obs',
            'res_documentacao',
            'res_acompanhamento',
            'data_prevista',
            'conta_contrato_anterior',
            'conta_contrato_atual',
            'titularidade_projeto',
            'titularidade_projeto_cpf',
            'selo_vistoria_image',
            'pendencia',
            'pago',
            'data_pagamento',
            'data_prevista',
            'participacao_obs',
            'pendencia_juridica',
            'obs_juridica'
        ]);

        return $data;
    }

}