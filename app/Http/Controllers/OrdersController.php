<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use DB;
use Auth;
use App\Models\User;

class OrdersController extends Controller
{
    public function index()
    {
        $data = DB::table('orders')->where('status', 'new')->get()->toArray();
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
        $order = DB::table('orders')->where('id_order', $id)->get()->first();
        $customer = User::getUsersInfo('id', $order->id_customer)->first();

        if (Storage::disk('public')->has($order->id_customer . '.png')) {
            $customer->avatar = '/img/' . $order->id_customer . '.png';
        }
        else {
            $customer->avatar = '/img/' . $order->id_customer . '.jpg';
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
        if ($req->has('form_proposals')) {
            if (is_null($req->text) ||
                ($req->type != 'дні' && $req->type != 'год.') ||
                ($req->currency != '$' && $req->currency != 'грн.')) {

                $req->session()->flash('alert-danger', 'Заповніть поля!');
                return back();
            }

            $type = $req->type;
            $time = $req->time;
            $price = is_null($req->price) ? null : $req->price . ' ' . $req->currency;

            if ($type == 'дні' && !is_null($time)) {
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
                'price' => $price,
                'time' => $time,
                'id_order' => $req->id,
                'id_worker' => Auth::user()->id,
                'created_at' => Carbon::now(),
            ];

            DB::table('proposals')->insert($values);

            $req->session()->flash('alert-success', 'Пропозицію успішно додано!');
        }
        else if ($req->has('form_select')) {
            DB::table('orders')->where('id_order', $req->id)->update(['status' => 'in progress', 'id_worker' => $req->selected_worker]);
        }

        return back();
    }

    public function add_order()
    {
        return view('orders.add_order');
    }

    public function save_order(Request $req)
    {
        if (is_null($req->description) || is_null($req->title) ||
            ($req->type != 'дні' && $req->type != 'год.') ||
            ($req->currency != '$' && $req->currency != 'грн.')) {

            $req->session()->flash('alert-danger', 'Заповніть поля!');
            return back();
        }

        $type = $req->type;
        $time = $req->time;
        $price = is_null($req->price) ? null : $req->price . ' ' . $req->currency;

        if($type == 'дні' && !is_null($time)) {
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
            'title' => $req->title,
            'description' => $req->description,
            'price' => $price,
            'time' => $time,
            'status' => 'new',
            'id_customer' => Auth::user()->id,
            'id_worker' => null,
            'created_at' => Carbon::now(),
        ];

        DB::table('orders')->insert($values);

        $id = DB::table('orders')->where('id_customer', Auth::user()->id)->orderBy('id_order', 'desc')->get(['id_order'])->first();

        $req->session()->flash('alert-success', 'Замовлення успішно додано!');

        return redirect('/orders/' . $id->id_order);
    }
}
