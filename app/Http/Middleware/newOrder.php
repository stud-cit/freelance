<?php

namespace App\Http\Middleware;

use Closure;
use DB;

class newOrder
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
        $order = DB::table('orders')->where('id_order', $request->id)->get(['status'])->first();

        if(is_null($order)) {
            abort(404);
        }

        if($order->status != 'new' && !$request->user()->isAdmin()) {
            return redirect('/orders');
        }

        return $next($request);
    }
}
