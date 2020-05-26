<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Middleware\RedirectIfAuthenticated;
use Closure;
use Illuminate\Http\Request;
use App\Models\User;
use Auth;
use DB;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;


class CabinetController extends Controller
{
    //
    protected $info = "Інформаційний сервіс \"WorkDump\" для розміщення онлайн-об'яв на виконання робіт";	// Service description
    protected $icon = "workdump-cabinet.png";		// Service icon (48x48)
    protected $mask = 13;			// Service modes 3,2,0 (1101 bits)

    protected $cabinet_api = "https://cabinet.sumdu.edu.ua/api/";
    protected $cabinet_service = "https://cabinet.sumdu.edu.ua/index/service/";
    protected $cabinet_service_token = "dFTDj0oK";

    protected $token = "Ztf8SiCvMY5bnjmkrr3u1bP8bx9oB3S8EUumbU1EvDnooeBds1d7";

    // Получаем параметры GET запроса
    protected $key;
    protected $mode;

    public function cabinetRequest(Request $req) {
        $req = json_decode(file_get_contents($this->cabinet_api . "getPerson/?key=" . $this->token), true);
        $this->key = !empty($req['key']) ? $req['key'] : "";
        $this->mode = !empty($req['mode']) ? $req['mode'] : 0;
        if (!empty($key)) {
            switch ($this->mode) {
                case 0:
                    break;
                case 2:
                    header('Content-Type: image/png');
                    readfile($this->icon);
                    exit;
                case 3:
                    echo $this->info;
                    exit;
                case 100;
                    header('X-Cabinet-Support: ' . $this->mask);
                default:
                    exit;
            }
        }
    }


    /**
     * @param Request $req
     * @return $this
     */
    public function cabinetLogin(Request $req)
    {
        $auth_key = $req->input('key');
        $response = json_decode(file_get_contents($this->cabinet_api . 'getPerson?key=' . $auth_key));
        //$response = json_decode(file_get_contents($this->cabinet_api . 'getPerson?key=' . $this->token));
        if ($response->status == 'OK') {
            $person = $response->result;
            $fresh = false;
            //echo '<p>token: '.$person->token.'</p>';
            //echo '<p>guid: '.$person->guid.'</p>';
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
            $temp_user = User::where('email', '=', $person->email)->firstOrFail();
            //$user = DB::table('users')->where('email', $person->email)->get()->first();
            Auth::loginUsingId($uid, true);
            //Auth::attempt(['email' => $person->email, 'password' => $pass]);
            if(Auth::check())
                if($fresh)
                {
                    return view('auth.role');
                }
                else
                {
                    return Redirect('orders');
                /*$log = new RedirectIfAuthenticated();
                if (!empty($log)) {
                    $new_req = new Request();
                    $log->handle($new_req);
                }*/
                }
            else {
                return back()->withErrors("Помилка входу. Спробуйте пізніше");
            }
        }
        else {
            //throw an error
            return redirect('https://cabinet.sumdu.edu.ua/?goto=http://workdump-test.sumdu.edu.ua/cabinet-login');
            return back()->withErrors("Помилка входу. Спробуйте пізніше");
        }

    }


    public function cabinetLogout(){

        if (isset($_REQUEST['logout']) && isset($_SESSION['person'])) {
            $result = json_decode(file_get_contents($this->cabinet_api . 'logout?key=' . $this->key), true);
        }
    }

}
