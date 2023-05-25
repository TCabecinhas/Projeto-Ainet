<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CandidaturaRequest extends FormRequest
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
            'curso' =>       'required|exists:cursos,abreviatura',
            'nome' =>        'required',
            'email' =>       'required|email',
            'telefone1' =>   'nullable',
            'telefone2' =>   'nullable',
            'genero' =>      'required|in:M,F',
            'media' =>       'required|numeric|between:9.5,20',
            'm23' =>         'required|boolean',
            'origem' =>      'required|in:P,UE,O',
            'obs' =>         'nullable',
            'estatutos' =>   'required|array',
            'estatutos.TE' =>   'required|boolean',
            'estatutos.NE' =>   'required|boolean',
            'estatutos.E' =>    'required|boolean',
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
            'curso.required' => 'O curso é obrigatório',
            'curso.exists' => 'O curso não existe na base de dados',
            'nome.required' => 'O nome é obrigatório',
            'genero.required' => 'O gênero é obrigatório',
            'genero.in' => 'O gênero tem que ser M ("Masculino") ou F ("Feminino")',
            'media.required' => 'A média é obrigatória',
            'media.numeric' => 'A média tem que ser um número válido',
            'media.between' => 'A média tem que ser entre 9.5 e 20.0',
            'm23.required' => '"Maior de 23" é obrigatório',
            'm23.boolean' => 'O valor de "Maior de 23" tem que ser um booleano',
            'media.numeric' => 'A média tem que ser um número válido',
            'origem.required' => 'A origem é obrigatória',
            'origem.in' => 'A origem tem que ser P ("Portugal"), UE ("União Europeia") ou O ("Outros")',
            'estatutos.required' => 'O campo "estatutos" é obrigatório',
            'estatutos.array' => 'O campo "estatutos" tem que ser um array com 3 elementos (TE, NE e E)',
            'estatutos.TE.required' => 'O estatuto TE ("Trabalhador Estudante") é obrigatório',
            'estatutos.TE.boolean' => 'O estatuto TE ("Trabalhador Estudante") tem que ser um boolean (se pretende o estatuto ou não)',
            'estatutos.NE.required' => 'O estatuto NE ("Necessidades Especiais") é obrigatório',
            'estatutos.NE.boolean' => 'O estatuto NE ("Necessidades Especiais") tem que ser um boolean (se pretende o estatuto ou não)',
            'estatutos.E.required' => 'O estatuto E ("Erasmus") é obrigatório',
            'estatutos.E.boolean' => 'O estatuto E ("Erasmus") tem que ser um boolean (se pretende o estatuto ou não)',
        ];
    }
}
