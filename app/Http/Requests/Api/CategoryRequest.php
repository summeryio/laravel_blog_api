<?php

namespace App\Http\Requests\Api;

class CategoryRequest extends FormRequest
{
    public function rules()
    {
        switch ($this->method()) {
            case 'POST':
                return [
                    'name' => 'required | string | between:2,5 | unique:categories,name',
                    'description' => 'required | string | max:20',
                ];
            break;
            case 'PATCH':
                return [
                    'name' => 'required | string | between:2,5',
                    'description' => 'required | string | max:20',
                ];
            break;
        }

    }
}
