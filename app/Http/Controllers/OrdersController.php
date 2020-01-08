<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use ZipArchive;

class OrdersController extends Controller
{
    private $eq, $filtered;

    function get_currency()
    {
        $fp = file_get_contents('currency.json');
        $response_object = json_decode($fp, true);
        $this->eq = $response_object['rates']['UAH'];
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
            $one->price = $one->price ?? '';
            $one->time = $one->time ?? '';

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
            $array = array_slice($array, count($array) - (count($array) % 10 ? count($array) % 10 : 10));
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

        $types = DB::table('dept_type')->get();
        $dept = [];

        foreach ($types as $one) {
            $dept[$one->type_name] = DB::table('departments')->where('id_type', $one->id_type)->get()->toArray();
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

        $array = $this->get_orders($values);
        $page = $this->filtered > ($req->page - 1) * 10 ? $req->page : $this->filtered % 10 + 1;

        $data = [
            'array' => $array,
            'count' => $this->filtered,
            'page' => $page
        ];

        return view('orders.filter', compact('data'));
    }

    public function order($id)
    {
        $order = DB::table('orders')->where('id_order', $id)->get()->first();
        $customer = $this->getUsersInfo('id', $order->id_customer)->first();

        if (Auth::check() && $order->id_customer == Auth::id()) {
            DB::table('proposals')->where('id_order', $id)->update(['checked' => true]);
        }

        if (Auth::check() && $order->id_worker == Auth::id()) {
            DB::table('orders')->where('id_order', $id)->update(['checked', true]);
        }

        $my_proposal = DB::table('proposals')
            ->join('users_info', 'proposals.id_worker', '=', 'users_info.id_user')
            ->where([['id_order', $id], ['id_worker', Auth::id()]])
            ->get(['id_user', 'text', 'price', 'time', 'name', 'surname', 'proposals.created_at', 'blocked'])
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

        if (Auth::check() && Auth::user()->id_role == 2) {
            $proposals = DB::table('proposals')
                ->join('users_info', 'proposals.id_worker', '=', 'users_info.id_user')
                ->where([['id_order', $id], ['blocked', false]])
                ->paginate(5);
        }
        else {
            $proposals = DB::table('proposals')
                ->join('users_info', 'proposals.id_worker', '=', 'users_info.id_user')
                ->where([['id_order', $id], ['blocked', false], ['id_worker', Auth::id()]])
                ->paginate(5);
        }

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
            DB::table('orders')->where('id_order', $req->id)->update(['status' => 'in progress', 'id_worker' => $req->selected_worker, 'updated_at' => Carbon::now()]);

            $order = DB::table('orders')->where('id_order', $req->id)->first();
            $message = 'Вашу пропозицію до замовлення "' . $order->title . '" було прийнято';

            $this->send_email($req->selected_worker, $message);

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

        Storage::disk('orders')->delete($req->id . '.zip');

        $order = DB::table('orders')->where('id_order', $req->id)->get()->first();

        $this->send_email($order->id_worker, 'Замовлення "' . $order->title . '" завершено');

        $req->session()->flash('alert-success', 'Замовлення успішно завершено!');

        return redirect('/orders');
    }

    public function change_worker(Request $req)
    {
        $worker = DB::table('orders')->where('id_order', $req->id)->get()->first();
        $id = $worker->id_worker;

        if (!is_null($req->text)) {
            $values = [
                'text' => $req->text,
                'rating' => $req->rating,
                'id_from' => Auth::id(),
                'id_to' => $id,
                'id_order' => $req->id,
                'created_at' => Carbon::now(),
            ];

            DB::table('proposals')->where([['id_order', $req->id], ['id_worker', $id]])->update(['blocked' => true]);
            DB::table('reviews')->insert($values);
        }

        DB::table('orders')->where('id_order', $req->id)->update(['status' => 'new', 'id_worker' => null, 'checked' => false]);

        $this->send_email($id, 'Ви більше не виконуєте замовлення "' . $worker->title . '"');

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
                'checked' => false
            ];

            $check = DB::table('proposals')->where([['id_order', $req->id], ['id_worker', Auth::id()]])->get('id_proposal')->first();

            if (is_null($check)) {
                DB::table('proposals')->insert($values);

                $order = DB::table('orders')->where('id_order', $req->id)->get()->first();
                $this->send_email($order->id_customer, 'До вашого замовлення "' . $order->title . '" була залишена пропозиція');

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
        Storage::disk('orders')->delete($req->id . '.zip');

        DB::table('categories_has_orders')->where('id_order', $req->id)->delete();
        DB::table('proposals')->where('id_order', $req->id)->delete();
        DB::table('orders')->where('id_order', $req->id)->delete();

        $req->session()->flash('alert-success', 'Замовлення успішно видалено!');

        return back();
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
            'checked' => false,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];

        DB::table('orders')->insert($values);

        $id = DB::table('orders')->where('id_customer', Auth::id())->orderBy('id_order', 'desc')->get(['id_order'])->first();

        if ($req->file() != []) {
            $zip = new ZipArchive();
            $path = storage_path('orders/') . $id->id_order . ".zip";

            $zip->open($path,  ZipArchive::CREATE);

            foreach ($req->file()['files'] as $file) {
                Storage::disk('orders')->put($id->id_order . $file->getClientOriginalName(), File::get($file));

                $zip->addFile(storage_path('orders/' . $id->id_order . $file->getClientOriginalName()), $file->getClientOriginalName());
            }

            $zip->close();

            foreach ($req->file()['files'] as $file) {
                Storage::disk('orders')->delete($id->id_order . $file->getClientOriginalName());
            }
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

        if ($req->file() != []) {
            Storage::disk('orders')->delete($req->id . ".zip");

            $zip = new ZipArchive();
            $path = storage_path('orders/') . $req->id . ".zip";

            $zip->open($path,  ZipArchive::CREATE);

            foreach ($req->file()['files'] as $file) {
                Storage::disk('orders')->put($req->id . $file->getClientOriginalName(), File::get($file));

                $zip->addFile(storage_path('orders/' . $req->id . $file->getClientOriginalName()), $file->getClientOriginalName());
            }

            $zip->close();

            foreach ($req->file()['files'] as $file) {
                Storage::disk('orders')->delete($req->id . $file->getClientOriginalName());
            }
        }

        $values = [
            'title' => $req->title,
            'description' => $req->description,
            'files' => $req->file() != [],
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

    public function get_files(Request $req)
    {
        return Storage::disk('orders')->download($req->id . '.zip', $req->name);
    }

    public function delete_file(Request $req)
    {
        DB::table('orders')->where('id_order', $req->id)->update(['files' => 0]);

        Storage::disk('orders')->delete($req->id . '.zip');

        $req->session()->flash('alert-success', 'Прікріплені файли успішно видалено!');

        return back();
    }
}
