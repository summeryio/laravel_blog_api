<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::prefix('v1')
    ->namespace('Api')
    ->name('api.v1')
    ->group(function () {

        Route::middleware('throttle:' . config('api.rate_limits.sign'))->group(function () {
            // 短信验证码
            Route::post('verificationCodes', 'VerificationCodeController@store')->name('verificationCodes.store');
            // 用户注册
            Route::post('users', 'UserController@store')->name('users.store');

            // 图片验证码
            Route::get('captchas', 'CaptchaController@store')->name('captchas.store');

            // 登录
            Route::post('authorizations', 'AuthorizationController@store')
                ->name('api.authorizations.store');

            // 刷新token
            Route::put('authorizations/current', 'AuthorizationController@update')
                ->name('api.authorizations.update');
            // 删除token
            Route::delete('authorizations/current', 'AuthorizationController@destroy')
                ->name('api.authorizations.destroy');
        });


        Route::middleware('throttle:' . config('api.rate_limits.access'))->group(function () {
        });

});