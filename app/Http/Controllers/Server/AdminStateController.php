<?php

namespace App\Http\Controllers\Server;

//use Imagick;	//laravel 需要 use 一下 安装使用
use DB;
use Log;
use App\Order;
use QL\QueryList;
use GIFEndec\Decoder;	
use GuzzleHttp\Client;
use App\Common\AESMcrypt;
use GIFEndec\IO\FileStream;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
use GIFEndec\Events\FrameDecodedEvent;
use GuzzleHttp\Cookie\CookieJarInterface;
use thiagoalessio\TesseractOCR\TesseractOCR;	//ocr


class AdminStateController extends Controller
{

    //主要存款业务
    public function main(Request $request)	//$username="test123",$trade_amount='1'
    {

    	app('log')->info("存款进来了:".date('Y-m-d H:i:s',time()));
    	$data = urldecode(file_get_contents("php://input"));  // 取出POST的原始请求数据
		//app('log')->info('data'.$data);
		$aes = new AESMcrypt($bit = 128, $key = 'hdfkmhgnbd45812s', $iv = '7451236985412563', $mode = 'cbc');
		$data = $aes->decrypt($data);
		//原始数据
		app('log')->info("原始数据:".$data);
		$json = json_decode($data,true);
		//写到日志
		$trade_amount = $json['money'];
		$username = trim($json['remarks']);
		$number = $json['number'];
		app('log')->info('金额:'.$trade_amount);

		//app('log')->info("金额:".$trade_amount."会员".$username."订单号".$number);
        //判断用户使用的存款方式
        if(($number) == 'NO'){
            $order_info['is_private'] = 'Y';    //是否为私人微信存款
        }

		//记录订单信息
		$order_info = [
			'username'=>$username,
			'trade_amount'=>$trade_amount,
			'pay_type'=>2,
			'trade_no'=>$number,
			'trade_time'=>date('Y-m-d H:i:s',time()),
		];
		Order::create($order_info);		//支付成功
    	//主体逻辑
    	$result = $this->getInfoWithUsername($username,$trade_amount,$number);	//获取用户信息
    	if($result['code'] == 0){
    		//返回接口错误代码
    		return ['code'=>config('code.error'),'msg'=>$result['msg']];
    	}

    	$json = $result['data'];
    	$res = $this->huihuangcunkuan($json,$username,$trade_amount,$number);
    	if($res['code'] == 0){
    		//返回接口错误代码
    		return ['code'=>config('code.error'),'msg'=>$res['msg']];
    	}
    	return ['code'=>config('code.success'),'error'=>'恭喜你存款成功了哦'];
    }

    //补单业务
    public function huihuangbudan($username,$trade_amount,$trade_no)
    {
    	app('log')->info("补单进来了:".date('Y-m-d H:i:s',time()));
    	$result = $this->getInfoWithUsername($username,$trade_amount,$trade_no);	//获取用户信息
    	if($result['code'] == 0){
    		//返回接口错误代码
    		return ['code'=>config('code.error'),'msg'=>$result['msg']];	//找不到会员账号
    	}

    	$json = $result['data'];
    	$res = $this->huihuangcunkuan($json,$username,$trade_amount,$trade_no);
    	if($res['code'] == 0){
    		//返回接口错误代码
    		return ['code'=>config('code.error'),'msg'=>$res['msg']];	//系统掉单联系人工
    	}
    	
    	Order::where(['trade_no'=>$trade_no])->update(['pay_type'=>6,'username'=>$username]);	//修改了订单
    	return ['code'=>config('code.success'),'msg'=>'恭喜你存款成功了哦'];
    }
    

    public function getCookieByLogin()
    {	
    	//header("content-type:image/jpeg");
    	// 获取QueryList实例
		$ql = QueryList::getInstance();
    	//$jar = new \GuzzleHttp\Cookie\CookieJar();
    	
		//获取到登录表单
		$form = $ql->get('http://fjjws.com/login',[],[
			'timeout'=>30,
    		'headers'=>[
    			'Connection' => 'keep-alive',
		        'User-Agent' => 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/55.0.2883.87 UBrowser/6.2.4094.1 Safari/537.36',
		        'Accept'     => 'text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8',
    		],
	        //'cookies' => $jar
		])->find('form');
		
		$code = $ql->get('http://fjjws.com/validCode?simple=true')->getHtml();
		$jar = \QL\Services\HttpService::getCookieJar();	//获取到cookies
		//dd($jar->toArray());
		//把cookie保存到文件缓存内
		$value = Cache::store('file')->put('cookies',$jar->toArray()[0]['Name'].'='.$jar->toArray()[0]['Value'],480);
		//echo $code;
	 	file_put_contents(public_path().'\code\code.gif',$code);	//写入gif
		
		$gifStream = new FileStream(public_path().'\code\code.gif');
		$gifDecoder = new Decoder($gifStream);
		$gifDecoder->decode(function (FrameDecodedEvent $event) {

		    $paddedIndex = str_pad($event->frameIndex, 3, '0', STR_PAD_LEFT);
		
		    $event->decodedFrame->getStream()->copyContentsToFile(
		        __DIR__ . "/frames/frame{$paddedIndex}.gif"
		    );
		 
		});

		//直接获取到第二帧的图片发送给api 接口
		try {
			$img_num = $this->juheApi(__DIR__ . "/frames/frame001.gif");
			$code = json_decode($img_num)->result;
		} catch (\Exception $e) {
			app('log')->info('聚合数据服务器出错,时间: '.date('Y-m-d H:i:s',time()));
		}

		
		//填写 辉煌后台 用户名和密码
		$form->find('input[name=username]')->val('rkceshi');
		$form->find('input[name=password]')->val('qq123123');
		$form->find('input[name=securityCode]')->val($code);

		//序列化表单数据
		$fromData = $form->serializeArray();
		
		$postData = [];
		foreach ($fromData as $item) {
		    $postData[$item['name']] = $item['value'];
		}

		//提交登录表单
		$actionUrl = 'http://fjjws.com/'.$form->attr('action');
		
		$ql->post($actionUrl,$postData,[
		 	'timeout'=>30,
    		'headers'=>[
    			'Connection' => 'keep-alive',
		        'User-Agent' => 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/55.0.2883.87 UBrowser/6.2.4094.1 Safari/537.36',
		        'Accept'     => 'text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8',
		        'Cookie'    => Cache::get('cookies')
    		]
		]);

		
		//判断登录是否成功
		$json = json_decode($ql->getHtml());

		if(!$json->status){
			/*echo "验证码不对!";
			exit();*/				//调用自己	
			app('log')->info('调用失败--聚合数据验证码识别api,时间: '.date('Y-m-d H:i:s',time()));
			return $this->getCookieByLogin();
		};
		if($json->status){
			/*echo "验证码通过";
			exit();*/
			app('log')->info('调用成功--聚合数据验证码识别api,时间: '.date('Y-m-d H:i:s',time()));
		}	
			

    }

    //accountId:303007809	// true
	//depositModelId:2575	//true
	//accountNameList:		//true
	//cashManOnlineTime:1542607684637	//true  时间戳
	//accountName:test123	//true
	//depositType:1		//true
	//depositAmount:0.1	//true
	//depositAmountRemark:	//备注
	//depositPreferenceAmount:0		//存款优惠
	//depositPreferenceAmountRemark:	//存款优惠备注
	//otherPreferenceAmount:0		//汇款
	//otherPreferenceAmountRemark:	汇款备注
	//synthesizeAuditAmount:	//打码量
	//normalityAuditCheck:1		//稽核打码量
	//highestDeposit:5000000	//最高存款金额
	//lowestDeposit:10			//最低存款金额
    //查询存款用户的信息
    public function getInfoWithUsername($username,$amount,$trade_no)
    {
    	$ql = QueryList::getInstance();
    	$ql->post('http://fjjws.com/cash/man/manOnlineDeposit/queryAccountByName',[
    		'accountName'=>$username
    	],[
    		'timeout'=>30,
    		'headers'=>[
    			'Connection' => 'keep-alive',
		        'User-Agent' => 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/55.0.2883.87 UBrowser/6.2.4094.1 Safari/537.36',
		        'Accept'     => 'text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8',
		        'Cookie'    => Cache::get('cookies')
    		]
    	]);
    	
    	if($ql->find('.btn-block')->text() == "登 录"){
    		//模拟登陆获取cookie

    		$this->getCookieByLogin();
    		$this->getInfoWithUsername($username,$amount,$trade_no);
    		//模拟存款操作
    		app('log')->info('cookie失效重新获取cookie,时间: '.date('Y-m-d H:i:s',time()));
    	};

    	// data == null 找不到会员
    	$json = json_decode($ql->getHtml());

    	if(is_null($json->data)){	//如何为null 找不到会员
    		//操作数据库写入错误信息
    		//echo '会员账号错误!设置为掉单处理';
    		//exit();	//  会员账号错误(407)(手动)
    		app('log')->info('会员账号错误,时间: '.date('Y-m-d H:i:s',time()));
    		//会员账号错误,设置为掉单处理
    		Order::where('trade_no',$trade_no)->update(['pay_type'=>4,'tips'=>'会员账号错误!设置为掉单处理']);
    		return ['code'=>config('code.error'),'msg'=>'会员账号错误!设置为掉单处理'];
    	}
  		//存款动作
    	//$this->huihuangcunkuan($json,$username,$amount);

    	return ['code'=>config('code.success'),'data'=>$json];
    }


    //辉煌入款操作
    public function huihuangcunkuan($json,$username,$amount,$trade_no)
    {

    	$ql = QueryList::getInstance();
    	$ql->post('http://fjjws.com/cash/man/manOnlineDeposit/insert',[
    		'accountId'=>$json->data->accountId,
    		'depositModelId'=>$json->data->depositModelId,
    		'accountNameList'=>$json->data->accountNameList,
    		'cashManOnlineTime'=>time(),	//间隔5秒
    		'accountName'=>$username,
    		'depositType'=>'1',	//  为人工 6 为活动优惠
    		'depositAmount'=>$amount,	//金额
    		'normalityAuditCheck'=>1,
    		'lowestDeposit'=>'1',		//最低存款金额
    		'highestDeposit'=>'5000000',//最高存款金额
    	],[
    		'timeout'=>30,
    		'headers'=>[
    			'Connection' => 'keep-alive',
		        'User-Agent' => 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/55.0.2883.87 UBrowser/6.2.4094.1 Safari/537.36',
		        'Accept'     => 'text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8',
		        'Cookie'    => Cache::get('cookies')
    		]
    	]);

    	$data = json_decode($ql->getHtml());
    	
    	if($data->status == 'error'){
    		//操作数据库修改状态值
    		/*echo json_encode($data);	//掉单(400) (手动) (异常)
    		exit();*/
    		app('log')->info('辉煌入款操作失败,时间: '.date('Y-m-d H:i:s',time()).'info:'.json_encode($data));
    		//辉煌系统问题
    		Order::where('trade_no',$trade_no)->update(['pay_type'=>5,'tips'=>'系统掉单']); //json_encode($data)
    		return ['code'=>config('code.error'),'msg'=>json_encode($data)];
    	}
    	if($data->status == 'success'){
    		//操作数据库修改状态值
    		/*echo 'success';
    		exit();*/
    		app('log')->info('辉煌入款操作成功,时间: '.date('Y-m-d H:i:s',time()));
    		Order::where('trade_no',$trade_no)->update(['pay_type'=>3,'tips'=>'支付ok']);
    		return ['code'=>config('code.success')];
    	}
    }

    //聚合api 返回json
    public function juheApi($path_img)
    {
		header("Content-type:text/html;charset=utf-8");
		/* 请自行学习curl的知识，以下代码仅作引导之用，不可用于生产环境 */
		$ch = curl_init('http://op.juhe.cn/vercode/index');
		$cfile = curl_file_create($path_img, 'image/png', 'pic.png');
		$data = array(
		  'key' => 'a09c907aa636b14255e986e504f6e12f', //请替换成您自己的key
		  'codeType' => '3004', // 验证码类型代码，请在https://www.juhe.cn/docs/api/id/60/aid/352查询
		  'image' => $cfile
		);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		$response = curl_exec($ch);
		curl_close($ch);
		return ($response);
    }

}
