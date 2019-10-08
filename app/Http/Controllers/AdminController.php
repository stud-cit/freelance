<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use DB;
use Auth;

class AdminController extends Controller
{
    public function index()
    {
        $orders = DB::table('orders')
            ->where('status', '!=', 'complete')
            ->orderBy('id_order', 'desc')
            ->get()
            ->toArray();

        foreach ($orders as $one) {
            $one->price = is_null($one->price) ? '' : $one->price;
            $one->time = is_null($one->time) ? '' : $one->time;
        }

        $users = User::getUsersInfo();

        $array = [];

        foreach ($users as $one) {
            if ($one->id_role != 1) {
                array_push($array, $one);
            }
        }

        $data = [
            'orders' => $orders,
            'users' => $array,
        ];

        return view('admin.index', compact('data'));
    }

    public function ban(Request $req)
    {
        $id = $req->ban;

        DB::table('users')->where('id', $id)->update(['banned' => true]);

        $orders = DB::table('orders')->where([['id_customer', $id], ['status', '!=', 'complete']])->get('id_order');

        $ids = [];

        foreach ($orders as $one) {
            array_push($ids, $one->id_order);
        }

        DB::table('categories_has_orders')->whereIn('id_order', $ids)->delete();
        DB::table('proposals')->whereIn('id_order', $ids)->delete();
        DB::table('orders')->whereIn('id_order', $ids)->delete();
        DB::table('orders')->where([['id_worker', $id], ['status', 'in progress']])->update(['id_worker' => null]);
        DB::table('proposals')
            ->join('orders', 'proposals.id_order', '=', 'orders.id_order')
            ->where([['proposals.id_worker', $id], ['status', '!=', 'complete']])
            ->delete();

        return back();
    }

    public function unban(Request $req)
    {
        DB::table('users')->where('id', $req->ban)->update(['banned' => false]);

        return back();
    }

    public function finish_order(Request $req)
    {
        DB::table('orders')->where('id_order', $req->finish)->update(['status' => 'complete']);

        return back();
    }

    public function delete_order(Request $req)
    {
        DB::table('categories_has_orders')->where('id_order', $req->delete)->delete();
        DB::table('proposals')->where('id_order', $req->delete)->delete();
        DB::table('orders')->where('id_order', $req->delete)->delete();

        return back();
    }
}
