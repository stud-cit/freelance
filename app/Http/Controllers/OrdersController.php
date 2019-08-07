<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class OrdersController extends Controller
{
    public function index()
    {
        $data = DB::table('orders')->get()->toArray();

        return view('orders.index', compact('data'));
    }

    public function order($id)
    {
        $id_customer = DB::table('orders')->where('id_order', $id)->get('id_customer')->first();
        $order = DB::table('orders')->where('id_order', $id)->get(['title', 'description', 'price', 'time', 'status'])->first();
        $customer = DB::table('users')->where('id', $id_customer->id_customer)->get(['name', 'surname', 'patronymic', 'phone_number', 'avatar', 'about_me', 'email'])->first();
        $proposals = DB::table('proposals')
            ->join('users', 'proposals.id_worker', '=', 'users.id')
            ->where('id_order', $id)
            ->get(['text', 'price', 'time', 'name', 'surname', 'patronymic', 'phone_number', 'avatar', 'about_me', 'email'])
            ->toArray();

        $data = [
            'data' => $order,
            'customer' => $customer,
            'proposals' => $proposals,
        ];

        return view('orders.order', compact('data'));
    }

}
