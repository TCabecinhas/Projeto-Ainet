<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\App;

class CursoRequest extends FormRequest
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
            'tipo' =>        'required|in:"Licenciatura","Mestrado","Curso Técnico Superior Profissional"',
            'semestres' =>   'required|integer|between:1,6',
            'ECTS' =>        'required|integer|min:1',
            'vagas' =>       'required|integer|between:0,500',
            'contato' =>     'required|email',
            'objetivos' =>   'required'
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
            'nome.required' => 'O nome é obrigatório',
            'tipo.required' => 'O tipo de curso é obrigatório',
            'tipo.in' => 'O tipo de curso tem que ser "Licenciatura", "Mestrado" ou "Curso Técnico Superior Profissional"',
            'semestres.required' => 'Semestres é obrigatório',
            'semestres.integer' => 'Semestres deve ser um nº inteiro',
            'semestres.between' => 'Semestres tem que ser entre 1 e 6',
            'ECTS.required' => 'O nº de ECTS é obrigatório',
            'ECTS.integer' => 'O nº de ECTS deve ser um nº inteiro',
            'ECTS.min' => 'O nº de ECTS tem que ser maior ou igual que 1',
            'vagas.required' => 'O nº de vagas é obrigatório',
            'vagas.integer' => 'O nº de vagas deve ser um nº inteiro',
            'vagas.between' => 'O nº de vagas tem que ser entre 0 e 500',
            'contato.required' => 'O contato é obrigatório',
            'contato.email' => 'O contato deve ser um email',
            'objetivos.required' => 'Os objetivos são obrigatórios'
        ];
    }
}
