<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class OrdersController extends Controller
{
    public function index()
    {
        $data = DB::table('orders')->get()->toArray();
        $workers = DB::table('users')->where('id_role', 3)->get(['name', 'surname', 'patronymic', 'phone_number', 'avatar', 'about_me', 'email'])->toArray();

        return view('orders.index', compact('data'), compact('workers'));
    }

    public function order($id)
    {
        $id_customer = DB::table('orders')->where('id_order', $id)->get('id_customer')->first();
        $order = DB::table('orders')->where('id_order', $id)->get(['title', 'description', 'price', 'time', 'status', 'created_at'])->first();
        $customer = DB::table('users')->where('id', $id_customer->id_customer)->get(['name', 'surname', 'patronymic', 'phone_number', 'avatar', 'about_me', 'email'])->first();
        $proposals = DB::table('proposals')
            ->join('users', 'proposals.id_worker', '=', 'users.id')
            ->where('id_order', $id)
            ->get(['text', 'price', 'time', 'name', 'surname', 'patronymic', 'phone_number', 'avatar', 'about_me', 'email', 'proposals.created_at'])
            ->toArray();

        $data = [
            'order' => $order,
            'customer' => $customer,
            'proposals' => $proposals,
        ];

        return view('orders.order', compact('data'));
    }

}
