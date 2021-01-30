<?php

namespace Serbinario\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;


class FranquiaFormRequest extends FormRequest
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
                'nome' => 'required|string|min:1|max:200',
            'cpf_cnpj' => 'required|string|min:1|max:20',
            'contato' => 'required|string|min:1|max:200',
            'telefone' => 'nullable|string|min:0|max:20',
            'email' => 'nullable|string|min:0|max:100',
            'cidade' => 'nullable|string|min:0|max:200',
            'estado' => 'nullable|string|min:0|max:2',
            'endereco' => 'nullable|string|min:0|max:200',
            'cep' => 'nullable|string|min:0|max:12',
            'bairro' => 'nullable|string|min:0|max:100',
            'numero' => 'nullable|string|min:0|max:10',
            'complemento' => 'nullable|string|min:0|max:100',
            'is_active' => 'nullable|boolean',
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
        $data = $this->only(['nome', 'cpf_cnpj', 'contato', 'telefone', 'email', 'cidade', 'estado', 'endereco', 'cep', 'bairro', 'numero', 'complemento', 'is_active', 'base_preco_revenda_id']);
        $data['is_active'] = $this->has('is_active');
        return $data;
    }

}