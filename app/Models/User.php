<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use DB;
use Auth;
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
        'id_role', 'email', 'password',
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
        $id = Auth::id();
        $user = DB::table('users')->where('id', $id)->get('id_role')->first();

        return $user->id_role == 1;
    }

    function getAvatarPath() {
        $id = Auth::id();

        if (Storage::disk('public')->has($id . '.png')) {
            return '/img/' . $id . '.png';
        }
        else {
            return '/img/' . $id . '.jpg';
        }
    }
}
