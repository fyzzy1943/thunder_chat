<?php

namespace App\Http\Controllers;

use Redis;
use Auth;
use Illuminate\Http\Request;

use App\Http\Requests;

class ChatController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('index');
    }

    public function flush()
    {
        set_time_limit(0);

        header('Content-Type: text/event-stream');
        header('X-Accel-Buffering: no');
        while(true) {
            if(Redis::get('isNew') == 'false') {
                continue;
            }

            $d = array(
                'id' => Redis::get('uid'),
                'name' => Redis::get('name'),
                'timestamp' => time(),
                'message'=>Redis::get('message'),
            );

            echo 'data:' . json_encode($d) . PHP_EOL . PHP_EOL;
            @ob_flush(); @flush();

            Redis::set('isNew', 'false');
            usleep('500');
        }
    }

    public function say(Request $request)
    {
        Redis::set('message', $request->get('message'));
        Redis::set('name', Auth::user()->name);
        Redis::set('uid', Auth::user()->id);
        Redis::set('isNew', 'true');
    }
}
