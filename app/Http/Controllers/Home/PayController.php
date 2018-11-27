<?php

namespace App\Http\Controllers\Home;

use DB;
use App\Order;
use QL\QueryList;
use Yansongda\Pay\Pay;
use Yansongda\Pay\Log;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\PayAlipayRequest;

class PayController extends Controller
{
	//发起支付请求
	public function Alipay(PayAlipayRequest $request)
	{
		
		$order = [
			'out_trade_no'=>date('ymdhis',time()).time(),
			'total_amount'=>$request->get('money'),
			'subject'=>$request->get('username'),
		];
		//保存订单信息	1 为下单
		DB::table('order')->insert([
			'order_no'=>$order['out_trade_no'],
			'amount'=>$order['total_amount'],
			'username'=>$order['subject'],
			'addtime'=>date('Y-m-d H:i:s'),
			'pay_type'=>'1'
		]);

		$alipay = Pay::alipay(config('pay.alipay'))->wap($order);

		return $alipay->send();	
	}
	//回调函数
	public function return_url(Request $request)
	{
		$data = Pay::alipay(config('pay.alipay'))->verify(); // 是的，验签就这么简单！

		$order = Order::where('order_no',$data['out_trade_no'])->first();
		$order->trade_no = $data['trade_no'];
		$order->trade_time = $data['timestamp'];
		$order->pay_type = '2';
		$order->trade_amount = $data['total_amount'];
		$order->save();

		//监听事件
		//event(new \App\Events\OrderUpdated($order));
        // 订单号：$data->out_trade_no
        // 支付宝交易号：$data->trade_no
        // 订单总金额：$data->total_amount
        return redirect('/alipay');
	}
	//回调函数
	public function notify_url()
	{
		$alipay = Pay::alipay(config('pay.alipay'));
    
        try{
            $data = $alipay->verify(); // 是的，验签就这么简单！
            //dd($_GET);
            // 请自行对 trade_status 进行判断及其它逻辑进行判断，在支付宝的业务通知中，只有交易通知状态为 TRADE_SUCCESS 或 TRADE_FINISHED 时，支付宝才会认定为买家付款成功。
            // 1、商户需要验证该通知数据中的out_trade_no是否为商户系统中创建的订单号；
            // 2、判断total_amount是否确实为该订单的实际金额（即商户订单创建时的金额）；
            // 3、校验通知中的seller_id（或者seller_email) 是否为out_trade_no这笔单据的对应的操作方（有的时候，一个商户可能有多个seller_id/seller_email）；
            // 4、验证app_id是否为该商户本身。
            // 5、其它业务逻辑情况

            Log::debug('Alipay notify', $data->all());
        } catch (Exception $e) {
            // $e->getMessage();
        }

        return $alipay->success()->send();// laravel 框架中请直接 `return $alipay->success()`
	}

    //显示支付宝支付
	public function index()
	{
		return view('home.pay.index');
	}

	
	
}
