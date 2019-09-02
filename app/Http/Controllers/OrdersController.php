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
    private $eq;

    function currency_update() {
        $req_url = 'https://api.exchangerate-api.com/v4/latest/USD';
        if ($response_json = file_get_contents($req_url)) {
            $response_object = json_decode($response_json);

            $fp = fopen('currency.json', 'w');
            fwrite($fp, $response_json);
            fclose($fp);

            $this->eq = $response_object->rates->UAH;
        }
        else {
            $fp = file_get_contents('currency.json');
            $response_object = json_decode($fp, true);
            $this->eq = $response_object['rates']['UAH'];
        }
    }

    function cmp($a, $b)
    {
        $val_a = explode(' ', $a->price);
        $val_b = explode(' ', $b->price);
        $first_price = !is_null($a->price) ? $val_a[0] * ($val_a[1] == '$' ? $this->eq : 1) : 0;
        $second_price = !is_null($b->price) ? $val_b[0] * ($val_b[1] == '$' ? $this->eq : 1) : 0;

        return $first_price > $second_price;
    }

    public function index($sort = null, $filter = null)
    {
        if (is_null($sort)) {
            $data = DB::table('orders')->where('status', 'new')->orderBy('created_at', 'desc')->get()->toArray();

            $sort = 'id_order-desc';
        }
        else {
            $sort = explode('-', $sort);
            $data = DB::table('orders')->where('status', 'new')->orderBy($sort[0], $sort[1])->get()->toArray();

            if ($sort[0] == 'price') {
                $this->currency_update();
                usort($data, array($this, "cmp"));

                if ($sort[1] == 'desc') {
                    $data = array_reverse($data);
                }
            }

            $sort = $sort[0] . '-' . ($sort[1] == 'asc' ? 'desc' : 'asc');
        }

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

        $categories = DB::table('categories')->get()->toArray();

        $info = [
            'data' => $data,
            'workers' => $workers,
            'sort' => $sort,
            'filter' => $filter,
            'categories' =>$categories,
        ];

        return view('orders.index', compact('info'));
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

        $my_proposal = DB::table('proposals')
            ->join('users_info', 'proposals.id_worker', '=', 'users_info.id_user')
            ->where([['id_order', $id], ['id_worker', Auth::user()->id]])
            ->get(['id_user', 'text', 'price', 'time', 'name', 'surname', 'patronymic', 'proposals.created_at'])
            ->first();

        if (!is_null($my_proposal)) {
            $temp = explode(' ', $my_proposal->price);
            $my_proposal->price = $temp[0];
            $my_proposal->currency = $temp[1];

            $temp = explode(' ', $my_proposal->time);
            $my_proposal->time = $temp[0];
            $my_proposal->type = $temp[1];
        }

        if ($order->status == 'new') {
            $proposals = DB::table('proposals')
                ->join('users_info', 'proposals.id_worker', '=', 'users_info.id_user')
                ->where('id_order', $id)
                ->get(['id_user', 'text', 'price', 'time', 'name', 'surname', 'patronymic', 'proposals.created_at'])
                ->toArray();
        }
        else {
            $proposals = DB::table('proposals')
                ->join('users_info', 'proposals.id_worker', '=', 'users_info.id_user')
                ->where([['id_order', $id], ['id_worker', $order->id_worker]])
                ->get(['id_user', 'text', 'price', 'time', 'name', 'surname', 'patronymic', 'proposals.created_at'])
                ->toArray();
        }

        foreach ($proposals as $one) {
            if (Storage::disk('public')->has($one->id_user . '.png')) {
                $one->avatar = '/img/' . $one->id_user . '.png';
            }
            else {
                $one->avatar = '/img/' . $one->id_user . '.jpg';
            }
        }

        $categories = DB::table('categories_has_orders')
            ->join('categories', 'categories_has_orders.id_category', '=', 'categories.id_category')
            ->where('id_order', $id)
            ->get()
            ->toArray();

        $data = [
            'order' => $order,
            'customer' => $customer,
            'proposals' => $proposals,
            'my_proposal' => $my_proposal,
            'categories' => $categories,
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

            $check = DB::table('proposals')->where([['id_order', $req->id], ['id_worker', Auth::user()->id]])->get('id_proposal')->first();

            if (is_null($check)) {
                DB::table('proposals')->insert($values);

                $req->session()->flash('alert-success', 'Пропозицію успішно додано!');
            }
            else {
                DB::table('proposals')->where([['id_order', $req->id], ['id_worker', Auth::user()->id]])->update($values);

                $req->session()->flash('alert-success', 'Пропозицію успішно змінено!');
            }
        }
        else if ($req->has('delete_proposal')) {
            DB::table('proposals')->where([['id_order', $req->id], ['id_worker', Auth::user()->id]])->delete();

            $req->session()->flash('alert-success', 'Пропозицію успішно видалено!');
        }
        else if ($req->has('form_select')) {
            DB::table('orders')->where('id_order', $req->id)->update(['status' => 'in progress', 'id_worker' => $req->selected_worker]);

            $req->session()->flash('alert-success', 'Виконавця успішно вибрано!');
        }
        else if ($req->has('leave_review')) {
            if (!is_null($req->text)) {
                $worker = DB::table('orders')->where('id_order', $req->id)->get('id_worker')->first();

                $values = [
                    'text' => $req->text,
                    'rating' => $req->rating,
                    'id_from' => Auth::user()->id,
                    'id_to' => $worker->id_worker,
                    'created_at' => Carbon::now(),
                ];

                DB::table('reviews')->insert($values);
            }

            if ($req->cancel_check == 1) {
                DB::table('orders')->where('id_order', $req->id)->update(['status' => 'complete']);

                $req->session()->flash('alert-success', 'Замовлення успішно завершено!');

                return redirect('/orders');
            }
            else {
                DB::table('orders')->where('id_order', $req->id)->update(['status' => 'new', 'id_worker' => null]);

                $req->session()->flash('alert-success', 'Виконавця успішно видалено!');
            }
        }

        return back();
    }

    public function save_order(Request $req)
    {
        if (!$req->has('add_order')) {
            $test = end($req->request);
            $array = array_keys($test);

            return $this->index(end($array), $req->prev_filter);
        }
        else {
            if (is_null($req->description) || is_null($req->title) ||
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

            $categories = explode('|', $req->categories);
            array_pop($categories);

            foreach ($categories as $one) {
                DB::table('categories_has_orders')->insert(['id_category' => $one, 'id_order' => $id->id_order]);
            }

            $req->session()->flash('alert-success', 'Замовлення успішно додано!');

            return redirect('/orders/' . $id->id_order);
        }
    }
}
