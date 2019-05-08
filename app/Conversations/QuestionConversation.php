<?php
/**
 * Created by PhpStorm.
 * User: dev
 * Date: 15.02.2019
 * Time: 13:35
 */

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

class QuestionConversation extends Conversation
{

    protected $user = [];
    protected $nameAndPhone = [];

    public function run() {
        $this->About();
    }


    private function About() {
        $questionTemplate = BotManQuestion::create("19 мая клиника «Источник» проводит фестиваль «Источник здоровья». Наши врачи расскажут, как стать стройным, сохранить молодость и укрепить организм. Планируете посетить фестиваль? Напишите «Да» или «Нет».");


        $this->ask($questionTemplate, function (BotManAnswer $answer){
            if( mb_strtolower($answer->getText()) == 'да' ){
                $this->setName();
            } else {
                return $this->say('Будем рады видеть вас на фестивале в следующем году!');
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
                $this->say("Спасибо! Скоро мы вышлем программу и напомним о мероприятии.");

                return $this->endGame();
            } else {
                return $this->setPhone();
            }
        });
    }



    private function endGame() {
        $participant = new participant();

        $participant->name = $this->nameAndPhone[0];
        $participant->phone = $this->nameAndPhone[1];

        if ($this->bot->driverStorage()->getDefaultKey() == 'Viber' ){

            $message =  $this->bot->getMessage();
            array_push($this->user, $this->accessProtected($message, 'sender'));
            $participant->chat_id = $this->user[0];
        } else {
            $participant->chat_id = "not viber";
        }

        $participant->save();
    }

    private function accessProtected($obj, $prop) {
        $reflection = new ReflectionClass($obj);
        $property = $reflection->getProperty($prop);
        $property->setAccessible(true);
        return $property->getValue($obj);
    }

}
