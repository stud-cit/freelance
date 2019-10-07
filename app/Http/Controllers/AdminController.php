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
            $one->description = strlen($one->description) > 50 ? substr($one->description, 0, 50) . '...' : $one->description;
            $one->price = is_null($one->price) ? '' : $one->price;
            $one->time = is_null($one->time) ? '' : $one->time;
        }

        $users = User::getUsersInfo();

        $data = [
            'orders' => $orders,
            'users' => $users,
        ];

        return view('admin.index', compact('data'));
    }
}
