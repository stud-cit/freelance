<?php

namespace App\Http\Controllers;

use App\Models\Message;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DB;
use App\Models\User;

class ChatController extends Controller
{
    function get_mess($id) {
        return DB::table('messages')
            ->where([['id_from', Auth::id()], ['id_to', $id]])
            ->orWhere([['id_from', $id], ['id_to', Auth::id()]])
            ->orderBy('id_message', 'desc')
            ->get();
    }

    public function index()
    {
        $contacts = DB::table('contacts')->where('id_user', Auth::id())->get('contacts')->first();
        $users = explode('|', $contacts->contacts);
        $data = [];
        $messages = $this->get_mess($users[1]);

        for ($i = 1; $i < count($users) - 1; $i++) {
            $user = User::getUsersInfo('id', $users[$i])->first();

            array_push($data, $user);
        }

        return view('chat.chat', compact('data'), compact('messages'));
    }

    public function new_message(Request $req) {
        $message = [
            'created_at' => Carbon::now(),
            'text' => $req->text,
            'id_from' => Auth::id(),
            'id_to' => $req->id_to,
            'status' => 0,
        ];

        Message::create($message);

        return $this->get_mess($req->id_to)->toArray();
    }

    public function get_messages(Request $req) {
        return $this->get_mess($req->id)->toArray();
    }
}
