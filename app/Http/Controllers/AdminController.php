<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    private function create_user($info)
    {
        $id_role = DB::table('roles')->where('role_name', $info['id_role'])->get('id_role')->first();

        $user = User::create([
            'id_role' => $id_role->id_role,
            'email' => $info['email'],
            'banned' => false,
            'password' => Hash::make($info['password']),
            'id_dept' => $info['id_dept'] != '0' && $info['id_role'] == 'Замовник' ? $info['id_dept'] : null,
        ]);

        Storage::disk('public')->copy('0.png', $user['id'] . '.png');

        $values = [
            'id_user' => $user['id'],
            'name' => $info['name'],
            'surname' => $info['surname'],
            'birthday_date' => null,
            'phone_number' => null,
            'about_me' => null,
        ];

        DB::table('users_info')->insert($values);
        DB::table('contacts')->insert([
            'id_user' => $user['id'],
            'contacts' => '|'
        ]);
    }

    public function index()
    {
        $orders = DB::table('orders')
            ->where('status', '!=', 'complete')
            ->orderBy('id_order', 'desc')
            ->get()
            ->toArray();

        foreach ($orders as $one) {
            $one->price = is_null($one->price) ? '' : $one->price;
            $one->time = is_null($one->time) ? '' : $one->time;
        }

        $users = $this->getUsersInfo();

        $array = [];

        foreach ($users as $one) {
            $created_at = explode(' ', $one->created_at);
            $one->created_at = $created_at[0];

            $one->dept = DB::table('users')
                ->join('departments', 'departments.id_dept', '=', 'users.id_dept')
                ->where('id', $one->id)
                ->get()
                ->first();

            if ($one->id_role != 1) {
                array_push($array, $one);
            }
        }

        $types = DB::table('dept_type')->get();
        $dept = [];

        foreach ($types as $one) {
            $dept[$one->type_name] = DB::table('departments')->where('id_type', $one->id_type)->get()->toArray();
        }

        $categ = DB::table('categories')->get();
        $app = DB::table('applications')->get();

        foreach ($app as $one) {
            if (!is_null($one->id_dept)) {
                $depts = DB::table('departments')->where('id_dept', $one->id_dept)->get()->first();

                $one->dept = $depts;
            }
            else {
                $one->dept = '';
            }
        }

        $data = [
            'orders' => $orders,
            'users' => $array,
            'dept' => $dept,
            'categ' => $categ,
            'app' => $app,
        ];

        return view('admin.index', compact('data'));
    }

    public function ban(Request $req)
    {
        $id = $req->ban;

        DB::table('users')->where('id', $id)->update(['banned' => true]);

        $orders = DB::table('orders')->where([['id_customer', $id], ['status', '!=', 'complete']])->get('id_order');

        $ids = [];

        foreach ($orders as $one) {
            array_push($ids, $one->id_order);
        }

        DB::table('categories_has_orders')->whereIn('id_order', $ids)->delete();
        DB::table('proposals')->whereIn('id_order', $ids)->delete();
        DB::table('orders')->whereIn('id_order', $ids)->delete();
        DB::table('orders')->where([['id_worker', $id], ['status', 'in progress']])->update(['id_worker' => null]);
        DB::table('proposals')
            ->join('orders', 'proposals.id_order', '=', 'orders.id_order')
            ->where([['proposals.id_worker', $id], ['orders.status', '!=', 'complete']])
            ->delete();

        return back();
    }

    public function unban(Request $req)
    {
        DB::table('users')->where('id', $req->ban)->update(['banned' => false]);

        return back();
    }

    public function finish_order(Request $req)
    {
        DB::table('orders')->where('id_order', $req->finish)->update(['status' => 'complete']);

        return back();
    }

    public function delete_order(Request $req)
    {
        DB::table('categories_has_orders')->where('id_order', $req->delete)->delete();
        DB::table('proposals')->where('id_order', $req->delete)->delete();
        DB::table('orders')->where('id_order', $req->delete)->delete();

        return back();
    }

    public function new_user(Request $req)
    {
        $check1 = DB::table('users')->where('email', $req->email)->get();
        $check2 = strlen($req->password) >= 8;
        $check3 = strcmp($req->password, $req->password_confirmation) === 0;

        if (!count($check1) && $check2 && $check3) {

            $this->create_user($req->all());

            $req->session()->flash('alert-success', 'Користувача успішно додано!');

            return back();
        }
        else {
            $errors = [];

            if (count($check1)) {
                $errors['email'] = 'Користувач з таким email вже існує!';
            }
            if (!$check2) {
                $errors['password'] = 'Пароль має містити не менше восьми символів!';
            }
            else if (!$check3) {
                $errors['password'] = 'Паролі мають співпадати!';
            }

            return back()->withInput($req->all())->withErrors($errors);
        }
    }

    public function save_dept(Request $req)
    {
        $new = [];
        $old = [];

        foreach ($req->all() as $key => $one) {
            if ($key == '_token' || is_null($one)) {
                continue;
            }

            if (strpos($key, 'new-dept') === false) {
                $id = explode('-', $key);
                $id = $id[1];

                DB::table('departments')->where('id_dept', $id)->update(['name' => $one]);

                array_push($old, $id);
            }
            else {
                array_push($new, $one);
            }
        }

        DB::table('users')->whereIn('id_dept', $old)->update(['id_dept' => null]);
        DB::table('departments')->whereNotIn('id_dept', $old)->delete();

        foreach ($new as $one) {
            DB::table('departments')->insert(['name' => $one]);
        }

        return back();
    }

    public function save_categ(Request $req)
    {
        $new = [];
        $old = [];

        foreach ($req->all() as $key => $one) {
            if ($key == '_token' || is_null($one)) {
                continue;
            }

            if (strpos($key, 'new-categ') === false) {
                $id = explode('-', $key);
                $id = $id[1];

                DB::table('categories')->where('id_category', $id)->update(['name' => $one]);

                array_push($old, $id);
            }
            else {
                array_push($new, $one);
            }
        }

        DB::table('categories_has_orders')->whereNotIn('id_category', $old)->delete();
        DB::table('categories')->whereNotIn('id_category', $old)->delete();

        foreach ($new as $one) {
            DB::table('categories')->insert(['name' => $one]);
        }

        return back();
    }

    public function send_application(Request $req)
    {
        $check = DB::table('users')->where('email', $req->email)->count();

        if (!$check) {
            DB::table('applications')->insert($req->except('_token'));

            $req->session()->flash('alert-success', 'Вашу заяву буде розглянуто у ближайший час!');

            return redirect('/orders');
        }
        else {
            $errors['email'] = 'Користувач з таким email вже існує!';

            return back()->withInput($req->all())->withErrors($errors);
        }
    }

    public function accept_application(Request $req)
    {
        $app = DB::table('applications')->where('id_app', $req->id)->get()->first();
        $app->password = str_random(16);

        $this->create_user((array) $app);

        DB::table('applications')->where('id_app', $req->id)->delete();

        $id = DB::table('users')->where('email', $app->email)->get()->first();

        $this->send_email($id->id, 'Ваша заява була одобрена. Ваш пароль: ' . $app->password);

        $req->session()->flash('alert-success', 'Заяву успішно прийнято!');

        return back();
    }

    public function reject_application(Request $req)
    {
        DB::table('applications')->where('id_app', $req->id)->delete();

        $req->session()->flash('alert-success', 'Заяву успішно відхилено!');

        return back();
    }
}
