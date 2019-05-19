<?php
use App\Http\Controllers\BotManController;
use App\Conversations\QuestionConversation;
use App\Conversations\DayOneConversation;
use App\Conversations\DayTwoConversation;
use App\Conversations\DayThreeConversation;
use App\Conversations\EndConversation;
use App\Conversations\SendPhotoConversation;
use App\Conversations\FinalDay;
use App\Conversations\addUserConversation;
use App\Conversations\allResponseConversation;

use BotMan\BotMan\BotMan;
use App\Conversations\BenchConversation;
use App\Http\Middleware\TypingMiddleware;

use App\participant;
use App\visitor;

use TheArdent\Drivers\Viber\ViberDriver;
use App\save;
use Illuminate\Support\Facades\Log;

$botman = resolve('botman');
$GLOBALS['array_id'] = [];
/*
$botman->hears('старт|Старт', function (BotMan $bot) {
    //$bot->reply('its start!');
    $bot->startConversation(new QuestionConversation);
});
*/
// Для юзеров, которые пришли на фестиваль 18.05.19
$botman->hears('старт|Старт', function(BotMan $bot) {
    $bot->startConversation(new addUserConversation);
});



$botman->hears('allresponse', function (BotMan $bot) {
    $user_ids = participant::where('chat_id', '!=', 'not viber')->get();




    foreach ($user_ids as $user_id){
        $bot->startConversation(new allResponseConversation, $user_id->chat_id, ViberDriver::class);
    }
});

$botman->hears('Start conversation', BotManController::class.'@startConversation');


//  Запуск 15.05.19
$botman->hears("dayonestart", function (BotMan $bot){


    $user_ids = participant::where('chat_id', '!=', 'not viber')->get();

    foreach ($user_ids as $user_id){
        $bot->startConversation(new DayOneConversation, $user_id->chat_id, ViberDriver::class);
    }
});


// Запуск 18.05.19
$botman->hears('daytwostart', function (Botman $bot){

    $user_ids = participant::where('chat_id', '!=', 'not viber')->get();

    foreach ($user_ids as $user_id){
        $bot->startConversation(new DayTwoConversation, $user_id->chat_id, ViberDriver::class);
    }
});

// Запуск 19.05.19
$botman->hears('daythreestart', function (Botman $bot){

    $user_ids = participant::where('chat_id', '!=', 'not viber')->get();

    foreach ($user_ids as $user_id){
        $bot->startConversation(new DayThreeConversation, $user_id->chat_id, ViberDriver::class);
    }
});
$botman->hears('true', function (BotMan $bot){
    $user_ids = participant::where('chat_id', '!=', 'not viber')->get();

    foreach ($user_ids as $user_id){
        $bot->startConversation(new \App\Conversations\fixConversation(), $user_id->chat_id, ViberDriver::class);
    }
});
$botman->hears('finalstart', function(BotMan $bot){
    $user_ids = visitor::where('chat_id', '!=', 'not viber')->get();

    foreach ($user_ids as $user_id){
        $bot->startConversation(new FinalDay, $user_id->chat_id, ViberDriver::class);
    }






});

