<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('/alipay','Home\PayController@index');
Route::post('/alipay','Home\PayController@Alipay');

//微信个人账号存款
Route::get('/wechat','Home\PayController@show');
//发起微信支付请求
Route::post('/wechat','Home\PayController@wechat');
//回调函数
Route::post('/notify_url','Home\PayController@notify_url');
Route::get('/return_url','Home\PayController@return_url');

//对外提供的接口
Route::get('/admin/main','Server\AdminStateController@main');

//模拟用户存款测试 
//Route::get('/admin/getInfoWithUsername','Server\AdminStateController@getInfoWithUsername');
//模拟辉煌存款接口
//Route::get('/admin/huihuangcunkuan','Server\AdminStateController@huihuangcunkuan');
//模拟登陆测试
//Route::get('/admin/getCookieByLogin','Server\AdminStateController@getCookieByLogin');


Route::get('/login','Admin\LoginController@login');
Route::post('/login/check','Admin\LoginController@check');

//生成随机字符串
Route::get('/random','Server\StrController@random');

Route::group(['middleware'=>'islogin'],function(){

	//管理后台--退出登录
	Route::get('/logout','Admin\LoginController@logout');
	//管理后台--主页
	Route::get('/index/index','Admin\IndexController@index');
	//管理后台--welcome
	Route::get('/welcome','Admin\IndexController@welcome');

	Route::group(['middleware'=>'Fanqiang'],function(){
		//权限管理--资源路由
		Route::resource('/permission','Admin\PermissionController');
		
		//权限分配-- get && post
		Route::match(['get','post'],'/distribute/{role?}','Admin\RoleController@distribute');
		//角色管理--资源路由
		Route::resource('/role','Admin\RoleController');
		//角色管理--勾选删除
		Route::post('/roleAll','Admin\RoleController@roleAll');

		//管理员管理--资源路由
		Route::resource('/manager','Admin\ManagerController');
		//管理员状态
		Route::post('/status','Admin\ManagerController@status');

		//订单信息
		Route::get('/order/list','Admin\OrderController@list');
		//手动补单修改状态
		Route::post('/order/budan','Admin\OrderController@budan');
	});
	
	//管理本人密码显示
	Route::get('/reset','Admin\ManagerController@reset');
	//管理本人密码动作
	Route::post('/doreset','Admin\ManagerController@doreset');
});

