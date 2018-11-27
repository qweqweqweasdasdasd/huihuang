<?php

namespace App\Http\Controllers\Server;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class StrController extends Controller
{
    //随机的字符串
    public function random($lenth = 11)
    {
    	$data = [
    		'code'=>config('code.success'),
    		'data'=>str_random($lenth),
    	];

    	return json_encode($data);
    }
}
