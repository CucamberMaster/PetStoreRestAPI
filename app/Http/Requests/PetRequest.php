<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PetRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'id' => 'numeric',
            'name' => 'required|max:255',
            'category.name' => 'required|max:255',
            'status' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'id.numeric' => 'The ID must be a numeric value.',
            'name.required' => 'The name field is required.',
            'name.max' => 'The name must not exceed 255 characters.',
            'category.name.required' => 'The category name field is required.',
            'category.name.max' => 'The category name must not exceed 255 characters.',
            'status.required' => 'The status field is required.',
        ];
    }
}
