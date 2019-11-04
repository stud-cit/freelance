<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $primaryKey = 'id_message';
    public $timestamps = false;

    protected $fillable = [
        'timestamp', 'text', 'id_from', 'id_to', 'status', 'created_at'
    ];
}
