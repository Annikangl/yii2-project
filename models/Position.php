<?php

namespace app\models;

use yii\db\ActiveRecord;

/**
 * @property integer $id
 * @property string $name
 */

class Position extends ActiveRecord
{
    public static function tableName()
    {
        return 'position';
    }

    public function rules()
    {
        return [
            [['name'], 'string', 'max' => 255]
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
        ];
    }
}