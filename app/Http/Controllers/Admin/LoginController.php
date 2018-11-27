<?php

namespace App\Http\Controllers\Admin;

use Auth;
use App\Manager;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\ManagerLoginRequest;

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

    //管理员退出登录
    public function logout()
    {
        try {
            Auth::guard('back')->logout();
        } catch (Exception $e) {
        }
        return redirect('/login');
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
