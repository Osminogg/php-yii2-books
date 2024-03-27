<?php

namespace app\models;

use yii\base\Exception;

class SmsSender {
    private string $sender;
    private string $apiKey;

    public function __construct($sender, $apiKey) {
        $this->sender = $sender;
        $this->apiKey = $apiKey;
    }

    public function sendSms($phone, $message) {
        $url = 'https://smspilot.ru/api.php'
            .'?send='.urlencode( $message )
            .'&to='.urlencode( $phone )
            .'&from='.$this->sender
            .'&apikey='.$this->apiKey
            .'&format=json';

        try {
            $json = file_get_contents($url);
            $j = json_decode($json);
            if(isset($j->error)) {
                throw new Exception($j->error->description_ru);
            }
        } catch (\Throwable $e) {
            throw new Exception($e->getMessage());
        }
    }
}