<?php

namespace Serbinario\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;


class DigitalizacaoFormRequest extends FormRequest
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
        if(isset($this->id)){
            $rules = [
                'descricao'      => 'required|min:3|max:255|string',


            ];
        }else{
            $rules = [
                'descricao'      => 'required|min:3|max:255|string',
                'arquivo' =>'required|mimes:pdf'
            ];
        }


        return $rules;
    }

    public function messages(){
        return [
            'required' => 'O campo :attribute é obrigatório.',
            'numeric' => 'O campo :attribute deve ser preenchido com valores numéricos.',
            'min:5' => 'O campo :attribute requer um mínimo de 5 caracteres.',
            'max:500' => 'O campo :attribute não pode exceder 500 caracteres.'
        ];
    }
    


}