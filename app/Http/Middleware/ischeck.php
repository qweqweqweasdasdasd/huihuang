<?php

namespace App\Http\Middleware;

use Auth;
use Closure;

class ischeck
{
    /**
     * 判断用户是否登录
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        try {
            Auth::guard('back')->user()->mg_id;
        } catch (\Exception $e) {
            return redirect('/login')->withErrors('没有登录!');
        }
        
        return $next($request);
    }
}
