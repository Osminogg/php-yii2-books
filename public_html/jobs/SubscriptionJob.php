<?php

namespace app\jobs;

use app\models\SmsSender;
use app\models\Subscription;
use yii\base\BaseObject;
use yii\queue\JobInterface;

class SubscriptionJob extends BaseObject implements JobInterface
{
    public int $author_id;
    public string $title;

    public function execute($queue)
    {
        $subs = Subscription::find()
            ->where(['author_id' => $this->author_id])
            ->all();

        //если много подписчиков, можно отправлять пачкой
        if(count($subs)) {
            foreach ($subs as $sub) {
                $this->sendMessage($sub);
            }
        }
    }

    private function sendMessage($sub)
    {
        try {
            $message = "У автора {$sub->author->fio} вышла книга {$this->title}";
            $sender = new SmsSender(\Yii::$app->params['smsSender'], \Yii::$app->params['smsApiKey']);
            $sender->sendSms($sub->phone, $message);
            print "\r\nУспех {$message}";
        } catch (\Throwable $e) {
            //запись ошибки для дальнейшей обработки
            //например в случае недоступности сервиса, отправить позже
            //или случае несуществующего телефона, делать пометку об этом
            print "Ошибка";
        }
    }
}