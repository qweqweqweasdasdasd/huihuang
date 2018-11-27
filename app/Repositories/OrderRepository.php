<?php 
namespace App\Repositories;

use App\Order;

class OrderRepository extends BaseRepository
{
	//获取到所有的订单信息
	public function getOrderFeeds($whereData,$from,$size)
	{
		return Order::where(function($query) use($whereData){
					if( !empty($whereData['maxDate']) && !empty($whereData['minDate']) && ($whereData['maxDate'] > $whereData['minDate']) ){
						$query->where('trade_time','>',$whereData['minDate'])
							  ->where('trade_time','<',$whereData['maxDate']);
					}

					if( !empty($whereData['order_no']) ){
						$query->where('order_no','like','%'.$whereData['order_no'].'%')	//模糊查询
							  ->orWhere('trade_no','like','%'.$whereData['order_no'].'%');
					}
				})
				->orderBy('trade_time','desc')
				->limit($size)
				->offset($from)
				->get();
	}

	//根据条件获取订单的总量
	public function getOrderCount($whereData)
	{
		return Order::where(function($query) use($whereData){
					if( !empty($whereData['maxDate']) && !empty($whereData['minDate']) && ($whereData['maxDate'] > $whereData['minDate']) ){
						$query->where('trade_time','>',$whereData['minDate'])
							  ->where('trade_time','<',$whereData['maxDate']);
					}

					if( !empty($whereData['order_no']) ){
						$query->where(['order_no'=>$whereData['order_no']])
							  ->orWhere(['trade_no'=>$whereData['order_no']]);
					}
				})
				->count();
	}

	//掉单补单
	public function budanOrder($order_id)
	{
		return Order::where('order_id',$order_id)->update(['pay_type'=>'3']);
	}
}