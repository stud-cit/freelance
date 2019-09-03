<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use App\Models\User;

class UsersController extends Controller
{
    public function customers()
    {
        $data = User::getUsersInfo('id_role', 2);

        return view('users.customers', compact('data'));
    }

    public function workers()
    {
        $data = User::getUsersInfo('id_role', 3);

        return view('users.workers', compact('data'));
    }

    public function profile()
    {
        $data = User::getUsersInfo('id_user', Auth::user()->id)->first();

        $created_at = explode(' ', $data->created_at);
        $data->created_at = $created_at[0];

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

        $proposals = DB::table('proposals')
            ->join('orders', 'orders.id_order', '=', 'proposals.id_order')
            ->where('proposals.id_worker', Auth::user()->id)
            ->get()
            ->toArray();

        $info = [
            'data' => $data,
            'reviews' => $reviews,
            'categories' => $categories,
            'skills' => $skills,
            'proposals' => $proposals,
        ];

        return view('users.profile', compact('info'));
    }

    public function save_info(Request $req)
    {
        if ($req->has('form_info')) {
            if (is_null($req->name) || is_null($req->surname)) {
                $req->session()->flash('alert-danger', 'Поля з ім\'ям та прізвищем є обовязковими!');

                return back();
            }

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
        }
        else if($req->has('form_contacts')) {
            $values = [
                'phone_number' => $req->phone_number,
                'viber' => $req->viber,
                'skype' => $req->skype
            ];

            DB::table('users_info')->where('id_user', Auth::user()->id)->update($values);

            $req->session()->flash('alert-success', 'Профіль користувача успішно оновлено!');
        }
        else if($req->has('form_password')) {
            Auth::user()->update(['password' => HASH::make($req->new_password)]);

            $req->session()->flash('alert-success', 'Пароль успішно змінено!');
        }
        else if($req->has('form_skills')) {
            DB::table('user_has_skills')->where('id', Auth::user()->id)->delete();

            $categories = explode('|', $req->categories);
            array_pop($categories);

            foreach ($categories as $one) {
                DB::table('user_has_skills')->insert(['id_category' => $one, 'id' => Auth::user()->id]);
            }
        }

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
