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

    function get_currency()
    {
        $fp = file_get_contents('currency.json');
        $response_object = json_decode($fp, true);
        $this->eq = $response_object['rates']['UAH'];

        if (date("Y m d", filemtime('currency.json')) < date("Y m d")) {
            try {
                $req_url = 'https://api.exchangerate-api.com/v4/latest/USD';
                $response_json = file_get_contents($req_url);

                $fp = fopen('currency.json', 'w');
                fwrite($fp, $response_json);
                fclose($fp);
            } catch (\Exception $e) {
            }
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

    public function index()
    {
        $data = DB::table('orders')->where('status', 'new')->orderBy('id_order', 'desc')->get()->toArray();

        foreach ($data as $one) {
            $one->categories = DB::table('categories_has_orders')
                ->join('categories', 'categories.id_category', '=', 'categories_has_orders.id_category')
                ->where('id_order', $one->id_order)
                ->get()
                ->toArray();
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

        $categories = DB::table('categories')->orderBy('name')->get()->toArray();

        foreach ($categories as $one) {
            $one->count = DB::table('categories_has_orders')
                ->join('orders', 'categories_has_orders.id_order', '=', 'orders.id_order')
                ->where([['id_category', $one->id_category], ['status', 'new']])
                ->count();
        }

        return view('orders.index', compact('data'), compact('categories'));
    }

    public function sort_order(Request $req)
    {
        $data = DB::table('orders')
            ->where('status', 'new')
            ->whereIn('id_order', $req->ids)
            ->orderBy($req->what, $req->how)
            ->get()
            ->toArray();

        if ($req->what == 'price') {
            $this->get_currency();
            usort($data, array($this, "cmp"));

            if ($req->how == 'desc') {
                $data = array_reverse($data);
            }
        }

        foreach ($data as $orders) {
            $orders->description = strlen($orders->description) > 50 ? substr($orders->description, 0, 50) . '...' : $orders->description;
            $orders->price = is_null($orders->price) ? '' : $orders->price;
            $orders->time = is_null($orders->time) ? '' : $orders->time;

            $orders->categories = DB::table('categories_has_orders')
                ->join('categories', 'categories.id_category', '=', 'categories_has_orders.id_category')
                ->where('id_order', $orders->id_order)
                ->get()
                ->toArray();
        }

        return $data;
    }

    public function select_category(Request $req)
    {
        $data = DB::table('orders')
            ->where('status', 'new')
            ->orderBy('id_order', 'desc')
            ->get()
            ->toArray();

        $array = [];

        foreach ($data as $orders) {
            $orders->description = strlen($orders->description) > 50 ? substr($orders->description, 0, 50) . '...' : $orders->description;
            $orders->price = is_null($orders->price) ? '' : $orders->price;
            $orders->time = is_null($orders->time) ? '' : $orders->time;

            $orders->categories = DB::table('categories_has_orders')
                ->join('categories', 'categories.id_category', '=', 'categories_has_orders.id_category')
                ->where('id_order', $orders->id_order)
                ->get()
                ->toArray();

            if ($req->category != '0') {
                foreach ($orders->categories as $one) {
                    if ($one->id_category == $req->category) {
                        array_push($array, $orders);
                        break;
                    }
                }
            }
            else {
                array_push($array, $orders);
            }
        }

        return $array;
    }

    public function order($id)
    {
        $order = DB::table('orders')->where('id_order', $id)->get()->first();
        $customer = User::getUsersInfo('id', $order->id_customer)->first();

        $my_proposal = DB::table('proposals')
            ->join('users_info', 'proposals.id_worker', '=', 'users_info.id_user')
            ->where([['id_order', $id], ['id_worker', Auth::user()->id]])
            ->get(['id_user', 'text', 'price', 'time', 'name', 'surname', 'patronymic', 'proposals.created_at'])
            ->first();

        if (!is_null($my_proposal)) {

            if (!is_null($my_proposal->price)) {
                $temp = explode(' ', $my_proposal->price);
                $my_proposal->price = $temp[0];
                $my_proposal->currency = $temp[1];
            }
            else {
                $my_proposal->currency = '';
            }

            if (!is_null($my_proposal->time)) {
                $temp = explode(' ', $my_proposal->time);
                $my_proposal->time = $temp[0];
                $my_proposal->type = $temp[1];
            }
            else {
                $my_proposal->type = '';
            }
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

        $categories = DB::table('categories_has_orders')
            ->join('categories', 'categories_has_orders.id_category', '=', 'categories.id_category')
            ->where('id_order', $id)
            ->get()
            ->toArray();

        $themes = DB::table('categories')->get()->toArray();

        $string = '';

        foreach ($categories as $one) {
            $string .= $one->id_category . '|';
        }

        $data = [
            'order' => $order,
            'customer' => $customer,
            'proposals' => $proposals,
            'my_proposal' => $my_proposal,
            'categories' => $categories,
            'string' => $string,
            'themes' => $themes
        ];

        return view('orders.order', compact('data'));
    }

    public function select_worker(Request $req)
    {
        DB::table('orders')->where('id_order', $req->id)->update(['status' => 'in progress', 'id_worker' => $req->selected_worker]);

        $req->session()->flash('alert-success', 'Виконавця успішно вибрано!');

        return back();
    }

    public function add_review(Request $req)
    {
        if (!is_null($req->text)) {
            $worker = DB::table('orders')->where('id_order', $req->id)->get('id_worker')->first();

            $values = [
                'text' => $req->text,
                'rating' => $req->rating,
                'id_from' => Auth::user()->id,
                'id_to' => $worker->id_worker,
                'id_order' => $req->id,
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

        return back();
    }

    public function add_proposal(Request $req)
    {
        $type = $req->type;
        $time = $req->time;
        $price = is_null($req->price) ? null : $req->price . ' ' . $req->currency;

        if ($type == 'дні' && !is_null($time)) {
            switch ($time) {
                case $time == 1 :
                    $time .= ' день';
                    break;
                case $time > 1 && $time < 5 :
                    $time .= ' дні';
                    break;
                default :
                    $time .= ' днів';
            }
        }
        else if (!is_null($time)) {
            $time .= ' год.';
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

        return back();
    }

    public function delete_proposal(Request $req)
    {
        $id = explode('/', $req->location);
        $id = end($id);

        DB::table('proposals')->where([['id_order', $id], ['id_worker', Auth::user()->id]])->delete();

        $req->session()->flash('alert-success', 'Пропозицію успішно видалено!');
    }

    public function delete_order(Request $req)
    {
        DB::table('categories_has_orders')->where('id_order', $req->id)->delete();
        DB::table('proposals')->where('id_order', $req->id)->delete();
        DB::table('orders')->where('id_order', $req->id)->delete();

        $req->session()->flash('alert-success', 'Замовлення успішно видалено!');

        return redirect('/orders');
    }

    public function save_order(Request $req)
    {
        $type = $req->type;
        $time = $req->time;
        $price = is_null($req->price) ? null : $req->price . ' ' . $req->currency;

        if ($type == 'дні' && !is_null($time)) {
            switch ($req->time) {
                case $time == 1 :
                    $time .= ' день';
                    break;
                case $time > 1 && $time < 5 :
                    $time .= ' дні';
                    break;
                default :
                    $time .= ' днів';
            }
        }
        else if (!is_null($time)) {
            $time .= ' год.';
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

    public function edit_order(Request $req)
    {
        $type = $req->type;
        $time = $req->time;
        $price = is_null($req->price) ? null : $req->price . ' ' . $req->currency;

        if ($type == 'дні' && !is_null($time)) {
            switch ($req->time) {
                case $time == 1 :
                    $time .= ' день';
                    break;
                case $time > 1 && $time < 5 :
                    $time .= ' дні';
                    break;
                default :
                    $time .= ' днів';
            }
        }
        else if (!is_null($time)) {
            $time .= ' год.';
        }

        $values = [
            'title' => $req->title,
            'description' => $req->description,
            'price' => $price,
            'time' => $time,
        ];

        DB::table('orders')->where('id_order', $req->id)->update($values);

        $categories = explode('|', $req->categories);
        array_pop($categories);

        DB::table('categories_has_orders')->where('id_order', $req->id)->delete();

        foreach ($categories as $one) {
            DB::table('categories_has_orders')->insert(['id_category' => $one, 'id_order' => $req->id]);
        }

        $req->session()->flash('alert-success', 'Замовлення успішно змінено!');

        return back();
    }
}
