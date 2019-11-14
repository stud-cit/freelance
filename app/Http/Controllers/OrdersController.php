<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use DB;
use Auth;
use App\Models\User;

class OrdersController extends Controller
{
    private $eq, $filtered;

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

        if ($first_price == $second_price) {
            return 0;
        }

        return $first_price > $second_price ? 1 : -1;
    }

    public function get_orders($filter)
    {
        $data = DB::table('orders')
            ->where('status', 'new')
            ->orderBy($filter['what'], $filter['how'])
            ->get()
            ->toArray();

        if ($filter['what'] == 'price') {
            $this->get_currency();
            usort($data, array($this, "cmp"));

            if ($filter['how'] == 'desc') {
                $data = array_reverse($data);
            }
        }

        $array = [];

        foreach ($data as $one) {
            $one->description = mb_strlen($one->description) > 200 ? mb_substr($one->description, 0, 200) . '...' : $one->description;
            $one->price = is_null($one->price) ? '' : $one->price;
            $one->time = is_null($one->time) ? '' : $one->time;

            $one->categories = DB::table('categories_has_orders')
                ->join('categories', 'categories.id_category', '=', 'categories_has_orders.id_category')
                ->where('id_order', $one->id_order)
                ->get()
                ->toArray();

            $one->dept = DB::table('users')
                ->join('orders', 'users.id', '=', 'orders.id_customer')
                ->join('departments', 'departments.id_dept', '=', 'users.id_dept')
                ->where('id_order', $one->id_order)
                ->get()
                ->first();


            if ($filter['dept'] == '0' || (!is_null($one->dept) && $filter['dept'] == $one->dept->id_dept)) {
                if ($filter['category'] != '0' && (is_null($filter['filter']) || strpos(strtolower($one->title), strtolower($filter['filter'])) !== false)) {
                    foreach ($one->categories as $category) {
                        if ($category->id_category == $filter['category']) {
                            array_push($array, $one);
                            break;
                        }
                    }
                } else if (is_null($filter['filter']) || strpos(strtolower($one->title), strtolower($filter['filter'])) !== false) {
                    array_push($array, $one);
                }
            }
        }

        $this->filtered = count($array);

        if (count($array) > $filter['page'] * 10) {
            $array = array_slice($array, --$filter['page'] * 10, 10);
        }
        else if (count($array) > --$filter['page'] * 10) {
            $array = array_slice($array, $filter['page'] * 10);
        }
        else {
            $array = array_slice($array, count($array) - count($array) % 10 ? count($array) % 10 : 10);
        }

        return $array;
    }

    public function index()
    {
        $values = [
            'what' => 'id_order',
            'how' => 'desc',
            'filter' => null,
            'category' => '0',
            'page' => 1,
            'dept' => '0',
        ];

        $data = $this->get_orders($values);

        $categories = DB::table('categories')->orderBy('name')->get()->toArray();

        foreach ($categories as $one) {
            $one->count = DB::table('categories_has_orders')
                ->join('orders', 'categories_has_orders.id_order', '=', 'orders.id_order')
                ->where([['id_category', $one->id_category], ['status', 'new']])
                ->count();
        }

        $dept = DB::table('departments')->get();

        foreach ($dept as $one) {
            $one->count = DB::table('users')
                ->join('orders', 'users.id', '=', 'orders.id_customer')
                ->join('departments', 'departments.id_dept', '=', 'users.id_dept')
                ->where([['departments.name', $one->name], ['status', 'new']])
                ->count();
        }

        $count = DB::table('orders')->where('status', 'new')->count();

        $info = [
            'data' => $data,
            'categories' => $categories,
            'count' => $count,
            'dept' => $dept,
        ];

        return view('orders.index', compact('info'));
    }

    public function filter(Request $req)
    {
        $values = [
            'what' => $req->what,
            'how' => $req->how,
            'filter' => $req->filter,
            'category' => $req->category,
            'page' => $req->page,
            'dept' => $req->dept,
        ];

        $data = [
            'array' => $this->get_orders($values),
            'count' => $this->filtered,
        ];

        return $data;
    }

    public function order($id)
    {
        $order = DB::table('orders')->where('id_order', $id)->get()->first();
        $customer = User::getUsersInfo('id', $order->id_customer)->first();

        $my_proposal = DB::table('proposals')
            ->join('users_info', 'proposals.id_worker', '=', 'users_info.id_user')
            ->where([['id_order', $id], ['id_worker', Auth::id()]])
            ->get(['id_user', 'text', 'price', 'time', 'name', 'surname', 'patronymic', 'proposals.created_at', 'blocked'])
            ->first();

        if (!is_null($my_proposal)) {
            if (!is_null($my_proposal->price)) {
                $temp = explode(' ', $my_proposal->price);
                $my_proposal->price = $temp[0];
                $my_proposal->currency = $temp[1];
            } else {
                $my_proposal->currency = '';
            }

            if (!is_null($my_proposal->time)) {
                $temp = explode(' ', $my_proposal->time);
                $my_proposal->time = $temp[0];
                $my_proposal->type = $temp[1];
            } else {
                $my_proposal->type = '';
            }
        }

        $proposals = DB::table('proposals')
            ->join('users_info', 'proposals.id_worker', '=', 'users_info.id_user')
            ->where([['id_order', $id], ['blocked', false]])
            ->paginate(5);

        foreach ($proposals as $one) {
            if (Storage::disk('public')->has($one->id_user . '.png')) {
                $one->avatar = '/img/' . $one->id_user . '.png';
            } else {
                $one->avatar = '/img/' . $one->id_user . '.jpg';
            }

            $one->avatar .= '?t=' . Carbon::now();
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

        $dept = DB::table('users')
            ->join('orders', 'users.id', '=', 'orders.id_customer')
            ->join('departments', 'departments.id_dept', '=', 'users.id_dept')
            ->where('id_order', $id)
            ->get()
            ->first();

        $data = [
            'order' => $order,
            'customer' => $customer,
            'proposals' => $proposals,
            'my_proposal' => $my_proposal,
            'categories' => $categories,
            'string' => $string,
            'themes' => $themes,
            'dept' => $dept,
        ];

        return view('orders.order', compact('data'));
    }

    public function select_worker(Request $req)
    {
        $check = DB::table('proposals')->where([['id_order', $req->id], ['id_worker', $req->selected_worker]])->get();

        if (!is_null($check)) {
            DB::table('orders')->where('id_order', $req->id)->update(['status' => 'in progress', 'id_worker' => $req->selected_worker]);

            $req->session()->flash('alert-success', 'Виконавця успішно вибрано!');
        }
        else {
            $req->session()->flash('alert-danger', 'Цей виконавець видалив свою пропозицію!');
        }

        return back();
    }

    public function finish_order(Request $req)
    {
        DB::table('orders')->where('id_order', $req->id)->update(['status' => 'complete']);

        $req->session()->flash('alert-success', 'Замовлення успішно завершено!');

        return redirect('/orders');
    }

    public function change_worker(Request $req)
    {
        if (!is_null($req->text)) {
            $worker = DB::table('orders')->where('id_order', $req->id)->get('id_worker')->first();
            $worker = $worker->id_worker;

            $values = [
                'text' => $req->text,
                'rating' => $req->rating,
                'id_from' => Auth::id(),
                'id_to' => $worker,
                'id_order' => $req->id,
                'created_at' => Carbon::now(),
            ];

            DB::table('proposals')->where([['id_order', $req->id], ['id_worker', $worker]])->update(['blocked' => true]);
            DB::table('reviews')->insert($values);
        }

        DB::table('orders')->where('id_order', $req->id)->update(['status' => 'new', 'id_worker' => null]);

        $req->session()->flash('alert-success', 'Виконавця успішно видалено!');

        return back();
    }

    public function add_proposal(Request $req)
    {
        $check1 = DB::table('orders')->where('id_order', $req->id)->get();
        $check2 = DB::table('orders')->where([['id_order', $req->id], ['id_worker', null]])->get();

        if (!is_null($check1) && !is_null($check2)) {
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
            } else if (!is_null($time)) {
                $time .= ' год.';
            }

            $values = [
                'text' => $req->text,
                'price' => $price,
                'time' => $time,
                'id_order' => $req->id,
                'id_worker' => Auth::id(),
                'blocked' => false,
                'created_at' => Carbon::now(),
            ];

            $check = DB::table('proposals')->where([['id_order', $req->id], ['id_worker', Auth::id()]])->get('id_proposal')->first();

            if (is_null($check)) {
                DB::table('proposals')->insert($values);

                $req->session()->flash('alert-success', 'Пропозицію успішно додано!');
            } else {
                DB::table('proposals')->where([['id_order', $req->id], ['id_worker', Auth::id()]])->update($values);

                $req->session()->flash('alert-success', 'Пропозицію успішно змінено!');
            }

            return back();
        }
        else if (!is_null($check1)) {
            $req->session()->flash('alert-danger', 'У цього замовлення вже є виконавець!');

            return back();
        }
        else {
            $req->session()->flash('alert-danger', 'Цього замолення більше не існує!');

            return redirect('/orders');
        }
    }

    public function delete_proposal(Request $req)
    {
        $check1 = DB::table('orders')->where('id_order', $req->id)->get();
        $check2 = DB::table('orders')->where([['id_order', $req->id], ['id_worker', null]])->get();

        if (!is_null($check1) && !is_null($check2)) {
            $id = explode('/', $req->location);
            $id = end($id);

            DB::table('proposals')->where([['id_order', $id], ['id_worker', Auth::id()]])->delete();

            $req->session()->flash('alert-success', 'Пропозицію успішно видалено!');

            return back();
        }
        else if (!is_null($check1)) {
            $req->session()->flash('alert-danger', 'Ви не можете видалити пропозицію у виконуємого замовлення!');

            return back();
        }
        else {
            $req->session()->flash('alert-danger', 'Цього замолення більше не існує!');

            return redirect('/orders');
        }
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
            'files' => $req->file() != [],
            'id_customer' => Auth::id(),
            'id_worker' => null,
            'created_at' => Carbon::now(),
        ];

        DB::table('orders')->insert($values);

        $id = DB::table('orders')->where('id_customer', Auth::id())->orderBy('id_order', 'desc')->get(['id_order'])->first();

        foreach ($req->file()['files'] as $file) {
            $path = $id->id_order . '/' . $file->getClientOriginalName();

            Storage::disk('orders')->put($path, File::get($file));
        }

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
