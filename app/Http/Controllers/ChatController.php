<?php

namespace App\Http\Controllers;

use App\Models\Message;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DB;
use App\Models\User;
use App\Events\NewMessage;

class ChatController extends Controller
{
    public function index()
    {
        $mess = DB::table('messages')
            ->where('id_from', Auth::id())
            ->orWhere('id_to', Auth::id())
            ->get(['id_from', 'id_to']);

        $ids = [];

        foreach ($mess as $one) {
            $id = $one->id_from == Auth::id() ? $one->id_to : $one->id_from;

            if (!in_array($id, $ids)) {
                array_push($ids, $id);
            }
        }

        $data = [];

        foreach ($ids as $id) {
            $history = DB::table('messages')
                ->where([['id_from', Auth::id()], ['id_to', $id]])
                ->orWhere([['id_from', $id], ['id_to', Auth::id()]])
                ->get();

            $history->user = User::getUsersInfo('id', $id)->first();

            array_push($data, $history);
        }

        return view('chat.chat', compact('data'));
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
    }
}
