<?php

namespace App\Listeners;

use App\Events\OrderUpdated;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class OrderUpdatedListenr
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  OrderUpdated  $event
     * @return void
     */
    public function handle(OrderUpdated $event)
    {
        $adminState = new \App\Http\Controllers\Server\AdminStateController();
        $order = $event->order;
        $adminState->main($order->username,$order->trade_amount);
        
        app('log')->info($order->username."存款了".$order->trade_amount.'时间:'.date('Y-m-d H:i:s'));
    }
}
