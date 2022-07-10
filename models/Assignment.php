<?php

namespace app\models;

use yii\db\ActiveRecord;

/**
 * @property integer $id
 * @property integer $order_id
 * @property integer $employee_id
 * @property integer $position_id
 * @property string $date
 * @property integer $rate
 * @property integer $salary
 */

class Assignment extends ActiveRecord
{
    public static function tableName()
    {
        return 'assignment';
    }

    public function rules()
    {
        return [];
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
}