<?php

namespace app\helpers;

use app\models\Employee;
use yii\helpers\ArrayHelper;

class EmployeeHelper
{
    public static function getStatusesList(): array
    {
        return [
            Employee::STATUS_PROBATION => 'Probation',
            Employee::STATUS_WORK => 'Work',
            Employee::STATUS_VACATION => 'Vacation',
            Employee::STATUS_DISMISS => 'Dismiss',
        ];
    }

    public static function getStatusName(int $status)
    {
        return ArrayHelper::getValue(self::getStatusesList(), $status);
    }
}