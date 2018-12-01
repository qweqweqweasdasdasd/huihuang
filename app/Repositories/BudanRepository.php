<?php 
namespace App\Repositories;

use App\Order;
use App\Budan;

class BudanRepository extends BaseRepository
{
	//显示所有的补单信息
	public function getBudanFeeds($trade_no)
	{
		return Budan::select('budan.*','order.pay_type','order.tips','order.trade_no')
					->leftJoin('order','budan.trade_no','=','order.trade_no')
					->where(function($query) use($trade_no){
						if( !empty($trade_no) ){
							$query->where('budan.trade_no',$trade_no);
						}
						$query->where('pay_type','<>','3');
					})
					//->where('pay_type','<>','3')
					->paginate(13);
	}

	//显示所有的补单数量
	public function getBudanCount($trade_no)
	{
		return Budan::select('budan.*','order.pay_type','order.tips','order.trade_no')
					->leftJoin('order','budan.trade_no','=','order.trade_no')
					->where(function($query) use($trade_no){
						if( !empty($trade_no) ){
							$query->where('budan.trade_no',$trade_no);
						}
						$query->where('pay_type','<>','3');
					})
					//->where('pay_type','<>','3')
					->count();

	}
}