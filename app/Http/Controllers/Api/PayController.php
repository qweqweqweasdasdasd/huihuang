<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Lib\Payment;

class PayController extends Controller
{
	public function Payment(Request $request)
	{
		$p = new Payment();
		$ret = $p->Req();

		dd($ret);
	}


	public function return_url(Request $request)
	{
		$p = new Payment();
		$ret = $p->RetUrl($request->all());

		\Log::info('return_url-'.json_encode($request->all()));
	}

	
}
