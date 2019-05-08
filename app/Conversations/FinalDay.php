<?php

namespace App\Conversations;

use Illuminate\Foundation\Inspiring;
use BotMan\BotMan\Messages\Incoming\Answer;
use BotMan\BotMan\Messages\Outgoing\Question;
use BotMan\BotMan\Messages\Outgoing\Actions\Button;
use BotMan\BotMan\Messages\Conversations\Conversation;

use BotMan\BotMan\Messages\Incoming\Answer as BotManAnswer;
use BotMan\BotMan\Messages\Outgoing\Question as BotManQuestion;
use ReflectionClass;
use BotMan\BotMan\Messages\Attachments\File;
use BotMan\BotMan\Messages\Attachments\Image;
use BotMan\BotMan\Messages\Outgoing\OutgoingMessage;
use TheArdent\Drivers\Viber\Extensions\FileTemplate;

use App\finalday as bdFinalDay;
use App\wiche as dbWishes;


class FinalDay extends Conversation
{
    private $user = [];
    /**
     * Start the conversation
     */
    public function run()
    {
        $this->dayLast();
    }


    private function dayLast(){

        $questionTemplate = BotManQuestion::create('Как вам фестиваль? Оцените по шкале от 1 до 10?');

        $this->ask($questionTemplate, function (BotManAnswer $answer){

            if( $answer->getText() == 1 || $answer->getText() == 2 ||
                $answer->getText() == 3 || $answer->getText() == 4 ||
                $answer->getText() == 5 || $answer->getText() == 6 ||
                $answer->getText() == 7 || $answer->getText() == 8 ||
                $answer->getText() == 9 || $answer->getText() == 10 ) {

                $bdFinalDay =  new bdFinalDay();

                if ($this->bot->driverStorage()->getDefaultKey() == 'Viber' ){
                    $message = $this->bot->getMessage();
                    // $this->user_id = $this->accessProtected($message, 'sender');
                    array_push($this->user, $this->accessProtected($message, 'sender'));

                    $bdFinalDay->chat_id = $this->user[0];
                } else {
                    $bdFinalDay->chat_id = "not viber";
                }

                $bdFinalDay->assessment  =  $answer->getText();

                $bdFinalDay->save();

                $this->SetWishes();
            }
        });


    }


    private function SetWishes () {
        $questionTemplate = BotManQuestion::create('Есть ли у вас пожелания по организации фестиваля или темам лекций? Напишите "да" или "нет".');

        $this->ask($questionTemplate, function (BotManAnswer $answer){
            if ( mb_strtolower( $answer->getTExt() ) != "нет" && $answer->getText() != '' ) {
                $questionW = BotManQuestion::create('Пожалуйста, поделитесь с нами.');

                $this->ask($questionW, function(BotManAnswer $answerW) {
                    if ( $answerW->getText() != "" ) {
                        $wishes = new dbWishes();

                        if ($this->bot->driverStorage()->getDefaultKey() == 'Viber' ){
                            $message = $this->bot->getMessage();
                            // $this->user_id = $this->accessProtected($message, 'sender');
                            $wishes->chat_id = $this->accessProtected($message, 'sender');
                        } else {
                            $wishes->chat_id = "not viber";
                        }

                        $wishes->wiches = $answerW->getText();

                        $wishes->save();

                        $this->say("Не выбрасывайте программу фестиваля — воспользуйтесь скидкой на услуги клиники, которую она дает.");

                       // $this->SetWishes();
                    }
                });
            } else { $this->say("Не выбрасывайте программу фестиваля — воспользуйтесь скидкой на услуги клиники, которую она дает."); }



        });
    }

    private function accessProtected($obj, $prop) {
        $reflection = new ReflectionClass($obj);
        $property = $reflection->getProperty($prop);
        $property->setAccessible(true);
        return $property->getValue($obj);
    }

}
