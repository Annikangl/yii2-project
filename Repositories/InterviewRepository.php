<?php


use app\models\Interview;

class InterviewRepository
{
    public function find($id): ?Interview
    {
        if (!$interview = Interview::findOne($id)) {
            throw new \DomainException('Interview not found');
        }

        return $interview;
    }

    public function add(Interview  $interview)
    {
        if (!$interview->getIsNewRecord()) {
            throw new \http\Exception\RuntimeException('Saving new model');
        }

        if (!$interview->insert(false)) {
            throw new \http\Exception\RuntimeException('Saving error');
        }
    }

    public function save(Interview $interview)
    {
        if ($interview->getIsNewRecord()) {
            throw new \http\Exception\RuntimeException('Saving new model');
        }

        if ($interview->update(false) === false) {
            throw new \http\Exception\RuntimeException('Saving error.');
        }
    }

    public function delete(?Interview $interview)
    {
        if ($interview->delete(false) === false) {
            throw new \http\Exception\RuntimeException('Deleting error');
        }
    }
}