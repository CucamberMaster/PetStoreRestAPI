<?php

// app/Http/Requests/PetRequest.php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PetRequest extends FormRequest
{
    public function rules()
    {
        return [
            'name' => 'required|string',
            'status' => 'required|in:available,pending,sold',
            'category_id' => 'integer',
            'category_name' => 'required|string',
            'photoUrls' => 'array',
            'tags' => 'array',
            'tags.*.id' => 'integer',
            'tags.*.name' => 'string',
        ];
    }
}
