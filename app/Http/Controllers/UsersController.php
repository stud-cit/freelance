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
            ->get(['name', 'surname', 'patronymic', 'phone_number', 'avatar', 'about_me', 'email', 'skype', 'viber']);

        return view('users.customers', compact('data'));
    }

    public function workers()
    {
        $data = DB::table('users')
            ->join('users_info', 'users.id', '=', 'users_info.id_user')
            ->where('id_role', 3)
            ->get(['name', 'surname', 'patronymic', 'phone_number', 'avatar', 'about_me', 'email', 'skype', 'viber']);

        return view('users.workers', compact('data'));
    }

    public function profile()
    {
        $data = DB::table('users_info')->where('id_user', Auth::user()->id)->get()->first();

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

            $prev_path = DB::table('users_info')->where('id_user', Auth::user()->id)->get(['avatar'])->first();

            $avatar = $req->avatar;
            $count = count(glob('img/' . "*")) + 1;
            $path = $count . '.' . $avatar->getClientOriginalExtension();

            if ($prev_path->avatar != '/img/1.png') {
                $prev_path = explode('/', $prev_path->avatar);
                $path = $prev_path[2];
            }

            Storage::disk('public')->put($path, File::get($req->file('avatar')));

            DB::table('users_info')->where('id_user', Auth::user()->id)->update(['avatar' => '/img/' . $path]);

            $req->session()->flash('alert-success', 'Аватар користувача успішно оновлено!');
        }

        return back();
    }
}
