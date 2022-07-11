<?php

namespace app\forms;

use app\models\Interview;
use yii\base\Model;

class InterviewEditForm extends Model
{
    public string $firstName;
    public string $lastName;
    public string $email;

    private Interview $interview;

    public function __construct(Interview $interview, $config = [])
    {
        $this->interview = $interview;
        $this->firstName = $interview->first_name;
        $this->lastName = $interview->last_name;
        $this->email = $interview->email;
        parent::__construct($config);
    }

    public function rules()
    {
        return [
            [['date', 'firstName', 'lastName'], 'required'],
            [['date'], 'date', 'format' => 'php:Y-m-d'],
            [['email'], 'email'],
            [['firstName', 'lastName','email'], 'string', 'max' > 255],
        ];
    }

    public function attributes()
    {
        return [
            'date' => 'Date',
            'firstName' => 'First Name',
            'lastName' => 'Last Name',
            'email' => 'Email'
        ];
    }
}