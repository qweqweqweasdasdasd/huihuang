<?php

namespace App\Http\Lib;

use QL\QueryList;
use GuzzleHttp\Client;
use GuzzleHttp\Cookie\CookieJar;
use Illuminate\Support\Facades\Redis;


class SsfPlatform
{
	/**
	 * 平台后台地址
	 */
	private $uri = 'https://btnaa0tabe.cgadmin888.com';

	/**
	 * 平台管理员用户
	 */
	private $username = 'test001';

	/**
	 * 平台管理员密码
	 */
	private $password = 'qq123123';

	/**
	 * 平台名称
	 */
	private $pf_name = 'SsfPlatform_';


	/**
	 * 1.5 更新一次 登錄令牌 查詢令牌 存款令牌
	 */
	public function GetToken()
	{
		$ql = QueryList::getInstance();
		$ql->post($this->uri . '/home/new_Login',[
				'UserName' => $this->username,
				'UserPass' => $this->password
			],[
				'timeout'=>30,
			]
		);

		// 检查是否登录
		if($ql->find('title')->text() != '管理后台'){
			$this->GetToken();	//死循环
			\Log::info("平台:{$this->pf_name}执行模拟登录获取token失败,时间:".date('Y-m-d H:i:s',time()));
		};

		$ql->get($this->uri.'/Cash/SavingsAndOut',[],[
    		'timeout'=>30
    		]
    	);

		$__RequestVerificationToken0 = $ql->find('input[name="__RequestVerificationToken"]:eq(0)')->attr('value');

    	$__RequestVerificationToken1 = $ql->find('input[name="__RequestVerificationToken"]:eq(1)')->attr('value');

    	$token = '';
    	$jar = \QL\Services\HttpService::getCookieJar();	//获取到cookies
		foreach ($jar->toArray() as $key => $value) {
			$token .= $jar->toArray()[$key]['Name'].'='.$jar->toArray()[$key]['Value'] .';';
		}

		// 保存令牌对象
		Redis::set($this->pf_name.'_cookie',$token);

    	// 保存令牌对象
		Redis::set($this->pf_name.'__RequestVerificationToken0',$__RequestVerificationToken0);
		Redis::set($this->pf_name.'__RequestVerificationToken1',$__RequestVerificationToken1);

		\Log::info("平台:{$this->pf_name}执行模拟登录获取token成功,时间:".date('Y-m-d H:i:s',time()));
	}

	/**
	 * 查会员信息
	 */
	public function CheckUname($username='')
	{
		//$username = 'qwe14725';

		$token = Redis::get($this->pf_name.'_cookie');
		$__RequestVerificationToken0 = Redis::get($this->pf_name.'__RequestVerificationToken0');

		$client = new Client();
		// 查询会员是否有效
    	$res = $client->post($this->uri.'/Cash/SavingsAndOut', [
	    		'timeout'=>30,
	    		'verify' => false,
	    		'headers'=>[
			        'Cookie' => $token
	    		],
	    		'form_params' => [
	    			'btnSearch'=>'查询',
					'UserName'=> $username,
					'__RequestVerificationToken' => $__RequestVerificationToken0
	    		]
		]);

    	$html = (string)$res->getBody();
			
		// 检查是否登录
		if(QueryList::html($html)->find('title')->text() != '管理后台'){
			$this->GetToken();	//死循环
			\Log::info("平台:{$this->pf_name}执行模拟登录获取token失败,时间:".date('Y-m-d H:i:s',time()));
		};
		$UserName = QueryList::html($html)->find('#UserName')->attr('value');		// 會員賬號
		$RealName = QueryList::html($html)->find('#RealName')->attr('value');
		$Balance = QueryList::html($html)->find('#Balance')->attr('value');
		$ActionMoney = QueryList::html($html)->find('#ActionMoney')->attr('value');  // 存款金額
		$SpMoney = QueryList::html($html)->find('#SpMoney')->attr('value');
		$AbsorbMoney = QueryList::html($html)->find('#AbsorbMoney')->attr('value');
		$SumTargetNum = QueryList::html($html)->find('#SumTargetNum')->attr('value');
		$CommonAudit = QueryList::html($html)->find('#CommonAudit')->attr('value');
		$Remark = QueryList::html($html)->find('#Remark')->attr('value');

    	$data = [
    		'UserName'=>$UserName,				// 賬號
			'RealName'=>$RealName,
			'Balance'=>$Balance,
			'ActionMoney'=>$ActionMoney,		// 存款金额 
			'SpMoney'=>$SpMoney,
			'AbsorbMoney'=>$AbsorbMoney,
			'SumTargetNum'=>$SumTargetNum,
			'CommonAudit'=>$CommonAudit,
			'Remark'=>$Remark					// 備註
    	];

    	if(empty($data['RealName'])){		// 不存在
    		return false;
    	}

		return $data;
	}

	

	/**
	 * 上分操作
	 */
	public function DoScore($data=[])
	{
		$token = Redis::get($this->pf_name.'_cookie');
		$__RequestVerificationToken0 = Redis::get($this->pf_name.'__RequestVerificationToken0');

		$client = new Client();
    	$res = $client->post($this->uri.'/Cash/ConfirmManualDepositSingle',[
    		'verify' => false,
    		'timeout'=>30,
    		'headers'=>[
		        'Cookie' =>$token
    		],
    		'form_params' => [
    			'__RequestVerificationToken' => $__RequestVerificationToken0,

    			'UserName'=>$data['UserName'],				// 賬號
				'RealName'=>$data['RealName'],
				'Balance'=>$data['Balance'],
				'ActionMoney'=>$data['ActionMoney'],		// 存款金额 
				'SpMoney'=>$data['SpMoney'],
				'AbsorbMoney'=>$data['AbsorbMoney'],
				'SumTargetNum'=>$data['SumTargetNum'],
				'CommonAudit'=>$data['CommonAudit'],
				'Remark'=>$data['Remark'],					// 備註
				'operationType'=>'1',
				'ActionType'=>'17',			// 支付列席
				'IsBrokerage'=>'False',
				'X-Requested-With'=>'XMLHttpRequest'
    		]
    	]);
    	$content = $res->getBody()->getContents(); 
    	// 检查是否登录
		if(QueryList::html($html)->find('title')->text() != '管理后台'){
			$this->GetToken();	//死循环
			\Log::info("平台:{$this->pf_name}执行模拟登录获取token失败,时间:".date('Y-m-d H:i:s',time()));
		};
		
    	return true;
	}
}
