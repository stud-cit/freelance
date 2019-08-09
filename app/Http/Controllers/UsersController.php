<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

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
}
