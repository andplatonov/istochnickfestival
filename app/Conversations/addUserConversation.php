<?php

namespace App\Conversations;
use BotMan\BotMan\Messages\Conversations\Conversation;
use BotMan\BotMan\Messages\Incoming\Answer as BotManAnswer;
use BotMan\BotMan\Messages\Outgoing\Question as BotManQuestion;
use BotMan\BotMan\Messages\Outgoing\OutgoingMessage;
use BotMan\BotMan\Messages\Attachments\Image;
use BotMan\BotMan\Messages\Attachments\File;
use TheArdent\Drivers\Viber\ViberDriver;
use Illuminate\Support\Facades\Log;
use ReflectionClass;
use BotMan\BotMan\BotMan;
use App\Conversations\BenchConversation;
use App\Http\Middleware\TypingMiddleware;
use TheArdent\Drivers\Viber\Extensions\FileTemplate;

use App\participant;
use App\visitor;

/**
 * Class addUserConversation
 *
 * @package \App\Conversations
 */
class addUserConversation extends Conversation
{
    protected $user = [];
    protected $nameAndPhone = [];

    public function run() {
        $response = BotManQuestion::create("Здравствуйте! Рады приветствовать вас на фестивале «Источник здоровья». Вы с нами? Напишите «да», если уже присоединились.");

        $this->ask($response, function (BotManAnswer $answer){
            if( $answer->getText() != '' && ( $answer->getText() == 'Да' || $answer->getText() == 'да' ) ){

                return $this->setName();
            } else {
                return $this->newUsers();
            }
        });
    }


    private function setName() {
        $userName = BotManQuestion::create("Отлично! Пожалуйста, подтвердите свое участие: напишите свои имя и фамилию.");

        $this->ask($userName, function (BotManAnswer $answer){
            if( $answer->getText() != '' ) {
                array_push($this->nameAndPhone, $answer->getText());

                return $this->setPhone();
            } else {
                $this->say("Пожалуйста, напишите свои имя и фамилию");
                return  $this->setName();
            }
        });
    }



    private function setPhone(){
        $userPhone = BotManQuestion::create("Напишите ваш номер телефона.(например, +79514735076)");

        $this->ask($userPhone, function (BotManAnswer $answer){
            if($answer->getText() != ''){
                array_push( $this->nameAndPhone, $answer->getText());
                $this->say("Спасибо, мы внесли вас в список участников! Ознакомьтесь с программой мероприятия:");

                // Create attachment
                $attachment = new Image('https://officesanta.ru/festival/q.png', [
                    'custom_payload' => true,
                ]);

                // Build message object
                $message = OutgoingMessage::create('Расписание')
                    ->withAttachment($attachment);

                // Reply message object
                $this->bot->reply($message);

                return $this->endGame();
            } else {
                return $this->setPhone();
            }
        });
    }



    private function endGame() {
        $participant = new participant();
        $visitor = new visitor();

        $participant->name = $this->nameAndPhone[0];
        $participant->phone = $this->nameAndPhone[1];

        if ($this->bot->driverStorage()->getDefaultKey() == 'Viber' ){

            $message =  $this->bot->getMessage();
            array_push($this->user, $this->accessProtected($message, 'sender'));
            $participant->chat_id = $this->user[0];
            $visitor->chat_id = $this->user[0];
        } else {
            $participant->chat_id = "not viber";
        }

        $participant->save();
        $visitor->save();
    }

    private function accessProtected($obj, $prop) {
        $reflection = new ReflectionClass($obj);
        $property = $reflection->getProperty($prop);
        $property->setAccessible(true);
        return $property->getValue($obj);
    }


    public function newUsers() {

    }

}

