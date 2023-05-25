<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DepartamentoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'abreviatura' => 'required|string|max:20',
            'nome' =>        'required',
        ];
    }


    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'abreviatura.required' => 'A abreviatura é obrigatória',
            'abreviatura.string' => 'A abreviatura tem que ser uma string',
            'abreviatura.max' => 'A abreviatura pode ter no máximo 20 caracteres',
            'nome.required' => 'A nome é obrigatório',
        ];
    }
}
