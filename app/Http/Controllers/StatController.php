<?php

namespace App\Http\Controllers;
//namespace App\Conversations;

use Illuminate\Http\Request;
use App\stat;
use App\participant;
use App\keppQuestion;
use App\visitor;

use App\finalday as bdFinalDay;
use App\wiche as dbWishes;


use BotMan\BotMan\Messages\Conversations\Conversation;
use BotMan\BotMan\Messages\Incoming\Answer as BotManAnswer;
use BotMan\BotMan\Messages\Outgoing\Question as BotManQuestion;
use ReflectionClass;

class StatController extends Controller
{
    //

    public function firstUsers() {
        $users =  new participant();
        $users = $users::all();
        return view('stat', ['users' => $users]);
    }

    public function questionStat() {
        $keppQuestion = new keppQuestion();
        $keppQuestion = $keppQuestion::all();

        return view('questionStat', ['keppQuestion' => $keppQuestion]);
    }

    public function yesStat() {
        $visitor = new visitor();
        $visitor = $visitor::all();

        return view('visitorStat', ['visitor' => $visitor]);
    }

    public function starStat() {
        $bdFinalDay = new bdFinalDay();
        $bdFinalDay = $bdFinalDay::all();

        return view('starStat', ['starts' => $bdFinalDay]);
    }

    public function wishesStat(){
        $dbWishes = new dbWishes();
        $dbWishes = $dbWishes::all();
        return view('wishesStat', ['wishes' => $dbWishes]);
    }



}
