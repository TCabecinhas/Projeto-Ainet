<?php

namespace App\Http\Requests\Tshirt_Images;

use Illuminate\Foundation\Http\FormRequest;

class TshirtImageUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return ($this->user()->user_type == 'A' && $this->tshirtImage->customer_id == NULL) || ($this->user()->id == $this->tshirtImage->customer_id);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'category_id' => 'nullable|exists:categories,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable',
            'file' => 'nullable|image|file'
        ];
    }
}
