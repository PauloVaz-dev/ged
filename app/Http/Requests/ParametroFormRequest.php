<?php

namespace Serbinario\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;


class ParametroFormRequest extends FormRequest
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
                'procu_nome' => 'required|string|min:1|max:200',
            'procu_rg' => 'nullable|string|min:0|max:10',
            'procu_orgao_expeditor' => 'nullable|string|min:0|max:10',
            'procu_cpf' => 'nullable|string|min:0|max:20',
            'procu_endereco' => 'nullable|string|min:0|max:200',
            'procu_bairro' => 'nullable|string|min:0|max:100',
            'procu_cidade' => 'nullable|string|min:0|max:100',
            'procu_estado' => 'nullable|string|min:0|max:2',
            'cliente_id' => 'nullable',
            //'created_by' => 'nullable',
            //'updated_by' => 'nullable',
            //'franquia_id' => 'nullable',
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
        $data = $this->only(['procu_nome', 'procu_rg', 'procu_orgao_expeditor', 'procu_cpf', 'procu_endereco', 'procu_bairro', 'procu_cidade', 'procu_estado']);

        return $data;
    }

}