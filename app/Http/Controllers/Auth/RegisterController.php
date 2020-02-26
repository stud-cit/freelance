<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Auth\RegistersUsers;
use DB;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/orders';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function showRegistrationForm()
    {
        $types = DB::table('dept_type')->get();
        $dept = [];

        foreach ($types as $one) {
            $dept[$one->type_name] = DB::table('departments')->where('id_type', $one->id_type)->get()->toArray();
        }

        return view("auth.register", compact('dept'));
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'surname' => ['required', 'string', 'max:255'],
            'id_role' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    public static function create(array $data)
    {
        $id_role = DB::table('roles')->where('role_name', $data['id_role'])->get('id_role')->first();

        $user = User::create([
            'id_role' => $id_role->id_role,
            'email' => $data['email'],
            'banned' => false,
            'password' => array_key_exists('password', $data) ? Hash::make($data['password']) : '',
            'guid' => !empty($data['guid']) ? $data['guid'] : ''
        ]);

        Storage::disk('public')->copy('0.png', $user['id'] . '.png');

        $values = [
            'id_user' => $user['id'],
            'name' => $data['name'],
            'surname' => $data['surname'],
            'birthday_date' => null,
            'phone_number' => null,
            'about_me' => null
        ];

        DB::table('users_info')->insert($values);

        return $user;
    }
}
