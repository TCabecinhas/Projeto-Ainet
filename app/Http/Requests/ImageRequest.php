<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ImageRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'customer_id' => 'nullable|exists:customers,id',
            'category_id' => 'nullable|exists:categories,id',
            'name' => 'required',
            'description' => 'nullable',
            'image_url' => 'required',
            'extra_info' => 'nullable',
        ];
    }
}
