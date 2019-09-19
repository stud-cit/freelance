<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use DB;
use Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use App\Models\User;

class UsersController extends Controller
{
    public function workers()
    {
        $data = User::getUsersInfo('id_role', 3);

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
        $data = User::getUsersInfo('id_user', Auth::user()->id)->first();

        $created_at = explode(' ', $data->created_at);
        $data->created_at = $created_at[0];

        $data->categories = DB::table('user_has_skills')
            ->join('categories', 'categories.id_category', '=', 'user_has_skills.id_category')
            ->where('id', $data->id_user)
            ->get('name')
            ->toArray();

        $reviews = DB::table('reviews')
            ->join('users_info', 'users_info.id_user', '=', 'reviews.id_from')
            ->where('id_to', Auth::user()->id)
            ->get()
            ->toArray();

        foreach ($reviews as $review) {
            if (Storage::disk('public')->has($review->id_user . '.png')) {
                $review->avatar = '/img/' . $review->id_user . '.png';
            }
            else {
                $review->avatar = '/img/' . $review->id_user . '.jpg';
            }
        }

        $categories = DB::table('categories')->get()->toArray();

        $temp = DB::table('user_has_skills')->where('id', Auth::user()->id)->get()->toArray();
        $skills = '';

        foreach ($temp as $one) {
            $skills .= $one->id_category . '|';
        }

        $orders = DB::table('orders')->where('id_customer', Auth::user()->id)->get()->toArray();

        $proposals = DB::table('orders')
            ->join('proposals', 'orders.id_order', '=', 'proposals.id_order')
            ->join('users_info', 'users_info.id_user', '=', 'orders.id_customer')
            ->where('proposals.id_worker', Auth::user()->id)
            ->get()
            ->toArray();

        foreach ($proposals as $one) {
            $review = DB::table('reviews')->where([['id_order', $one->id_order], ['id_from', Auth::user()->id]])->get()->first();

            $one->review = is_null($review) ? 1 : 0;
        }

        foreach ($orders as $one) {
            $review = DB::table('reviews')->where([['id_order', $one->id_order], ['id_from', Auth::user()->id]])->get()->first();

            $one->review = is_null($review) ? 1 : 0;
        }

        $info = [
            'data' => $data,
            'reviews' => $reviews,
            'categories' => $categories,
            'skills' => $skills,
            'proposals' => $proposals,
            'orders' => $orders,
        ];

        return view('users.profile', compact('info'));
    }

    public function save_contacts(Request $req)
    {
        $values = [
            'phone_number' => $req->phone_number,
            'viber' => $req->viber,
            'skype' => $req->skype
        ];

        DB::table('users_info')->where('id_user', Auth::user()->id)->update($values);

        $req->session()->flash('alert-success', 'Контакти користувача успішно оновлено!');

        return back();
    }

    public function save_skills(Request $req)
    {
        DB::table('user_has_skills')->where('id', Auth::user()->id)->delete();

        $categories = explode('|', $req->categories);
        array_pop($categories);

        foreach ($categories as $one) {
            DB::table('user_has_skills')->insert(['id_category' => $one, 'id' => Auth::user()->id]);
        }

        $req->session()->flash('alert-success', 'Навички користувача успішно оновлено!');

        return back();
    }

    public function change_pass(Request $req)
    {
        Auth::user()->update(['password' => HASH::make($req->new_password)]);

        $req->session()->flash('alert-success', 'Пароль успішно змінено!');

        return back();
    }

    public function save_review(Request $req)
    {
        $customer = DB::table('orders')->where('id_order', $req->id)->get(['id_customer', 'id_worker'])->first();

        $values = [
            'text' => $req->text,
            'rating' => $req->rating,
            'id_from' => Auth::user()->id,
            'id_to' => $customer->id_customer == Auth::user()->id ? $customer->id_worker : $customer->id_customer,
            'id_order' => $req->id,
            'created_at' => Carbon::now(),
        ];

        DB::table('reviews')->insert($values);

        $req->session()->flash('alert-success', 'Відгук успішно залишено!');

        return back();
    }

    public function save_about_me(Request $req)
    {
        DB::table('users_info')->where('id_user', Auth::user()->id)->update(['about_me' => $req->about_me]);

        $req->session()->flash('alert-success', 'Додаткову інформацію про користувача успішно оновлено!');

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

            $path = Auth::user()->id . '.' . $extension;

            if ($extension == 'png') {
                $del_path = Auth::user()->id . '.jpg';
            } else {
                $del_path = Auth::user()->id . '.png';
            }

            Storage::disk('public')->delete($del_path);
            Storage::disk('public')->put($path, File::get($req->file('avatar')));
        }

        $values = [
            'name' => $req->name,
            'surname' => $req->surname,
            'patronymic' => $req->patronymic,
            'birthday_date' => $req->birthday_date,
            'country' => $req->country,
            'city' => $req->city
        ];

        DB::table('users_info')->where('id_user', Auth::user()->id)->update($values);

        $req->session()->flash('alert-success', 'Профіль користувача успішно оновлено!');

        return back();
    }

    public function user($id)
    {
        $id_user = DB::table('users')->where('id', $id)->get('id')->first();

        if (!$id_user) {
            abort(404);
        }

        $data = User::getUsersInfo('id_user', $id)->first();

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
            ->get()
            ->toArray();

        foreach ($reviews as $review) {
            if (Storage::disk('public')->has($review->id_user . '.png')) {
                $review->avatar = '/img/' . $review->id_user . '.png';
            }
            else {
                $review->avatar = '/img/' . $review->id_user . '.jpg';
            }
        }

        return view('users.user', compact('data'), compact('reviews'));
    }
}
