<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\debug\models\search\Log;

/**
 * @property integer $id
 * @property string $first_name
 * @property string $last_name
 * @property string $address
 * @property string $email
 * @property string $status
 */

class Employee extends ActiveRecord
{
    const STATUS_PROBATION = 1;
    const STATUS_WORK = 2;
    const STATUS_VACATION = 3;
    const STATUS_DISMISS = 4;

    const SCENARIO_CREATE = 'create';

    public $order_date;
    public $contract_date;
    public $recruit_date;

    public function afterSave($insert, $changedAttributes)
    {
        if (in_array('status', array_keys($changedAttributes)) && $this->status != $changedAttributes['status']) {
            if ($this->status == self::STATUS_PROBATION) {
                if ($this->email) {
                    Yii::$app->mailer->compose('employee/join', ['model' => $this])
                        ->setFrom(Yii::$app->params['adminEmail'])
                        ->setTo($this->email)
                        ->setSubject('You are joined to interview')
                        ->send();
                }
                $log = new Log();
                $log->message = $this->first_name . $this->last_name . 'joined to interview';
                $log->save();
            } elseif ($this->status == self::STATUS_WORK) {
                if ($this->email) {
                    Yii::$app->mailer->compose('employee/work', ['model' => $this])
                        ->setFrom(Yii::$app->params['adminEmail'])
                        ->setTo($this->email)
                        ->setSubject('You are rectuit') 
                        ->send();
                }
                $log = new Log();
                $log->message = $this->first_name . $this->last_name . ' is passed an interview';
                $log->save();
            } elseif ($this->status == self::STATUS_DISMISS) {
                if ($this->email) {
                    Yii::$app->mailer->compose('employee/dismiss', ['model' => $this])
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

    public function getFullName(): string
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    public static function tableName()
    {
        return 'employee';
    }

    public function rules()
    {
        return [
            [['first_name', 'last_name', 'email'], 'string', 'max' => 255],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'first_name' => 'First Name',
            'last_name' => 'Last Name',
            'address' => 'Address',
            'email' => 'Email',
            'status' => 'Status',
        ];
    }

    public function getAssignments()
    {
        return $this->hasMany(Assignment::class, ['employee_id' => 'id']);
    }

    public function getDismisses()
    {
        return $this->hasMany(Dismiss::class, ['employee_id' => 'id']);
    }

    public function getBonuses()
    {
        return $this->hasMany(Bonus::class, ['employee_id' => 'id']);
    }

    public function getRecruits()
    {
        return $this->hasMany(Recruit::class, ['employee_id' => 'id']);
    }
}