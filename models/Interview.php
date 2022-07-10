<?php

namespace app\models;

use lesson02\part3\demo04\Employee;
use Yii;
use yii\db\ActiveRecord;
use yii\debug\models\search\Log;

/**
 * @property integer $id
 * @property string $date
 * @property string $first_name
 * @property string $last_name
 * @property string $email
 * @property string $status
 * @property string $reject_reason
 * @property integer $employee_id
 */

class Interview extends ActiveRecord
{
    const SCENARIO_CREATE = 'create';

    const STATUS_NEW = 1;
    const STATUS_PASS = 2;
    const STATUS_REJECT = 3;

    public function getNextStatusesList(): array
    {
        if ($this->status === self::STATUS_PASS) {
            return [
                self::STATUS_PASS => 'Passed'
            ];
        } elseif ($this->status === self::STATUS_REJECT) {
            return [
                self::STATUS_REJECT => 'Rejected',
                self::STATUS_PASS => 'Passed'
            ];
        } else {
            return [
                self::STATUS_NEW => 'New',
                self::STATUS_REJECT => 'Rejected',
                self::STATUS_PASS => 'Passed'
            ]
        }
    }

    public function afterSave($insert, $changedAttributes)
    {
        if (in_array('status', array_keys($changedAttributes)) && $this->status != $changedAttributes['status']) {
            if ($this->status == self::STATUS_NEW) {
                if ($this->email) {
                    Yii::$app->mailer->compose('interview/join', ['model' => $this])
                        ->setFrom(Yii::$app->params['adminEmail'])
                        ->setTo($this->email)
                        ->setSubject('You are joined to interview')
                        ->send();
                }
                $log = new Log();
                $log->message = $this->first_name . $this->last_name . 'joined to interview';
                $log->save();
            } elseif ($this->status == self::STATUS_PASS) {
                if ($this->email) {
                    Yii::$app->mailer->compose('interview/pass', ['model' => $this])
                        ->setFrom(Yii::$app->params['adminEmail'])
                        ->setTo($this->email)
                        ->setSubject('You are passed to interview')
                        ->send();
                }
                $log = new Log();
                $log->message = $this->first_name . $this->last_name . ' is passed an interview';
                $log->save();
            } elseif ($this->status == self::STATUS_REJECT) {
                if ($this->email) {
                    Yii::$app->mailer->compose('interview/reject', ['model' => $this])
                        ->setFrom(Yii::$app->params['adminEmail'])
                        ->setTo($this->email)
                        ->setSubject('You are failed to interview')
                        ->send();
                }
                $log = new Log();
                $log->message = $this->first_name . $this->last_name . ' failed an interview';
                $log->save();
            }
        }

        parent::afterSave($insert, $changedAttributes);
    }

    public static function join(string $firstName, string $lastName, string $email, string $date)
    {
        $interview = new Interview();

        $interview->first_name = $firstName;
        $interview->last_name = $lastName;
        $interview->date = $date;
        $interview->email = $email;
        $interview->status = self::STATUS_NEW;

        return $interview;
    }

    public static function tableName()
    {
        return 'intervies';
    }

    public function rules()
    {
        return [
            [['date', 'first_name', 'last_name', 'status'], 'required'],
            [['status'], 'required', 'except' => self::SCENARIO_CREATE],
            [['status'], 'default', 'value' => self::STATUS_NEW],
            [['date'], 'safe'],
            [['reject_reason', 'required', 'when' => function (self $model) {
                    return $model->status == self::STATUS_REJECT;
                }, 'whenClient' => "functuin (attribute, value) {
                    return $('#interview-status').val() == '" .self::STATUS_REJECT."'
                }"
            ]],
            [['status', 'employee_id'], 'integer'],
            [['first_name', 'last_name', 'email'], 'string', 'max' => 255],
            [['reject_reason'], 'string'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'date' => 'Date',
            'first_name' => 'First Name',
            'last_name' => 'Last Name',
            'email' => 'Email',
            'status' => 'Status',
            'reject_reason' => 'Reject Reason',
            'employee_id' => 'Employee'
        ];
    }

    public function getEmployee()
    {
        return $this->hasOne(Employee::class, ['id' => 'employee_id']);
    }
}