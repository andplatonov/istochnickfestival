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

class DayTwoConversation extends Conversation
{
    /**
     * Start the conversation
     */
    public function run()
    {
        $this->dayTwo();
    }


    private function dayTwo(){
        $this->say('Добрый день! Напоминаем, завтра, 19 мая, состоится фестиваль «Источник здоровья». Он пройдет при поддержке Клуба развития «Ключи». Ждём вас в отеле Radisson Blu к 12-30 ч.');
        $this->say("http://ключи74.рф");
    }

    private function accessProtected($obj, $prop) {
        $reflection = new ReflectionClass($obj);
        $property = $reflection->getProperty($prop);
        $property->setAccessible(true);
        return $property->getValue($obj);
    }

}
