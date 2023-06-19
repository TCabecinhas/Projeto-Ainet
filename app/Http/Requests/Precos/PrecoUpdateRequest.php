<?php

namespace App\Http\Requests\Precos;

use Illuminate\Foundation\Http\FormRequest;

class PrecoUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user()->tipo == 'A';
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'preco_un_catalogo' => 'required|numeric|min:0',
            'preco_un_proprio' => 'required|numeric|min:0',
            'preco_un_catalogo_desconto' => 'required|numeric|min:0',
            'preco_un_proprio_desconto' => 'required|numeric|min:0',
            'quantidade_desconto' => 'required|numeric|min:0'
        ];
    }
}
