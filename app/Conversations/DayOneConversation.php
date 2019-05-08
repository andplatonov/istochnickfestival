<?php

namespace App\Conversations;

use BotMan\BotMan\Messages\Conversations\Conversation;
use BotMan\BotMan\Messages\Incoming\Answer as BotManAnswer;
use BotMan\BotMan\Messages\Outgoing\Question as BotManQuestion;

use BotMan\BotMan\Messages\Attachments\File;
use BotMan\BotMan\Messages\Outgoing\OutgoingMessage;
use BotMan\BotMan\Messages\Attachments\Image;

use App\keppQuestion;
use Illuminate\Support\Facades\Log;

class DayOneConversation extends Conversation
{
    /**
     * Start the conversation
     */
    private $iter = 2;
    public function run()
    {
        $this->say("Здравствуйте! Напоминаем, что вы зарегистрированы на фестиваль «Источник здоровья - 2019». Время: 19 мая с 12-30. Место: Отель Radisson Blu. Ознакомьтесь с программой фестиваля.");

        

        // отрпавить расписание

        // Create attachment
        $attachment = new Image('https://officesanta.ru/festival/q.png', [
            'custom_payload' => true,
        ]);

        // Build message object
        $message = OutgoingMessage::create('Расписание')
            ->withAttachment($attachment);

        // Reply message object
        $this->bot->reply($message);


        $this->dayOne();
    }


    private function dayOne(){


        // вопросы
        $this->Question();
    }

    private function Question(){
        $questionTemplate = BotManQuestion::create("Если у вас есть вопросы к врачам, пожалуйста, напишите ответным сообщением.");

        $this->ask($questionTemplate, function (BotManAnswer $answer){
            if( $answer->getText() != '' || mb_strtolower($answer->getText()) != 'нет' ){
                $keppQuestion =  new keppQuestion();

                $keppQuestion->question  =  $answer->getText();
                $keppQuestion->save();
                //Log::info(print_r($answer, true));
                $this->say("Спасибо! Мы учтем ваш вопрос при подготовке материала.");

                $this->iter--;
            } else {
                return $this->say('Будем ждать вас на фестивале.');
            }

            /*
            $repeat = BotManQuestion::create("У вас есть еще вопросы?");
            $this->ask($repeat, function ( BotManAnswer $answer) {
                if( mb_strtolower($answer->getText()) == 'да' ){
                    $this->Question();
                } else {
                    return $this->say('Будем ждать вас на фестивале.');
                }
            });
            */

        });
    }


}
