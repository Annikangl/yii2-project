<?php

namespace app\forms;

use app\models\Interview;
use yii\base\Model;

class InterviewRejectForm extends Model
{
    public string $reason;


    public function rules(): array
    {
        return [
            [['reason'], 'required'],
            [['reason'], 'string'],
        ];
    }

    public function attributes(): array
    {
        return [
            'reason' => 'Reject reason',
        ];
    }
}