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
}
