<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Api\UserRequest;
use App\Http\Resources\UserResource;
use App\Models\Image;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function store(UserRequest $request) {
        $verifyData = \Cache::get($request->verification_key);
        $captchaData = \Cache::get($request->captcha_key);

        if (!$verifyData) {
            abort(422, '短信验证码已失效');
        }
        if (!$captchaData) {
            abort(422, '图片验证码已失效');
        }

        if (!hash_equals($verifyData['code'], $request->verification_code)) {
            abort(422, '短信验证码错误');
        }
        if (!hash_equals(strtolower($captchaData['code']), strtolower($request->captcha_code))) {
            // 验证错误就清除缓存
            \Cache::forget($request->captcha_key);

            abort(422, '图片验证码错误');
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

    public function update(UserRequest $request) {
        $user = $request->user();
        $attributes = $request->only(['name', 'introduction']);

        if ($request->avatar_image_id) {
            $image = Image::find($request->avatar_image_id);

            $attributes['avatar'] = $image->path;
        }

        $user->update($attributes);

        return new UserResource($user);
    }
}
