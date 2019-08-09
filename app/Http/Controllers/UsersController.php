<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class UsersController extends Controller
{
    public function customers()
    {
        $data = DB::table('users')->where('id_role', 2)->get(['name', 'surname', 'patronymic', 'phone_number', 'avatar', 'about_me', 'email']);

        return view('users.customers', compact('data'));
    }

    public function workers()
    {
        $data = DB::table('users')->where('id_role', 3)->get(['name', 'surname', 'patronymic', 'phone_number', 'avatar', 'about_me', 'email']);

        return view('users.workers', compact('data'));
    }
}
