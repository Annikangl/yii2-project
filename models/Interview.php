<?php

namespace app\models;

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
    const STATUS_NEW = 1;
    const STATUS_PASS = 2;
    const STATUS_REJECT = 3;

    public static function join(string $firstName, string $lastName, string $email, string $date): Interview
    {
        $interview = new Interview();

        $interview->first_name = $firstName;
        $interview->last_name = $lastName;
        $interview->date = $date;
        $interview->email = $email;
        $interview->status = self::STATUS_NEW;

        return $interview;
    }

    public function editData($firstName, $lastName, $email): void
    {
        $this->first_name = $firstName;
        $this->last_name = $lastName;
        $this->email = $email;
    }

    public function reject($reason): void
    {
        $this->guardInNotRejected();
        $this->reject_reason = $reason;
        $this->status = self::STATUS_REJECT;
    }

    public function move($date): void
    {
        $this->date = $date;
    }

    public function remove()
    {
        $this->guardIsNew();
    }

    public function passBy(Employee $employee)
    {
        $this->guardIsNotPassed();
        $this->populateRelation('employee', $employee);
        $this->status = self::STATUS_PASS;
    }

    public function isNew(): bool
    {
        return $this->status == self::STATUS_NEW;
    }

    public function isPassed(): bool
    {
        return $this->status == self::STATUS_PASS;
    }

    public function isRejected(): bool
    {
        return $this->status == self::STATUS_REJECT;
    }

    public static function tableName()
    {
        return 'intervies';
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

    private function guardInNotRejected()
    {
        if ($this->isRejected()) {
            throw new \DomainException('Interview is already rejected');
        }
    }

    private function guardIsNotPassed()
    {
        if (!$this->isPassed()) {
            throw new \DomainException('Interview is already passed');
        }
    }


    private function guardIsNew()
    {
        if (!$this->isNew()) {
            throw new \DomainException('Interview is not new');
        }
    }




}