<?php

namespace app\repository;

use app\models\Interview;
use DomainException;
use http\Exception\RuntimeException;

class InterviewRepository
{
    public function find($id): ?Interview
    {
        if (!$interview = Interview::findOne($id)) {
            throw new DomainException('Interview not found');
        }

        return $interview;
    }

    public function add(Interview  $interview)
    {
        if (!$interview->getIsNewRecord()) {
            throw new RuntimeException('Saving new model');
        }

        if (!$interview->insert(false)) {
            throw new RuntimeException('Saving error');
        }
    }

    public function save(Interview $interview)
    {
        if ($interview->getIsNewRecord()) {
            throw new RuntimeException('Saving new model');
        }

        if ($interview->update(false) === false) {
            throw new RuntimeException('Saving error.');
        }
    }

    public function delete(?Interview $interview)
    {
        if ($interview->delete() === false) {
            throw new RuntimeException('Deleting error');
        }
    }
}