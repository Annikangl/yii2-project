<?php

namespace app\models;

use yii\db\ActiveRecord;

/**
 * @property integer $id
 * @property string $date
 */

class Order extends ActiveRecord
{
    public static function tableName()
    {
        return 'order';
    }

    public static function create($orderDate)
    {
        $order = new self();
        $order->date = $orderDate;

        return $order;
    }

    public function rules()
    {
        return [];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'date' => 'Date',
        ];
    }
}