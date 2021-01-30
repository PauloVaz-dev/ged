<?php

namespace Serbinario\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;


class ProdutoFormRequest extends FormRequest
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
            //'projeto_status_id' => 'required',
            //'users_id' => 'required',
            'grupo_id' => 'required',
        ];
    }

    /**
     * Get the request's data from the request.
     *
     * @param Illuminate\Http\Request\Request $request
     * @return array
     */
    function getData()
    {
        $data = $this->only(['produto', 'preco_franquia', 'preco_revenda', 'marca_id', 'estoque', 'grupo_id', 'unidade_id']);

        return $data;
    }


}
