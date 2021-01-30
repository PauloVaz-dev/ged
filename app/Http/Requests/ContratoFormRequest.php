<?php

namespace Serbinario\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;


class ContratoFormRequest extends FormRequest
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
                'projeto_id' => 'required',
            'franquia_id' => 'nullable',
            'ano' => 'nullable|string|min:0|max:4',
            'created_by' => 'nullable',
            'updated_by' => 'nullable',
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
        $data = $this->only(['projeto_id', 'franquia_id', 'report_layout_id', 'ano', 'created_by', 'updated_by']);
        return $data;
    }

}