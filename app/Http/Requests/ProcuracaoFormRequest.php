<?php

namespace Serbinario\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;


class ProcuracaoFormRequest extends FormRequest
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
                'cliente_id' => 'nullable',
            //'data_validade' => 'nullable|date_format:d/m/Y',
            'outorgante' => 'nullable|string|min:0|max:200',
            'rg' => 'nullable|string|min:0|max:20',
            'orgao_expeditor' => 'nullable|string|min:0|max:10',
            'cpf' => 'nullable|string|min:0|max:20',
            'endereco' => 'nullable|string|min:0|max:200',
            'bairro' => 'nullable|string|min:0|max:100',
            'cidade' => 'nullable|string|min:0|max:100',
            'estado' => 'nullable|string|min:0|max:2',

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
        $data = $this->only(['cliente_id', 'data_validade', 'outorgante', 'rg', 'orgao_expeditor', 'cpf', 'endereco', 'bairro', 'cidade', 'estado']);

        return $data;
    }

}