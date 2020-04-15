<?php

namespace App\Http\Requests\Api;

class CategoryRequest extends FormRequest
{
    public function rules()
    {
        return [
            'name' => 'required | string | between:2,5 | unique:categories,name',
            'description' => 'required | string | max:20',
        ];
    }
}
