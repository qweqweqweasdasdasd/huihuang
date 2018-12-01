<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\BaseRepository;
use App\Repositories\OrderRepository;

class OrderController extends Controller
{
	//私有属性
	protected $orderRepository;
	/**
	 * 构造函数
	 */
	public function __construct(OrderRepository $orderRepository,BaseRepository $baseRepository)
	{
		$this->orderRepository = $orderRepository;
		$this->baseRepository = $baseRepository;
	}
	
    //最新存款的列表显示
    public function list(Request $request)
    {
    	error_reporting(0);
    	$whereDate['maxDate'] = !empty($request->get('maxDate')) ? $request->get('maxDate') : '';
    	$whereDate['minDate'] = $request->get('minDate') ? $request->get('minDate') : '';
    	$whereDate['order_no'] = $request->get('order_no') ? $request->get('order_no') : '';
    	$whereDate['cate'] = $request->get('cate') ? $request->get('cate') : '';

    	$this->baseRepository->currPageAndSize($request->all());
    	//分页当前页
    	$page = $this->baseRepository->page;
    	//分页的起始位置
    	$form = $this->baseRepository->form;
    	//分页显示的数量
    	$size = $this->baseRepository->size;

    	$order = $this->orderRepository->getOrderFeeds($whereDate,$form,$size);
    	$total = $this->orderRepository->getOrderCount($whereDate);
    	$pageTotal = ceil($total/$size);

    	return view('admin.order.list',compact(
	    		'order',
	    		'total',
	    		'page',
	    		'pageTotal',
	    		'whereDate'
	    	));
    }

    //补单状态
    public function budan(Request $request)
    {
    	$order_id = $request->get('order_id');

    	return $this->orderRepository->budanOrder($order_id)?['code'=>config('code.success')]:['code'=>config('code.error')];
    }
}
