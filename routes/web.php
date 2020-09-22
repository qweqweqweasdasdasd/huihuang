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
//Route::get('/alipay','Home\PayController@index');
//Route::post('/alipay','Home\PayController@Alipay');

//显示微信二维码
Route::get('/wechat','Home\PayController@show');
//显示微信补单页面
Route::get('/budan','Home\PayController@index');
Route::post('/budan','Home\PayController@budan');

// h5提交页面
Route::get('paysubmit','Home\PayController@paysubmit')->name('paysubmit');

// 显示以太坊地址
Route::get('/showQr/{name?}','Home\PayController@showQr');

// 检测用户和获取地址
Route::post('getUsdtKey','Home\PayController@getUsdtKey');

//回调函数
//Route::post('/notify_url','Home\PayController@notify_url');
//Route::get('/return_url','Home\PayController@return_url');

//对外提供的接口
Route::post('/admin/main','Server\AdminStateController@main');

//模拟用户存款测试 
//Route::get('/admin/getInfoWithUsername','Server\AdminStateController@getInfoWithUsername');
//模拟辉煌存款接口
//Route::get('/admin/huihuangcunkuan','Server\AdminStateController@huihuangcunkuan');
//模拟登陆测试
//Route::get('/admin/getCookieByLogin','Server\AdminStateController@getCookieByLogin');

//常规的登录
Route::get('/login','Admin\LoginController@login');
Route::post('/login/check','Admin\LoginController@check');

//使用手机号码进行登录
Route::get('/tellogin','Admin\LoginController@tellogin');
Route::post('/checkadmin','Admin\LoginController@checkadmin');
Route::get('/','Admin\LoginController@redirect');

//sendSMS
Route::post('/sendSMS','Admin\LoginController@sendSMS');
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

		//二维码配置显示
		Route::get('/qrcode/index','Admin\QRcodeController@index');
		//二维码上传
		Route::post('/qrcode/images','Admin\QRcodeController@images');

		//补单列表显示
		Route::get('/budan/list','Admin\BudanController@list');
	});
	
	//管理本人密码显示
	Route::get('/reset','Admin\ManagerController@reset');
	//管理本人密码动作
	Route::post('/doreset','Admin\ManagerController@doreset');
});

