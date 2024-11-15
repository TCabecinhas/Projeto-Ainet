<?php

namespace App\Http\Requests\Tshirts;

use Illuminate\Foundation\Http\FormRequest;

class TshirtSave extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'cor_codigo' => 'required|exists:colors,code',
            'tamanho' => 'required|in:XS,S,M,L,XL',
            'quantidade' => 'required|integer|min:1',
            'nome' => 'required|max:255',
            'descricao' => 'nullable',
            'file' => 'required|image|file',
            'preco' => 'required|numeric|min:0.00'
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
          'nome.required' => 'Tem de inserir o nome da imagem.',
          'nome.max' => 'O nome da imagem não pode ultrapassar os 255 caracteres.',
          'file.required' => 'Tem de inserir o ficheiro da imagem.',
          'file.image' => 'O ficheiro enviado não é uma imagem.',
          'file.file' => 'Não foi possível fazer upload do ficheiro.'
        ];
    }
}
