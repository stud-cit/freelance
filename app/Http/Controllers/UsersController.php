<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class UsersController extends Controller
{
    public function customers()
    {
        $data = DB::table('users')
            ->join('users_info', 'users.id', '=', 'users_info.id_user')
            ->where('id_role', 2)
            ->get(['name', 'surname', 'patronymic', 'phone_number', 'about_me', 'email', 'skype', 'viber']);

        return view('users.customers', compact('data'));
    }

    public function workers()
    {
        $data = DB::table('users')
            ->join('users_info', 'users.id', '=', 'users_info.id_user')
            ->where('id_role', 3)
            ->get(['name', 'surname', 'patronymic', 'phone_number', 'about_me', 'email', 'skype', 'viber']);

        return view('users.workers', compact('data'));
    }

    public function profile()
    {
        $data = DB::table('users_info')
            ->join('users', 'users.id', '=', 'users_info.id_user')
            ->where('id_user', Auth::user()->id)
            ->get(['name', 'surname', 'patronymic', 'phone_number', 'about_me', 'email', 'skype', 'viber', 'birthday_date', 'id_role', 'created_at'])
            ->first();

        $created_at = explode(' ', $data->created_at);
        $data->created_at = $created_at[0];

        return view('users.profile', compact('data'));
    }

    public function save_info(Request $req)
    {
        if ($req->has('form2')) {
            if (is_null($req->name) || is_null($req->surname)) {
                $req->session()->flash('alert-danger', 'Поля з ім\'ям та прізвищем є обовязковими!');

                return back();
            }

            $values = [
                'name' => $req->name,
                'surname' => $req->surname,
                'patronymic' => $req->patronymic,
                'birthday_date' => $req->birthday_date,
                'phone_number' => $req->phone_number,
                'viber' => $req->viber,
                'skype' => $req->skype,
                'about_me' => $req->about_me,
            ];

            DB::table('users_info')->where('id_user', Auth::user()->id)->update($values);

            $req->session()->flash('alert-success', 'Профіль користувача успішно оновлено!');
        }
        else if($req->has('form1')) {
            if (is_null($req->avatar)) {
                $req->session()->flash('alert-danger', 'Виберіть новий аватар!');

                return back();
            }

            $avatar = $req->avatar;
            $extension = $avatar->getClientOriginalExtension();

            if ($extension != 'png' && $extension != 'jpg') {
                $req->session()->flash('alert-danger', 'Аватар має бути у форматі png або jpg!');

                return back();
            }

            $path = Auth::user()->id . '.' . $extension;

            if ($extension = 'png') {
                $del_path = Auth::user()->id . '.jpg';
            }
            else {
                $del_path = Auth::user()->id . '.png';
            }

            Storage::disk('public')->delete($del_path);
            Storage::disk('public')->put($path, File::get($req->file('avatar')));

            $req->session()->flash('alert-success', 'Аватар користувача успішно оновлено!');
        }

        return back();
    }

    public function user($id)
    {
        $id_user = DB::table('users')->where('id', $id)->get('id')->first();

        if (!$id_user) {
            abort(404);
        }

        $data = DB::table('users_info')
            ->join('users', 'users.id', '=', 'users_info.id_user')
            ->where('id_user', $id)
            ->get(['name', 'surname', 'patronymic', 'phone_number', 'about_me', 'email', 'skype', 'viber', 'birthday_date', 'id_role', 'created_at'])
            ->first();

        $created_at = explode(' ', $data->created_at);
        $data->created_at = $created_at[0];

        return view('users.user', compact('data'));
    }
}
