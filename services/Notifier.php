<?php


namespace app\services;


use app\services\interfaces\NotifierInterface;

class Notifier implements NotifierInterface
{
    private string $fromEmail;

    public function __construct($fromEmail)
    {
        $this->fromEmail = $fromEmail;
    }

    public function notify($email, $view, $data, $subject)
    {
        \Yii::$app->mailer->compose($view, $data)
            ->setFrom(\Yii::$app->params[$this->fromEmail])
            ->setTo($email)
            ->setSubject($subject)
            ->send();
    }
}