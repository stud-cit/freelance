<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $req)
    {
        if(!empty($req['mode'])) {
            $cab = new CabinetController();
            return $cab->cabinetRequest($req);
        }
        if ($_COOKIE == []) {
            return redirect('/tutorial');
        }
        else {
            return redirect('/orders');
        }
    }

    public function tutorial()
    {
        return view('tutorial.tutorial');
    }
}
