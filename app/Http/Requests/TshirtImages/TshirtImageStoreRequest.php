<?php

namespace App\Http\Requests\TshirtImages;

use Illuminate\Foundation\Http\FormRequest;

class TshirtImageStoreRequest extends FormRequest
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
            'category_id' => 'nullable|exists:categories,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable',
            'file' => 'required|image|file'
        ];
    }
}
