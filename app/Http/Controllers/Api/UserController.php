<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Api\UserRequest;
use App\Http\Resources\UserResource;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function store(UserRequest $request) {
        $verifyData = \Cache::get($request->verification_key);
        $captchaData = \Cache::get($request->captcha_key);

        if (!$verifyData) {
            abort(403, '短信验证码已失效');
        }
        if (!$captchaData) {
            abort(403, '图片验证码已失效');
        }

        if (!hash_equals($verifyData['code'], $request->verification_code)) {
            // 返回401
            throw new AuthenticationException('短信验证码错误');
        }
        if (!hash_equals(strtolower($captchaData['code']), strtolower($request->captcha_code))) {
            // 验证错误就清除缓存
            \Cache::forget($request->captcha_key);

            // 返回401
            throw new AuthenticationException('图片验证码错误');
        }

        $user = User::create([
            'name' => $request->name,
            'phone' => $verifyData['phone'],
            'password' => bcrypt($request->password)
        ]);

        return new UserResource($user);
    }

    public function me(Request $request) {
        return new UserResource($request->user());
    }
}
