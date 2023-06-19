<?php

namespace App\Http\Requests\Users;

use Illuminate\Foundation\Http\FormRequest;

class ProfileUpdateRequest extends FormRequest
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
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'password' => 'nullable|confirmed|max:255',
            'avatar' => 'nullable|file|image',
            'nif' => 'nullable|numeric|digits:9',
            'endereco' => 'nullable|string|max:255',
            'tipo_pagamento' => 'nullable|string|in:VISA,MC,PAYPAL',
        ];
    }

    public function messages(){
        return [
            'name.required' => 'Tem de preencher o seu nome.',
            'name.max' => 'O nome não pode exceder os 255 caracteres.',
            'email.required' => 'Tem de preencher o seu email.',
            'password.confirmed' => 'As senhas não coincidem.',
            'password.max' => 'A senha não pode exceder os 255 caracteres.',
            'file-avatar.file' => 'Não foi possível fazer upload da foto de perfil.',
            'file-avatar.image' => 'O ficheiro inserido não corresponde a uma imagem.',
            'nif.number' => 'O NIF deve ser um valor numérico.',
            'nif.digits' => 'O NIF tem de ter 9 dígitos.',
            'endereco.max' => 'A morada não pode exceder os 255 caracteres.'
        ];
    }
}
