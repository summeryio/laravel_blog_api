<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Gregwar\Captcha\CaptchaBuilder;
use App\Http\Requests\Api\CaptchaRequest;

class CaptchaController extends Controller
{
    public function store(CaptchaRequest $request, CaptchaBuilder $builder) {
        $key = 'captcha_' . Str::random(15);
        $captcha = $builder->build();
        $expiredAt = now()->addMinutes(5);

        \Cache::put($key, ['code' => $captcha->getPhrase()], $expiredAt);

        $result = [
            'captcha_key' => $key,
            'expired_at' => $expiredAt->toDateTimeString(),
            'captcha_image' => $captcha->inline()
        ];

        return response()->json($result)->setStatusCode(201);
    }
}
