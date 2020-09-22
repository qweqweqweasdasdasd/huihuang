<?php

namespace App\Http\Lib;

use QL\QueryList;
use GuzzleHttp\Client;
use GuzzleHttp\Cookie\CookieJar;
use Illuminate\Support\Facades\Redis;


class Payment
{
	/**
	 * 第三方接口地址
	 */
	private $url = 'http://coinaum.com';

	/**
	 * `appId
	 */
	private $AppId = '8a7b1bc27f5a49e9b59fea21753bfaae';

	/**
	 * 私钥
	 */
	private $AppSecret = '3841af8b75e9a94a4513d4828cbca943';



	public function Req($uname='')
	{
		$client = new Client();
		$timestamp = '1600692695';

		$body = json_encode(['OutCustomerId' => $uname]);

		$sign = $this->signature($timestamp,$body);

		$response = $client->post($this->url.'/api/transaction/customer',[
			'json' => [
				"appId"=> $this->AppId,
				"body"=> $body,
				"timestamp"=> $timestamp,
				"signature"=> $sign
			]
		]);

		$ret = json_decode($response->getBody()->getContents());

		return $ret;
	}

	public function RetUrl($data=[])
	{
		// 判断唯一id

		// 算法核对

		// 解析数据

		// 解析 OutCustomerId ，，什么平台，，会员账号，，订单id,,支付成功,,记录钱包数据

		// 自动存款

		// 记录日志
		
	}

	public function signature($timestamp='',$body='')
	{
		return md5($this->AppId.$this->AppSecret.$timestamp.$body);
	}
}
