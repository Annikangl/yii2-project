<?php


namespace app\services;


use app\services\interfaces\LoggerInterface;

class Logger implements LoggerInterface
{

    public function log($message)
    {
        $log = new \yii\log\Logger();
        $log->messages = $message;
    }
}