<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Lib\SsfPlatform;

class RobotController extends Controller
{
	public function GetToken()
	{
		$pf = new SsfPlatform();

		$token = $pf->GetToken();
		
		dd($token);
	}

	public function CheckUname()
	{
		$pf = new SsfPlatform();

		$info = $pf->CheckUname();
		
		dd($info);
	}

	public function DoScore()
	{
		$pf = new SsfPlatform();

		$info = $pf->DoScore();
		
		dd($info);
	}
}
