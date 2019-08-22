<?php

namespace App\Http\Middleware;

use Closure;
use DB;
use Auth;

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
        $order = DB::table('orders')->where('id_order', $request->id)->get(['status', 'id_customer', 'id_worker'])->first();

        if(is_null($order)) {
            abort(404);
        }

        if($order->status != 'new' && !$request->user()->isAdmin() && $order->id_customer != Auth::user()->id && $order->id_worker != Auth::user()->id) {
            return redirect('/orders');
        }

        return $next($request);
    }
}
