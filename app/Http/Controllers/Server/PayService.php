<?php

namespace App\Http\Controllers\Server;

use App\Http\Lib\SsfPlatform;
use Illuminate\Support\Facades\Redis;
use App\Http\Lib\Payment;

class PayService
{
	public function CheckUname($uname='')
	{
		$uname = Redis::get($uname);	// 存过款
		if($uname){
			return true;
		}

		// 第一次存款
		$ssfp = new SsfPlatform();
		$ret = $ssfp->CheckUname($uname);
		
		if(!$ret){
			throw new \Exception("{$uname}不存在！");
		}

		Redis::set($uname,'laohuihuang-1');

		return $ret;
	}

	public function getUsdtKey($uname='')
	{
		// 生成订单
		$orderNo = md5(time());
		$data = [
			'order_no' => '',
			'username' => $uname,
			'trade_amount' => 0,
			'pay_type' => 1,
			'trade_no' => $orderNo,
			'trade_time' => date('Y-m-d H:i:s',time()),
			'tips' => '',

		];

		$insertId = \DB::table('order')->insertGetId($data);
		$pay = new Payment();

		// 账号-平台-订单id
		$string = $uname.'-'.'laohuihuang'.'-'.$insertId;
		$res = $pay->Req($string);
		if($res->status == 'success' && $res->code == 20000){

			Redis::set($uname.'-usdt',json_encode($res->data));
			Redis::expire($uname.'-usdt',600);	//10分钟

			return true;
		}

		return false;
	}
}
