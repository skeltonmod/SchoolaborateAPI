<?php

namespace App\Http\Controllers;

use App\Events\ChatEvent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    //
    public function sendMessage(Request $request){
        return event(new ChatEvent([
            'content' => $request->message,
            'sender' => 'User 1',
            'time' => $request->time,
            'sender_id' => $request->sender_id
        ]));
    }
}
