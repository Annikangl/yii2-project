<?php

namespace app\repository;

use app\models\Contract;
use http\Exception\RuntimeException;

class ContractRepository
{
    public function find($id): ?Contract
    {
        if (!$Contract = Contract::findOne($id)) {
            throw new \DomainException('Interview not found');
        }

        return $Contract;
    }

    public function add(Contract $Contract)
    {
        if (!$Contract->getIsNewRecord()) {
            throw new RuntimeException('Saving new model');
        }

        if (!$Contract->insert(false)) {
            throw new RuntimeException('Saving error');
        }
    }

    public function save(Contract $Contract)
    {
        if ($Contract->getIsNewRecord()) {
            throw new RuntimeException('Saving new model');
        }

        if ($Contract->update(false) === false) {
            throw new RuntimeException('Saving error.');
        }
    }

    public function delete(Contract $Contract)
    {
        if ($Contract->delete() === false) {
            throw new RuntimeException('Deleting error');
        }
    }
}