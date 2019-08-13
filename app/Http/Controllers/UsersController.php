<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Auth;

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
        $values = [
            'name' => $req->name,
            'surname' => $req->surname,
            'patronymic' => $req->patronymic,
            'birthday_date' => $req->birthday,
            'phone_number' => $req->phone,
            'viber' => $req->viber,
            'skype' => $req->skype,
            'about_me' => $req->about_me,
        ];

        DB::table('users_info')->where('id_user', Auth::user()->id)->update($values);

        return back();
    }
}
