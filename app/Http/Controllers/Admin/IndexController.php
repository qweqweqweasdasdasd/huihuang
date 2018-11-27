<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class IndexController extends Controller
{
	//管理员后台
    public function index()
    {
        error_reporting(0);
    	return view('admin.index.index');
    }

    //显示welcome
    public function welcome()
    {
    	return view('admin.index.welcome');
    }

}
