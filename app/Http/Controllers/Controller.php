<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function getUsersInfo($where = null, $what = null, $paginate = null) {
        if (!is_null($paginate)) {
            $info = DB::table('users_info')
                ->join('users', 'users.id', '=', 'users_info.id_user')
                ->where($where, $what)
                ->paginate($paginate);
        }
        else if (!is_null($where)){
            $info = DB::table('users_info')
                ->join('users', 'users.id', '=', 'users_info.id_user')
                ->where($where, $what)
                ->get();
        }
        else {
            $info = DB::table('users_info')->join('users', 'users.id', '=', 'users_info.id_user')->get();
        }

        foreach ($info as $one) {
            if (Storage::disk('public')->has($one->id_user . '.png')) {
                $one->avatar = '/img/' . $one->id_user . '.png';
            } else {
                $one->avatar = '/img/' . $one->id_user . '.jpg';
            }

            $one->avatar .= '?t=' . Carbon::now();
        }

        return $info;
    }

    public function send_email($id, $text)
    {
        $user = $this->getUsersInfo('id', $id)->first();

        $name = $user->name . ' ' . $user->surname;
        $email = $user->email;

        $data = array('name' => $name, 'text' => $text);

        Mail::send('email.mail', $data, function($message) use ($name, $email, $text) {
            $message->to($email, $name)->subject($text);

            $message->from('workdump.noreply@gmail.com', $text);
        });
    }
}
