<?php

namespace App\Http\Controllers;

use App\Models\Message;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class ChatController extends Controller
{
    function sort_contacts($a, $b)
    {
        if ($a['id_message'] == $b['id_message']) {
            return 0;
        }

        return $a['id_message'] < $b['id_message'] ? 1 : -1;
    }

    function get_mess($id) {
        $messages = DB::table('messages')
            ->where([['id_from', Auth::id()], ['id_to', $id]])
            ->orWhere([['id_from', $id], ['id_to', Auth::id()]])
            ->orderBy('id_message', 'desc')
            ->get();

        foreach ($messages as $one) {
            $temp = explode(' ', $one->created_at);
            $temp = explode(':', $temp[1]);

            $one->time = $temp[0] . ':' . $temp[1];
        }

        return $messages;
    }

    function sorted_array()
    {
        $contacts = DB::table('contacts')->where('id_user', Auth::id())->get('contacts')->first();
        $users = explode('|', $contacts->contacts);
        $sort = [];

        for ($i = count($users) - 2; $i > 0; $i--) {
            $last_message = $this->get_mess($users[$i])->first();
            $last_message = is_null($last_message) ? -1 : $last_message->id_message;

            array_push($sort, ['id_user' => $users[$i], 'id_message' => $last_message]);
        }

        usort($sort, array($this, "sort_contacts"));

        return $sort;
    }

    public function index()
    {
        if (Auth::user()->banned) {
            redirect('/orders');
        }

        $open = session()->get('id');
        session()->forget('id');
        $data = [];
        $messages = null;

        $sort = $this->sorted_array();

        if (!is_null($open)) {
            DB::table('messages')->where([['id_from', $open], ['id_to', Auth::id()], ['status', 0]])->update(['status' => 1]);

            $messages = $this->get_mess($open);
            $messages->id_to = $open;
        }

        foreach ($sort as $one) {
            $user = $this->getUsersInfo('id', $one['id_user'])->first();

            $user->count = DB::table('messages')->where([['id_from', $one['id_user']], ['id_to', Auth::id()], ['status', 0]])->count();

            array_push($data, $user);
        }

        $data = [
            'data' => $data,
            'messages' => $messages,
            'id_to' => $open
        ];

        return view('chat.chat', compact('data'));
    }

    public function new_message(Request $req) {
        $message = [
            'created_at' => Carbon::now()->timezone('Europe/Kiev'),
            'text' => $req->text,
            'id_from' => Auth::id(),
            'id_to' => $req->id_to,
            'file' => false,
            'status' => 0,
        ];

        Message::create($message);

        DB::table('messages')->where([['id_from', $req->id_to], ['id_to', Auth::id()], ['status', 0]])->update(['status' => 1]);

        return $this->get_mess($req->id_to)->toArray();
    }

    public function send_file(Request $req)
    {
        $message = [
            'created_at' => Carbon::now()->timezone('Europe/Kiev'),
            'text' => $req->name,
            'id_from' => Auth::id(),
            'id_to' => $req->id_to,
            'file' => true,
            'status' => 0,
        ];

        $message = Message::create($message);
        $path = 'messages_' . $message->id_message . '_' . $req->name;

        try {
            Storage::disk('files')->put($path, File::get($req->file('file')));
        }
        catch (Exception $e) {
            DB::table('messages')->where('id_message', $message->id_message)->delete();

            return 'error';
        }

        return $this->get_mess($req->id_to)->toArray();
    }

    public function get_file(Request $req)
    {
        $url = 'messages_' . $req->id . '_' . $req->name;

        return Storage::disk('files')->download($url, $req->name);
    }

    public function get_messages(Request $req) {
        DB::table('messages')->where([['id_from', $req->id], ['id_to', Auth::id()], ['status', 0]])->update(['status' => 1]);

        return $this->get_mess($req->id)->toArray();
    }

    public function new_contact(Request $req)
    {
        $user = DB::table('contacts')->where('id_user', Auth::id())->get()->first();
        $user_to = DB::table('contacts')->where('id_user', $req->id_user)->get()->first();

        $check = strpos($user->contacts, '|' . $req->id_user . '|');

        if ($check === false || $user->contacts == '|') {
            DB::table('contacts')
                ->where('id_user', Auth::id())
                ->update(['contacts' => $user->contacts . $req->id_user . '|']);

            DB::table('contacts')
                ->where('id_user', $req->id_user)
                ->update(['contacts' => $user_to->contacts . Auth::id() . '|']);
        }

        return redirect()->route('to_chat')->with(['id' => $req->id_user]);
    }

    public function check_messages(Request $req)
    {
        $check = DB::table('messages')->where([['id_to', Auth::id()], ['status', 0]])->count();
        $data = [];

        if ($check) {
            $sort = $this->sorted_array();

            foreach ($sort as $one) {
                $count = DB::table('messages')->where([['id_from', $one['id_user']], ['id_to', Auth::id()], ['status', 0]])->count();

                if ($count && $one['id_user'] != $req->id && (is_null($req->data[$one['id_user']]) || $req->data[$one['id_user']] != $count)) {
                    $data[$one['id_user']] = $count;
                }
            }

            $check = DB::table('messages')->where([['id_from', $req->id], ['id_to', Auth::id()], ['status', 0]])->count();

            if ($check) {
                DB::table('messages')->where([['id_from', $req->id], ['id_to', Auth::id()], ['status', 0]])->update(['status' => 1]);

                return [
                    'data' => $data,
                    'messages' => $this->get_mess($req->id)
                ];
            }
            else {
                return [
                    'data' => $data
                ];
            }
        }
        else {
            return [];
        }
    }

    public function check_header()
    {
        return Auth::user()->new_messages();
    }
}
