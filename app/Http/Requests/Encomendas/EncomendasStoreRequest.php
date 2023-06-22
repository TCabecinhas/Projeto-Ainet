<?php

namespace App\Http\Requests\Encomendas;

use Illuminate\Foundation\Http\FormRequest;

class EncomendasStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user()->user_type == "C";
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'notas' => 'nullable',
            'nif' => 'required|numeric|digits:9',
            'endereco' => 'required|string|max:255',
            'tipo_pagamento' => 'required|string|in:VISA,MC,PAYPAL',
        ];
    }
}
