<?php

namespace app\repository;

use app\models\Position;
use http\Exception\RuntimeException;

class PositionRepository
{
    public function find($id): ?Position
    {
        if (!$Position = Position::findOne($id)) {
            throw new \DomainException('Interview not found');
        }

        return $Position;
    }

    public function add(Position $Position)
    {
        if (!$Position->getIsNewRecord()) {
            throw new RuntimeException('Saving new model');
        }

        if (!$Position->insert(false)) {
            throw new RuntimeException('Saving error');
        }
    }

    public function save(Position $Position)
    {
        if ($Position->getIsNewRecord()) {
            throw new RuntimeException('Saving new model');
        }

        if ($Position->update(false) === false) {
            throw new RuntimeException('Saving error.');
        }
    }

    public function delete(Position $Position)
    {
        if ($Position->delete() === false) {
            throw new RuntimeException('Deleting error');
        }
    }
}