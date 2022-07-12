<?php

namespace app\repository;

use app\models\Recruit;
use DomainException;
use http\Exception\RuntimeException;

class RecruitRepository
{
    public function find($id): ?Recruit
    {
        if (!$Recruit = Recruit::findOne($id)) {
            throw new DomainException('Interview not found');
        }

        return $Recruit;
    }

    public function add(Recruit $Recruit)
    {
        if (!$Recruit->getIsNewRecord()) {
            throw new RuntimeException('Saving new model');
        }

        if (!$Recruit->insert(false)) {
            throw new RuntimeException('Saving error');
        }
    }

    public function save(Recruit $Recruit)
    {
        if ($Recruit->getIsNewRecord()) {
            throw new RuntimeException('Saving new model');
        }

        if ($Recruit->update(false) === false) {
            throw new RuntimeException('Saving error.');
        }
    }

    public function delete(Recruit $Recruit)
    {
        if ($Recruit->delete() === false) {
            throw new RuntimeException('Deleting error');
        }
    }
}