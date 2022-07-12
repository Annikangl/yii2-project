<?php

namespace app\models;

use yii\db\ActiveRecord;

/**
 * @property integer $id
 * @property integer $order_id
 * @property integer $employee_id
 * @property string $date
 */

class Recruit extends ActiveRecord
{
    public static function tableName()
    {
        return 'position';
    }

    public static function create(Employee $employee, Order $order, $recruitDate)
    {
        $recruit = new self();
        $recruit->populateRelation('employee', $employee);
        $recruit->populateRelation('order', $order);
        $recruit->date = $recruitDate;

        return $recruit;
    }

    public function rules()
    {
        return [
            [['date'], 'string', 'max' => 255]
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'order_id' => 'Order',
            'employee_id' => 'Employee',
            'date' => 'Date',
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
}