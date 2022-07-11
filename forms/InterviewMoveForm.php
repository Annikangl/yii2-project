<?php


namespace app\forms;


use yii\base\Model;

class InterviewMoveForm extends Model
{
    public $date;

    public function rules()
    {
        return [
            [['date'], 'date', 'format' => 'php:Y-m-d'],
        ];
    }

    public function attributes()
    {
        return [
            'date' => 'Date'
        ];
    }
}