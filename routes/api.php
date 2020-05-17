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


// 前端接口
Route::prefix('blog')
    ->namespace('Api')
    ->name('api.blog')
    ->group(function () {
        Route::middleware('throttle:' . config('api.rate_limits.access'))->group(function () {
            Route::get('topics', 'BlogController@topicList')->name('blog.topics.list');
            Route::get('topics/{topicId}', 'BlogController@topicDetail')->name('blog.topics.detail');
            Route::get('categories', 'BlogController@getCategory')->name('blog.categories');
        });
    });

// 后台管理接口
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
            Route::middleware('auth:api')->group(function () {
                // 获取用户数据
                Route::get('user', 'UserController@me')
                    ->name('user.show');
                // 上传图片
                Route::post('images', 'ImageController@store')->name('images.store');
                // 编辑登录用户信息
                Route::patch('user', 'UserController@update')->name('user.update');

                // 文章分类
                Route::resource('categories', 'CategoryController')->only(['index', 'store', 'update', 'destroy']);

                // 话题数据
                Route::resource('topics', 'TopicController')->only(['index', 'store', 'update', 'destroy']);
                Route::post('topics/batchDelete', 'TopicController@batchDelete')->name('topics.batchDelete');
            });
        });

});
