<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

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

        $dept = DB::table('departments')->get();
        $categ = DB::table('categories')->get();

        $data = [
            'orders' => $orders,
            'users' => $array,
            'dept' => $dept,
            'categ' => $categ,
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
            ->where([['proposals.id_worker', $id], ['status', '!=', 'complete']])
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
            $id_role = DB::table('roles')->where('role_name', $req->id_role)->get('id_role')->first();

            $user = User::create([
                'id_role' => $id_role->id_role,
                'email' => $req->email,
                'banned' => false,
                'password' => Hash::make($req->password),
                'id_dept' => $req->id_dept != '0' && $req->id_role == 'Замовник' ? $req->id_dept : null,
            ]);

            Storage::disk('public')->copy('0.png', $user['id'] . '.png');

            $values = [
                'id_user' => $user['id'],
                'name' => $req->name,
                'surname' => $req->surname,
                'patronymic' => null,
                'birthday_date' => null,
                'phone_number' => null,
                'viber' => null,
                'skype' => null,
                'about_me' => null,
                'country' => null,
                'city' => null
            ];

            DB::table('users_info')->insert($values);
            DB::table('contacts')->insert([
                'id_user' => $user['id'],
                'contacts' => '|'
            ]);

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
}
