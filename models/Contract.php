<?php

namespace app\models;

use yii\db\ActiveRecord;

/**
 * @property integer $id
 * @property integer $employee_id
 * @property string $first_name
 * @property string $last_name
 * @property string $date_open
 * @property string $date_close
 * @property string $close_reason
 */

class Contract extends ActiveRecord
{
    public static function tableName()
    {
        return 'contract';
    }

    public static function create(Employee $employee, string $lastName, string $firstName, $contractDate)
    {
        $contract = new self();
        $contract->populateRelation('employee', $employee);
        $contract->first_name = $firstName;
        $contract->last_name = $lastName;
        $contract->date_open = date('Y-m-d');
        $contract->date_close = $contractDate;

        return $contract;
    }

    public function rules()
    {
        return [
            [['employee_id'], 'required'],
            [['first_name', 'last_name'], 'required', 'string'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'order_id' => 'Order',
            'employee_id' => 'Employee',
            'position_id' => 'Position',
            'date' => 'Date',
            'rate' => 'Rate',
            'salary' => 'Salary',
        ];
    }

    public function getEmployee()
    {
        return $this->hasOne(Employee::class, ['id' => 'employee_id']);
    }

    public function getOrder()
    {
        return $this->hasOne(Order::class, ['id' => 'order_id']);
    }

    public function getPosition()
    {
        return $this->hasOne(Position::class, ['id' => 'postiion_id']);
    }

    public function beforeSave($insert): bool
    {
        if (parent::beforeSave($insert)) {
            $related = $this->getRelatedRecords();

            if (isset($related['employee']) && $employee = $related['employee']) {
                $employee->save();
                $this->employee_id = $employee->id;
            }
            return true;
        }
        return false;
    }
}