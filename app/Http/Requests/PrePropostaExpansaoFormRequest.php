<?php

namespace Serbinario\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;


class PrePropostaExpansaoFormRequest extends FormRequest
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
        return  [
            'cliente_id' => 'required',
            'modulo_id' => 'required',
            'cidade_id' => 'required',
            'estado_id' => 'required',
            'potencia_modulo'  => 'required',
            'expansao_qtd_paineis'  => 'required',
            'expansao_inversor_id'  => 'required',

        ];
    }
}
