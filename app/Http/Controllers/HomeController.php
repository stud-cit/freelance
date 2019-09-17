<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

class HomeController extends Controller
{
    public function index()
    {
        if (!is_null(Auth::user())) {
            return redirect('/orders');
        }

        return view('site.index');
    }
}
