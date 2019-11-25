<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

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

        if(($order->status != 'new' && !$request->user()->isAdmin()
            && $order->id_customer != Auth::id()
            && $order->id_worker != Auth::id())
            || $order->status == 'complete') {
            return redirect('/orders');
        }

        return $next($request);
    }
}
