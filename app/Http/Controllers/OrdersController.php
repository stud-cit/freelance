<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
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

        foreach ($workers as $worker) {
            if (Storage::disk('public')->has($worker->id_user . '.png')) {
                $worker->avatar = '/img/' . $worker->id_user . '.png';
            }
            else {
                $worker->avatar = '/img/' . $worker->id_user . '.jpg';
            }
        }

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
            ->get()
            ->first();

        if (Storage::disk('public')->has($customer->id_user . '.png')) {
            $customer->avatar = '/img/' . $customer->id_user . '.png';
        }
        else {
            $customer->avatar = '/img/' . $customer->id_user . '.jpg';
        }

        $proposals = DB::table('proposals')
            ->join('users_info', 'proposals.id_worker', '=', 'users_info.id_user')
            ->where('id_order', $id)
            ->get(['id_user', 'text', 'price', 'time', 'name', 'surname', 'patronymic', 'proposals.created_at'])
            ->toArray();

        foreach ($proposals as $one) {
            if (Storage::disk('public')->has($one->id_user . '.png')) {
                $one->avatar = '/img/' . $one->id_user . '.png';
            }
            else {
                $one->avatar = '/img/' . $one->id_user . '.jpg';
            }
        }

        $data = [
            'order' => $order,
            'customer' => $customer,
            'proposals' => $proposals,
        ];

        return view('orders.order', compact('data'));
    }

    public function add_proposal(Request $req)
    {
        if (is_null($req->time) || is_null($req->price) || is_null($req->text) ||
            ($req->type != 'дні' && $req->type != 'год.') ||
            ($req->currency != '$' && $req->currency != 'грн.')) {

            $req->session()->flash('alert-danger', 'Заповніть поля!');
            return back();
        }

        $type = $req->type;
        $time = $req->time;

        if($type == 'дні') {
            switch ($req->time) {
                case $time == 1 :
                    $time = $time . ' день';
                    break;
                case $time > 1 && $time < 5 :
                    $time = $time . ' дні';
                    break;
                default :
                    $time = $time . ' днів';
            }
        }

        $values = [
            'text' => $req->text,
            'price' => $req->price.' '.$req->currency,
            'time' => $time,
            'id_order' => $req->id,
            'id_worker' => Auth::user()->id,
            'created_at' => Carbon::now(),
        ];

        DB::table('proposals')->insert($values);

        $req->session()->flash('alert-success', 'Пропозицію успішно додано!');

        return back();
    }
}
