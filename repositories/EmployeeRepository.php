<?php

namespace app\repository;

use app\models\Employee;
use http\Exception\RuntimeException;

class EmployeeRepository
{
    public function find($id): ?Employee
    {
        if (!$employee = Employee::findOne($id)) {
            throw new \DomainException('Interview not found');
        }

        return $employee;
    }

    public function add(Employee $employee)
    {
        if (!$employee->getIsNewRecord()) {
            throw new RuntimeException('Saving new model');
        }

        if (!$employee->insert(false)) {
            throw new RuntimeException('Saving error');
        }
    }

    public function save(Employee $employee)
    {
        if ($employee->getIsNewRecord()) {
            throw new RuntimeException('Saving new model');
        }

        if ($employee->update(false) === false) {
            throw new RuntimeException('Saving error.');
        }
    }

    public function delete(Employee $employee)
    {
        if ($employee->delete(false) === false) {
            throw new RuntimeException('Deleting error');
        }
    }
}