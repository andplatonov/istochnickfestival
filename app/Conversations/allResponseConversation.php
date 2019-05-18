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
 * Class allResponseConversation
 *
 * @package \App\Conversations
 */
class allResponseConversation extends Conversation
{
    public function run() {
        $this->say("Улыбнитесь, вас снимают :) Мы онлайн загружаем снимки с фестиваля сюда: https://yadi.sk/d/Ygw3qwXHR1s7eQ \n Найдите себя и выложите фото в соцсетях с хештегом #ИсточникЧелФест \nТе, чьи фото наберут больше всего лайков, выиграют подарки от «Источника»: \n3 сертификата на программу «Стройность» (ВК, FB, Instagram): \n -прием диетолога \n -разработка программы правильного питания \n -прием эндокринолога \n\n5 сертификатов на программу «Полчаса до идеала» \n-индивидуальная экскурсия по отделению косметологии \n -30 минут на аппарате HydraFacial, процедура на лицо. \nВручение подарков сегодня в 16.00. Не пропустите ;)");
    }
}
