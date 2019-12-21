<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        return redirect('/orders');
    }

    public function tutorial()
    {
        return view('tutorial.tutorial');
    }
}
