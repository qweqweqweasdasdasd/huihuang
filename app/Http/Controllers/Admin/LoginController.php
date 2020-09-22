<?php

namespace App\Http\Controllers\Admin;

use Auth;
use App\Manager;
use Flc\Dysms\Client;
use Illuminate\Http\Request;
use Flc\Dysms\Request\SendSms;
use App\Http\Controllers\Controller;
use App\Http\Requests\ManagerLoginRequest;
use App\Http\Requests\ManagerTelLoginRequest;

class LoginController extends Controller
{
    //管理员登录页面显示
    public function login()
    {
        try {
            if(Auth::guard('back')->user()->mg_id){     //用户登录的话不可以到登录的页面
                return redirect('/index/index');
            }
        } catch (\Exception $e) {   
            //return ['code'=>config('code.error')];  
    	   return view('admin.login.login');
        }
    }

    //使用手机号码进行登录页面
    public function tellogin()
    {
        try {
            if(Auth::guard('back')->user()->mg_id){     //用户登录的话不可以到登录的页面
                return redirect('/index/index');
            }
        } catch (\Exception $e) {
            
            return view('admin.login.tellogin');
        }
    }

    //发送短信请求
    public function sendSMS(Request $request)
    {
        $phone = $request->get('tel');
        $mg_name = $request->get('mg_name');
        //没有输入用户账号
        if($mg_name == null){
            return ['code'=>0,'error'=>"用户账号没有填写!"];
        }
        //查询不到该用户
        if(is_null(Manager::where('mg_name',$mg_name)->first())){
            return ['code'=>0,'error'=>"没有该账号,谢谢!"];
        };
        //检查一个input 是否为手机号
        if(!preg_match("/^1[34578]\d{9}$/",$phone)){
            return ['code'=>0,'error'=>'您的手机号码不对哦!!'];
        }

        $config = config('aliyun-sms.sms_config');
        $code = rand(100000, 999999);
        $client = new Client($config);
        $sendSms = new SendSms;
        $sendSms->setPhoneNumbers($phone);
        $sendSms->setSignName('就是我');
        $sendSms->setTemplateCode('SMS_143715724');
        $sendSms->setTemplateParam(['code' => $code]);
        $sendSms->setOutId('demo');
        if($client->execute($sendSms)->Message != 'ok'){
            $error = $client->execute($sendSms)->Code;
            switch ($error) {
                 case 'isv.MOBILE_NUMBER_ILLEGAL':
                     return ['code'=>0,'error'=>'您的手机号码不对哦'];
                     
                 case 'isv.MOBILE_COUNT_OVER_LIMIT':
                     return ['code'=>0,'error'=>'手机号码超出限制'];
                
                 case 'isv.SMS_TEMPLATE_ILLEGAL':
                     return ['code'=>0,'error'=>'短信模板不合法']; 
                 case 'isv.AMOUNT_NOT_ENOUGH':
                     return ['code'=>0,'error'=>'账户余额不足']; 
             } 
            
        }
        //记录发送短信的code
        Manager::where('mg_name',$mg_name)->update(['sms'=>$code]);
        return ['code'=>config('code.success')];
    }

    //登录检测逻辑    //
    public function checkadmin(ManagerTelLoginRequest $request)
    {
        //author 验证
        $nameAndPassword = $request->only(['mg_name','password']);


        if(!Auth::guard('back')->attempt($nameAndPassword)){
            //return back()->withErrors(['验证失败!']);
            return ['code'=>config('code.error'),'error'=>'用户名或者密码不正确!'];
        }

        //短信验证码是否对
        if( $request->get('sms') != Manager::where('mg_name',$request->get('mg_name'))->first()->sms ){
            return ['code'=>config('code.error'),'error'=>'短信验证码以最后一个为准!'];
        };
        
        //单点登录  
        $session_id = $request->session()->getId();
        $this->singleUser($session_id);
        return ['code'=>config('code.success')];
    }

    //访问根目录跳转出去
    public function redirect()
    {
        return redirect('/wechat');
    }

    //管理员退出登录
    public function logout()
    {
        try {
            $mg_name = \Auth::guard('back')->user()->mg_name;
            Manager::where('mg_name',$mg_name)->update(['sms'=>'退出自动清空']);
            Auth::guard('back')->logout();
        } catch (Exception $e) {
        }
        return redirect('/tellogin');
    }

    //管理登录检验
    public function check(ManagerLoginRequest $request)
    {
    	//author 验证
    	$nameAndPassword = $request->only(['mg_name','password']);

    	if(!Auth::guard('back')->attempt($nameAndPassword)){
    		//return back()->withErrors(['验证失败!']);
    		return ['code'=>config('code.error'),'error'=>'用户名或者密码不正确!'];
    	}

    	//单点登录  
        $session_id = $request->session()->getId();
        $this->singleUser($session_id);
    	return ['code'=>config('code.success')];
    }

    //单用户登录
    public function singleUser($session_id)
    {
        $mg_id = Auth::guard('back')->user()->mg_id;
        $sessionId = Manager::find($mg_id)->session_id;

        if(is_null($sessionId)){    //第一次
            return Manager::where('mg_id',$mg_id)->update(['session_id'=>$session_id]);
        } 
        //第二次
        if($sessionId != $session_id){
            try {
                unlink("/blog/storage/framework/sessions/{$sessionId}");    //错误的使用了单引号
            } catch (\Exception $e) {
                
            }
            return Manager::where('mg_id',$mg_id)->update(['session_id'=>$session_id]);
        }
        
    }
}
