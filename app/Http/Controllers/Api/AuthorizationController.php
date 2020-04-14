<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Api\AuthorizationRequest;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Request;

class AuthorizationController extends Controller
{
    protected function responseWithToken($token) {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
            'expired_in' => \Auth::guard('api')->factory()->getTTL() * 60
        ]);
    }

    public function store(AuthorizationRequest $request) {
        $credentials = [
            'phone' => $request->phone,
            'password' => $request->password,
        ];

        if (!$token = \Auth::guard('api')->attempt($credentials)) {
            throw new AuthenticationException('用户名或密码错误');
        }

        return $this->responseWithToken($token)->setStatusCode(201);
    }

    public function update() {
        $token = auth('api')->refresh();

        return $this->responseWithToken($token);
    }

    public function destroy() {
        auth('api')->logout();

        return response(null, 204);
    }
}
