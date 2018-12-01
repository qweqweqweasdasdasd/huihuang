<?php

namespace App\Http\Controllers\Home;

use DB;
use App\Pic;
use App\Order;
use App\Budan;
use QL\QueryList;
use Yansongda\Pay\Pay;
use Yansongda\Pay\Log;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\TjBudanRequest;
use App\Http\Requests\PayAlipayRequest;
use App\Http\Controllers\Server\AdminStateController;

class PayController extends Controller
{
	//显示微信二维码静态页面
	public function show()
	{
		$pic = Pic::find(1);
		return view('home.pay.show',compact('pic'));
	}

	//显示微信补单的页面
	public function index()
	{	
		return view('home.pay.index');
	}

	//微信补单提交
	public function budan(TjBudanRequest $request)
	{
		//查询订单号是否存在
		if( !($order = Order::where('trade_no',$request->get('trade_no'))->first()) ){
			return ['code'=>config('code.error'),'error'=>'查询没有该订单!'];
		};
		//核实该单号状态是否为 辉煌入款成功 false return error 	3 辉煌存款成功 6 补单成功
		if($order->pay_type == 3 || $order->pay_type == 6){
			return ['code'=>config('code.error'),'error'=>'该订单已经到账成功了呢!'];
		}
		//该单号存款是否为提交的金额 false return error
		if($order->trade_amount != $request->get('money')){
			return ['code'=>config('code.error'),'error'=>'输入金额与实际存款金额不符!'];
		}
		
		//执行后台操作 如果失败的话 ,,失败的原因	//用户  //金额  //订单号
		//实例化后台操作调用补单函数
		$budan = new AdminStateController();
		$res = $budan->huihuangbudan($request->get('input_username'),$request->get('money'),$request->get('trade_no'));
		//返回结果
		if($res['code'] == 0){
			return ['code'=>config('code.error'),'error'=>$res['msg']];
		};
		if($res['code'] == 1){
			app('log')->info("补单ok:".date('Y-m-d H:i:s',time()));
			//生成补单的记录
			Budan::create($request->all());
			return ['code'=>config('code.error'),'error'=>$res['msg']];
		};
	}


}
