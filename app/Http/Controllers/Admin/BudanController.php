<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\BudanRepository;

class BudanController extends Controller
{
	//私有属性
	protected $budanRepository;

	public function __construct(BudanRepository $budanRepository)
	{
		$this->budanRepository = $budanRepository;
	}
	
    //显示补单列表
    public function list(Request $request)
    {
    	$trade_no = !empty($request->get('trade_no'))? $request->get('trade_no') :'';

    	$budan = $this->budanRepository->getBudanFeeds($trade_no);
    	$count = $this->budanRepository->getBudanCount($trade_no);
    	
    	return view('admin.budan.list',compact('budan','trade_no','count'));
    }
}
