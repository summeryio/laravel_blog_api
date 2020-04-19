<?php

namespace App\Http\Requests\Api;

class UserRequest extends FormRequest
{
    public function rules()
    {
        switch ($this->method()) {
            case 'POST':
                return [
                    'name' => 'required | between:3, 25 | regex:/^[A-Za-z0-9\-\_]+$/ | unique:users,name',
                    'password' => 'required | alpha_dash | min:4 | confirmed',
                    'password_confirmation' => 'required',
                    'verification_key' => 'required',
                    'verification_code' => 'required | string',
                    'captcha_key' => 'required',
                    'captcha_code' => 'required | string',
                ];
            break;

            case 'PATCH':
                $userId = auth('api')->id();

                return [
                    'name' => 'required | between:3, 25 | regex:/^[A-Za-z0-9\-\_]+$/ | unique:users,name,'.$userId,
                    'introduction' => 'max:80',
                    'avatar_image_id' => 'exists:images,id,type,avatar,user_id,'.$userId
                ];
            break;
        }
    }

    public function attributes()
    {
        return [
            'verification_code' => '短信验证码',
            'captcha_code' => '图片验证码',
        ];
    }

    public function messages()
    {
        return [
            'name.unique' => '用户名已被占用，请重新填写',
            'name.regex' => '用户名只支持英文、数字、横杆和下划线。',
            'name.between' => '用户名必须介于 3 - 25 个字符之间。',
            'name.required' => '用户名不能为空。',
            'password.confirmed' => '两次密码输入不一致',
            'verification_key.required' => '未获取手机验证码',
        ];
    }

}
