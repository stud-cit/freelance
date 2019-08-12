<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use DB;
use Auth;

class OrdersController extends Controller
{
    public function index()
    {
        $data = DB::table('orders')->get()->toArray();

        $ids = DB::table('users')->where('id_role', 3)->get('id')->toArray();

        $array = [];

        foreach ($ids as $one) {
            array_push($array, $one->id);
        }

        $workers = DB::table('users_info')->whereIn('id_user', $array)->get()->toArray();

        return view('orders.index', compact('data'), compact('workers'));
    }

    public function order($id)
    {
        $id_customer = DB::table('orders')->where('id_order', $id)->get('id_customer')->first();

        if (!$id_customer) {
            abort(404);
        }

        $order = DB::table('orders')->where('id_order', $id)->get(['id_order', 'title', 'description', 'price', 'time', 'status', 'created_at'])->first();

        $customer = DB::table('users')
            ->join('users_info', 'users.id', '=', 'users_info.id_user')
            ->where('id', $id_customer->id_customer)
            ->get(['name', 'surname', 'patronymic', 'phone_number', 'email', 'viber', 'skype', 'avatar', 'about_me'])
            ->first();

        $proposals = DB::table('proposals')
            ->join('users_info', 'proposals.id_worker', '=', 'users_info.id_user')
            ->where('id_order', $id)
            ->get(['text', 'price', 'time', 'name', 'surname', 'patronymic', 'avatar', 'proposals.created_at'])
            ->toArray();

        $data = [
            'order' => $order,
            'customer' => $customer,
            'proposals' => $proposals,
        ];

        return view('orders.order', compact('data'));
    }

    public function add_proposal(Request $req)
    {
        $values = [
            'text' => $req->text,
            'price' => $req->price.' '.$req->currency,
            'time' => $req->time,
            'id_order' => $req->id,
            'id_worker' => Auth::user()->id,
            'created_at' => Carbon::now(),
        ];

        DB::table('proposals')->insert($values);

        return back();
    }
}
