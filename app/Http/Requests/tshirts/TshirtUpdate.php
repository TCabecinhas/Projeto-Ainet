<?php

namespace App\Http\Requests\Tshirts;

use Illuminate\Foundation\Http\FormRequest;

class TshirtUpdate extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'cor_codigo' => 'required|exists:cores,codigo',
            'tamanho' => 'required|in:XS,S,M,L,XL',
            'quantidade' => 'required|integer|min:1',
            'file' => 'image'
        ];
    }

    public function messages()
    {
        return [
          'cor_codigo.required' => 'Tem de inserir a cor da t-shirt.',
          'cor_codigo.exists' => 'A cor inserida não é válida.',
          'tamanho.required' => 'Tem de inserir o tamanho da t-shirt.',
          'tamanho.in' => 'O tamanho inserido não é válido.',
          'quantidade.required' => 'Tem de inserir a quantidade de t-shirts.',
          'quantidade.integer' => 'A quantidade inserida não é válida.',
          'quantidade.min' => 'Tem de inserir, pelo menos, uma t-shirt.',
          'file.image' => 'O ficheiro enviado não é uma imagem.',
        ];
    }
}