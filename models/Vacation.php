<?php

namespace app\models;

use lesson02\part3\demo04\Employee;
use yii\db\ActiveRecord;

/**
 * @property integer $id
 * @property integer $order_id
 * @property integer $employee_id
 * @property string $date_from
 * @property string $date_to
 */

class Vacation extends ActiveRecord
{
    public static function tableName()
    {
        return 'vacation';
    }

    public function rules()
    {
        return [
            [['order_id', 'employee_id', 'date_from', 'date_to'], 'required'],
            [['order_id', 'employee_id'], 'integer'],
            [['date_from', 'date_to'], 'safe'],

        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'order_id' => 'Order',
            'employee_id' => 'Employee',
            'date_from' => 'From',
            'date_to' => 'To',
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