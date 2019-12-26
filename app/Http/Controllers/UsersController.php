<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use App\Models\User;

class UsersController extends Controller
{
    public function workers()
    {
        $data = $this->getUsersInfo('id_role', 3, 10);

        foreach ($data as $worker) {
            $created_at = explode(' ', $worker->created_at);
            $worker->created_at = $created_at[0];

            $worker->categories = DB::table('user_has_skills')
                                    ->join('categories', 'categories.id_category', '=', 'user_has_skills.id_category')
                                    ->where('id', $worker->id_user)
                                    ->get('name')
                                    ->toArray();
        }

        return view('users.workers', compact('data'));
    }

    public function profile()
    {
        if (Auth::check()) {
            return redirect('profile/' . Auth::id());
        }
        else {
            return redirect('orders');
        }
    }

    public function save_skills(Request $req)
    {
        DB::table('user_has_skills')->where('id', Auth::id())->delete();

        $categories = explode('|', $req->categories);
        array_pop($categories);

        foreach ($categories as $one) {
            DB::table('user_has_skills')->insert(['id_category' => $one, 'id' => Auth::id()]);
        }

        $req->session()->flash('alert-success', 'Навички користувача успішно оновлено!');

        return back();
    }

    public function password_change()
    {
        return view('users.password_change');
    }

    public function change_pass(Request $req)
    {
        $check1 = HASH::check($req->old_password, Auth::user()->password);
        $check2 = strlen($req->new_password) >= 8;
        $check3 = strcmp($req->new_password, $req->new_password_confirmation) === 0;

        if ($check1 && $check2 && $check3) {
            Auth::user()->update(['password' => HASH::make($req->new_password)]);

            $req->session()->flash('alert-success', 'Пароль успішно змінено!');

            return redirect('/profile/' . Auth::id());
        }
        else {
            $errors = [];

            if (!$check1) {
                $errors['old_password'] = 'Невірний старий пароль!';
            }
            if (!$check2) {
                $errors['new_password'] = 'Пароль має містити не менше восьми символів!';
            }
            else if (!$check3) {
                $errors['new_password'] = 'Паролі мають співпадати!';
            }

            return back()->withInput($req->all())->withErrors($errors);
        }
    }

    public function save_review(Request $req)
    {
        $customer = DB::table('orders')->where('id_order', $req->id)->get(['id_customer', 'id_worker'])->first();

        $values = [
            'text' => $req->text,
            'rating' => $req->rating,
            'id_from' => Auth::id(),
            'id_to' => $customer->id_customer == Auth::id() ? $customer->id_worker : $customer->id_customer,
            'id_order' => $req->id,
            'created_at' => Carbon::now(),
        ];

        DB::table('reviews')->insert($values);

        $req->session()->flash('alert-success', 'Відгук успішно залишено!');

        return back();
    }

    public function save_info(Request $req)
    {
        if (!is_null($req->avatar)) {
            $avatar = $req->avatar;
            $extension = $avatar->getClientOriginalExtension();

            if ($extension != 'png' && $extension != 'jpg') {
                $req->session()->flash('alert-danger', 'Аватар має бути у форматі png або jpg!');

                return back();
            }

            $path = Auth::id() . '.' . $extension;

            if ($extension == 'png') {
                $del_path = Auth::id() . '.jpg';
            } else {
                $del_path = Auth::id() . '.png';
            }

            Storage::disk('public')->delete($del_path);
            Storage::disk('public')->put($path, File::get($req->file('avatar')));
        }

        $values = [
            'name' => $req->name,
            'surname' => $req->surname,
            'birthday_date' => $req->birthday_date,
            'about_me' => $req->about_me,
        ];

        DB::table('users_info')->where('id_user', Auth::id())->update($values);

        $req->session()->flash('alert-success', 'Профіль користувача успішно оновлено!');

        return redirect('/profile');
    }

    public function user($id = null)
    {
        $flag = is_null($id);
        $id = $id ?? Auth::id();
        $id_user = DB::table('users')->where('id', $id)->get('id')->first();

        if (!$id_user) {
            abort(404);
        }

        $data = $this->getUsersInfo('id_user', $id)->first();

        $created_at = explode(' ', $data->created_at);
        $data->created_at = $created_at[0];

        $data->categories = DB::table('user_has_skills')
            ->join('categories', 'categories.id_category', '=', 'user_has_skills.id_category')
            ->where('id', $data->id_user)
            ->get('name')
            ->toArray();

        $reviews = DB::table('reviews')
            ->join('users_info', 'users_info.id_user', '=', 'reviews.id_from')
            ->where('id_to', $id)
            ->paginate(5);

        foreach ($reviews as $review) {
            if (Storage::disk('public')->has($review->id_user . '.png')) {
                $review->avatar = '/img/' . $review->id_user . '.png';
            }
            else {
                $review->avatar = '/img/' . $review->id_user . '.jpg';
            }

            $review->avatar .= '?t=' . Carbon::now();
        }

        $dept = DB::table('users')
            ->join('departments', 'departments.id_dept', '=', 'users.id_dept')
            ->where('id', $id)
            ->get()
            ->first();

        if ($data->id_role == 2) {
            $active = DB::table('orders')->where([['id_customer', $id], ['status', 'new']])->count();
            $progress = DB::table('orders')->where([['id_customer', $id], ['status', 'in progress']])->count();
            $complete = DB::table('orders')->where([['id_customer', $id], ['status', 'complete']])->count();
        }
        else if ($data->id_role == 3) {
            $active = DB::table('orders')
                        ->join('proposals', 'orders.id_order', '=', 'proposals.id_order')
                        ->where([['proposals.id_worker', $id], ['orders.status', 'new'], ['blocked', false]])->count();
            $progress = DB::table('orders')->where([['id_worker', $id], ['status', 'in progress']])->count();
            $complete = DB::table('orders')->where([['id_worker', $id], ['status', 'complete']])->count();
        }
        else {
            $active = 0;
            $progress = 0;
            $complete = 0;
        }

        $orders = DB::table('orders')->where('id_customer', $data->id)->get()->toArray();

        foreach ($orders as $one) {
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
        }

        $proposals = DB::table('orders')
            ->join('proposals', 'orders.id_order', '=', 'proposals.id_order')
            ->join('users_info', 'users_info.id_user', '=', 'orders.id_customer')
            ->where([['proposals.id_worker', $id], ['orders.status', 'new']])
            ->orWhere([['orders.id_worker', $id], ['orders.status', '!=', 'new']])
            ->get()
            ->toArray();

        foreach ($proposals as $one) {
            $review = DB::table('reviews')->where([['id_order', $one->id_order], ['id_from', $id]])->get()->first();

            $one->review = is_null($review) ? 1 : 0;
        }

        foreach ($orders as $one) {
            $review = DB::table('reviews')->where([['id_order', $one->id_order], ['id_from', $id]])->get()->first();

            $one->worker = DB::table('orders')
                ->join('users_info', 'orders.id_worker', '=', 'users_info.id_user')
                ->where('id_user', $one->id_worker)
                ->get()
                ->first();

            $one->review = is_null($review) ? 1 : 0;
        }

        $types = DB::table('dept_type')->get();
        $all_dept = [];

        foreach ($types as $one) {
            $all_dept[$one->type_name] = DB::table('departments')->where('id_type', $one->id_type)->get()->toArray();
        }

        $id_change = [];

        if (Auth::user()->id_role == 2) {
            foreach ($orders as $order) {
                $temp = DB::table('proposals')->where([['id_order', $order->id_order], ['checked', false]])->count();

                if ($temp) {
                    array_push($id_change, $order->id_order);
                }
            }
        }
        else if (Auth::check() && Auth::user()->id_role == 3) {
            $temp = DB::table('orders')->where([['id_worker', Auth::id()], ['checked', false]])->get();

            foreach ($temp as $one) {
                array_push($id_change, $one->id_order);
            }
        }

        $info = [
            'data' => $data,
            'reviews' => $reviews,
            'dept' => $dept,
            'active' => $active,
            'progress' => $progress,
            'complete' => $complete,
            'orders' => $orders,
            'proposals' => $proposals,
            'all_dept' => $all_dept,
            'id_change' => $id_change
        ];

        if ($flag && Auth::user()->id_role != 1) {
            $view = Auth::user()->id_role == 2 ? 'users.my_orders' : 'users.my_prop';
        }
        else if (!$flag){
            $view = 'users.user';
        }
        else {
            return redirect('/admin');
        }

        return view($view, compact('info'));
    }

    public function settings()
    {
        if (Auth::user()->id_role == 1) {
            return redirect('/admin');
        }

        $types = DB::table('dept_type')->get();
        $dept = [];

        foreach ($types as $one) {
            $dept[$one->type_name] = DB::table('departments')->where('id_type', $one->id_type)->get()->toArray();
        }

        $categories = DB::table('categories')->get();
        $skills = DB::table('user_has_skills')->where('id', Auth::id())->get();
        $string = '';

        foreach ($skills as $one) {
            $string .= $one->id_category . '|';
        }

        $my_dept = DB::table('users')->where('id', Auth::id())->get()->first();
        $my_dept = $my_dept->id_dept;

        $data = [
            'dept' => $dept,
            'categories' => $categories,
            'string' => $string,
            'types' => $types,
            'my_dept' => $my_dept,
        ];

        return view('users.settings', compact('data'));
    }

    public function save_settings(Request $req)
    {
        DB::table('users')->where('id', Auth::id())->update(['id_dept' => $req->id_dept == 0 ? null : $req->id_dept]);

        $req->session()->flash('alert-success', 'Кафедру користувача успішно оновлено!');

        return back();
    }
}
