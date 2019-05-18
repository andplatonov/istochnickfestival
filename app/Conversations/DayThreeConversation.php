<?php

namespace App\Conversations;

use Illuminate\Foundation\Inspiring;
use BotMan\BotMan\Messages\Incoming\Answer;
use BotMan\BotMan\Messages\Outgoing\Question;
use BotMan\BotMan\Messages\Outgoing\Actions\Button;
use BotMan\BotMan\Messages\Conversations\Conversation;


use App\PreQuestion;
use App\Interviewer;
use BotMan\BotMan\Messages\Incoming\Answer as BotManAnswer;
use BotMan\BotMan\Messages\Outgoing\Question as BotManQuestion;
use ReflectionClass;
use BotMan\BotMan\Messages\Attachments\File;
use BotMan\BotMan\Messages\Attachments\Image;
use BotMan\BotMan\Messages\Outgoing\OutgoingMessage;
use TheArdent\Drivers\Viber\Extensions\FileTemplate;

use App\visitor;

class DayThreeConversation extends Conversation
{

    private $user = [];
    /**
     * Start the conversation
     */
    public function run()
    {
        $this->dayThree();
    }

    private function dayThree(){

        $questionTemplate = BotManQuestion::create('Здравствуйте! Рады приветствовать вас на фестивале «Источник здоровья». Вы с нами?');

        $this->ask($questionTemplate, function (BotManAnswer $answer){
            if( mb_strtolower($answer->getText()) == 'да'){
                $visitor =  new visitor();

                $visitor->chat_id  =  $answer->getText();

                if ($this->bot->driverStorage()->getDefaultKey() == 'Viber' ){
                    $message = $this->bot->getMessage();
                    //$this->user_id = $this->accessProtected($message, 'sender');
                    array_push($this->user, $this->accessProtected($message, 'sender'));

                    $visitor->chat_id = $this->user[0];

                    $visitor->save();

                    //$visitor->chat_id  =  $answer->getText();
                } else {
                    $visitor->chat_id = "not viber";

                    $visitor->save();
                }

                $this->say("Спасибо, мы внесли вас в список участников! ");

            } else {
                return $this->say('Будем ждать вас на фестивале.');
            }
        });
    }

    private function accessProtected($obj, $prop) {
        $reflection = new ReflectionClass($obj);
        $property = $reflection->getProperty($prop);
        $property->setAccessible(true);
        return $property->getValue($obj);
    }

    public function competition() {


    }

}
