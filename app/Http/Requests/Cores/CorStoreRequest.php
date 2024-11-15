<?php

namespace App\Http\Requests\Cores;

use Illuminate\Foundation\Http\FormRequest;

class CorStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user()->user_type == 'A';
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'codigo' => 'required|max:50',
            'nome' => 'required|string|max:255'
        ];
    }
}
