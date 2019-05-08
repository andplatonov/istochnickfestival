<?php

namespace App\Conversations;

use App\Question;
use App\Answer;
use App\PreQuestion;
use App\Interviewer;
use BotMan\BotMan\Messages\Conversations\Conversation;
use BotMan\BotMan\Messages\Incoming\Answer as BotManAnswer;
use BotMan\BotMan\Messages\Outgoing\Question as BotManQuestion;
use BotMan\BotMan\Messages\Outgoing\OutgoingMessage;
use BotMan\BotMan\Messages\Attachments\Image;
use BotMan\BotMan\Messages\Attachments\File;

use Illuminate\Support\Facades\Log;
use ReflectionClass;
use TheArdent\Drivers\Viber\Extensions\FileTemplate;



use App\participant;

/**
 * Class fixConversation
 *
 * @package \App\Conversations
 */
class fixConversation extends Conversation
{

    public function run(){
        $this->setFixPhone();
    }

    private function accessProtected($obj, $prop) {
        $reflection = new ReflectionClass($obj);
        $property = $reflection->getProperty($prop);
        $property->setAccessible(true);
        return $property->getValue($obj);
    }


    public function setFixPhone () {
        $userPhone = BotManQuestion::create("Пожалуйста, подтвердите еще раз участие в Фестивале 19 мая  — введите свой номер телефона");

        $this->ask($userPhone, function (BotManAnswer $answer){
            if($answer->getText() != ''){
                // получить номер
                $response = $answer->getText();
                // определить ИД чата
                $idChat = $this->accessProtected($this->bot->getMessage(), 'sender');
                //  найти такой же чат в users
                $participant = new participant();

                $line = $participant::where('chat_id', '=', $idChat)->first();

                //  добавить номер в БД

                $line->phone = $response;

                $line->save();
                // array_push( $this->nameAndPhone, $answer->getText());
                $this->say("Спасибо! Скоро мы вышлем программу и напомним о мероприятии.");
            } else {
                return $this->setFixPhone();
            }
        });
    }
}
