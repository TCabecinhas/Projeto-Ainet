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
            'unit_price_catalog' => 'required|numeric|min:0',
            'unit_price_own' => 'required|numeric|min:0',
            'unit_price_catalog_discount' => 'required|numeric|min:0',
            'unit_price_own_discount' => 'required|numeric|min:0',
            'qty_discount' => 'required|numeric|min:0'
        ];
    }
}
