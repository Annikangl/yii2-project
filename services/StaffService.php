<?php

namespace app\servise;

use app\models\Interview;
use Yii;
use yii\debug\models\search\Log;

class StaffService
{
    public function joinToInterview(string $firstName, string $lastName, string $email, string $date): Interview
    {
        $interview = Interview::join($firstName, $lastName, $email, $date);
        $interview->save(false);

        if ($interview->email) {
            Yii::$app->mailer->compose('interview/join', ['model' => $this])
            ->setFrom(Yii::$app->params['adminEmail'])
            ->setTo($this->email)
            ->setSubject('You are joined to interview')
            ->send();
        }

        $log = new Log();
        $log->message = $interview->last_name . ' ' . $interview->first_name . ' is joined to inteview';
        $log->save();

        return $interview;
    }
}