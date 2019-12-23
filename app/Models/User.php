<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id_role', 'email', 'password', 'banned', 'id_dept',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    function isAdmin() {
        return Auth::user()->id_role == 1;
    }

    function isCustomer() {
        return Auth::user()->id_role == 2;
    }

    function isWorker() {
        return Auth::user()->id_role == 3;
    }

    function getName() {
        $name = DB::table('users_info')->where('id_user', Auth::id())->get();
        return $name[0]->name.' '.$name[0]->surname;
    }

    function getAvatarPath() {
        $id = Auth::id();

        if (Storage::disk('public')->has($id . '.png')) {
            return '/img/' . $id . '.png' . '?t=' . Carbon::now();
        }
        else {
            return '/img/' . $id . '.jpg' . '?t=' . Carbon::now();
        }
    }

    function new_messages() {
        return DB::table('messages')->where([['id_to', Auth::id()], ['status', 0]])->count();
    }

    function order_change() {
        $orders = DB::table('orders')->where('status', 'new')->get();
        $count = 0;

        if (Auth::user()->id_role == 2) {
            foreach ($orders as $order) {
                $proposals = DB::table('proposals')->where([['id_order', $order->id_order], ['checked', false]])->count();

                $count += $proposals != 0;
            }
        }
        else {
            $count = DB::table('orders')->where([['id_worker', Auth::id()], ['checked', false]])->count();
        }

        return $count;
    }
}
