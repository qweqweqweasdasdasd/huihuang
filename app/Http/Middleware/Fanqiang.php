<?php

namespace App\Http\Middleware;

use Auth;
use Closure;
use App\Permission;
use App\Manager;

class Fanqiang
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $nowCa = strtolower(getCurrentControllerName() . '-' . getCurrentMethodName());
        $mg_id = Auth::guard('back')->user()->mg_id;
        $ps_ca = Manager::find($mg_id)->role->ps_ca;
        /*echo $nowCa . '<br/>';
        echo $ps_ca;*/
        if(strpos($ps_ca,$nowCa) === false){
            exit('没有权限!');
        }
        
        return $next($request);
    }
}
