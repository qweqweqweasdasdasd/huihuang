<?php

namespace App;

use App\Events\OrderUpdated;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = 'order';
    protected $primaryKey = 'order_id';
   
    protected $fillable = [
    	'order_no','username','amount','pay_type','state','addtime','trade_no','trade_time','is_check','dingdong','yichang','yc_time','tips','trade_amount'
    ];

    /*protected $events = [
    	'updated'=> OrderUpdated::class,	//key就是事件的名字，值就是触发的事件。这个事件可以是一个完整的类
    ];*/

   	
}
