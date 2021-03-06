<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Middleware\RedirectIfAuthenticated;
use Closure;
use Illuminate\Cookie\CookieJar;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use DB;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;


class CabinetController extends Controller
{
    //
    protected $info = "Інформаційний сервіс \"WorkDump\" для розміщення онлайн-об'яв на виконання робіт";	// Service description
    protected $icon = "/workdump-cabinet.png";		// Service icon (48x48)
    protected $mask = 13;			// Service modes 3,2,0 (1101 bits)

    protected $cabinet_api = "https://cabinet.sumdu.edu.ua/api/";
    protected $cabinet_service = "https://cabinet.sumdu.edu.ua/index/service/";
    protected $cabinet_service_token = "MusKavQn";

    protected $token = "Ztf8SiCvMY5bnjmkrr3u1bP8bx9oB3S8EUumbU1EvDnooeBds1d7";

    // Получаем параметры GET запроса
    protected $key;
    protected $mode;

    public function cabinetRequest(Request $req) {
        $this->key = !empty($req['key']) ? $req['key'] : "";
        $this->mode = !empty($req['mode']) ? $req['mode'] : 0;
        session(['key' => $this->key]);
        $this->token = $this->key;
        if (!empty($this->key)) {
            switch ($this->mode) {
                case 0:
                    break;
                case 2:
                    return response(File::get(public_path($this->icon)), 200)->header('Content-Type', 'image/png');
                case 3:
                    return response($this->info, 200)->header('Content-Type', 'text/plain');
                case 100:
                    return response('', 200)->header('X-Cabinet-Support', $this->mask);
                default:
                    exit;
            }
        }
        //return response();
    }


    /**
     * @param Request $req
     * @return $this
     */
    public function cabinetLogin(Request $req)
    {
        //$auth_key = $req->input('key');
        $this->key = session('key');
        $response = json_decode(file_get_contents($this->cabinet_api . 'getPerson?key=' . $this->key));
        //dd($response, $this->key, Cookie::get(), $this->token);
        //dd(Session::all(), $this->key);
        //if ($response->status == 'OK') {
        if($this->key) {
            $person = $response->result;
            $fresh = false;
            if (!User::where('guid', $person->guid)->exists()) {
                if (User::where('email', $person->email)->exists()) {
                    DB::table('users')->where('email', $person->email)->insert('guid', $person->guid);
                }
                else {
                    $data = [
                        'id_role' => 'Замовник',
                        'email' => $person->email,
                        'name' => $person->name,
                        'surname' => $person->surname,
                        'guid' => $person->guid
                    ];
                    $new = new RegisterController();
                    $new::create($data);
                    $fresh = true;
                }
            }
            $user = User::where('email', $person->email);
            $uid = $user->get('id')->first()->id;
            Auth::loginUsingId($uid, true);
            if(Auth::check())
                if($fresh)
                {
                    return view('auth.role');
                }
                else
                {
                    return Redirect('orders');
                }
            else {
                return back()->withErrors("Помилка входу. Спробуйте пізніше");
            }
        }
        else {
            //throw an error
            return Redirect::away($this->cabinet_service . $this->cabinet_service_token);
            //return Redirect::away('https://cabinet.sumdu.edu.ua/?goto=http://workdump-test.sumdu.edu.ua/cabinet-login');
            //return Redirect::away('https://cabinet.sumdu.edu.ua/?goto=http://workdump-test.sumdu.edu.ua/cabinet-login');
            //return Redirect::away($this->cabinet_service . $this->cabinet_service_token);
            return back()->withErrors("Помилка входу. Спробуйте пізніше");
        }

    }


    public function cabinetLogout(){

        if (isset($_REQUEST['logout']) && isset($_SESSION['person'])) {
            $result = json_decode(file_get_contents($this->cabinet_api . 'logout?key=' . $this->key), true);
        }
    }

}
