<?php

namespace app\models;

use yii\db\ActiveRecord;

/**
 * @property integer $id
 * @property string $created_at
 * @property integer $employee_id
 * @property integer $cost
 */

class Bonus extends ActiveRecord
{
    public static function tableName()
    {
        return 'bonus';
    }

    public function rules()
    {
        return [];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'created_at' => 'Created',
            'employee_id' => 'Employee',
            'cost' => 'Cost',
        ];
    }

    public function getEmployee()
    {
        return $this->hasOne(Employee::class, ['id' => 'employee_id']);
    }
}