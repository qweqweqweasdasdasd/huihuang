<?php

namespace App\Http\Controllers\Admin;

use App\Pic;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class QRcodeController extends Controller
{
    //显示二维码修改的页面
    public function index()
    {
    	$pic = Pic::find(1);
    	return view('admin.qrcode.index',compact('pic'));
    }

    //二维码上传
    public function images(Request $request)
    {
    	//调用图片上传类工具
    	$upload = new \App\Common\Upload($_FILES['file']);
    	$res = $upload->up();
    	if($res['code'] == 0){
    		return ['code'=>config('code.error'),'error'=>$res['error']];
    	}
    	Pic::where('pic_id',1)->update(['picture'=>$res['data']]);
    	return ['code'=>config('code.success'),'path'=>$res['data']];
    	
    }
}
