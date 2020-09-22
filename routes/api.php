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

/**
 * 365 平台自动存款
 */

// 第三方接口
Route::any('/Payment','Api\PayController@Payment');

// 第三方回调
Route::any('/usdPay/return_url','Api\PayController@return_url');

// 模拟用户存款测试 
Route::get('/CheckUname','Api\RobotController@CheckUname');

// 模拟辉煌存款接口
Route::get('/DoScore','Api\RobotController@DoScore');

// 模拟平台登录
Route::get('/GetToken','Api\RobotController@GetToken');