<?php

namespace App\Http\Requests\Api;

class UserRequest extends FormRequest
{
    public function rules()
    {
        return [
            'name' => 'required | between:3, 25 | regex:/^[A-Za-z0-9\-\_]+$/ | unique:users,name',
            'password' => 'required | alpha_dash | min:4',
            'verification_key' => 'required | string',
            'verification_code' => 'required | string',
            'captcha_key' => 'required | string',
            'captcha_code' => 'required | string',
        ];
    }
    public function attributes()
    {
        return [
            'verification_key' => '短信验证码 key',
            'verification_code' => '短信验证码',
            'captcha_key' => '图片验证码 key',
            'captcha_code' => '图片验证码',
        ];
    }

}