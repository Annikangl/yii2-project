<?php


namespace app\events\interview;


use app\events\Event;
use app\models\Interview;
use app\services\interfaces\LoggerInterface;

class InterviewMoveEvent extends Event implements LoggerInterface
{
    public Interview $interview;

    public function __construct(Interview  $interview)
    {
        $this->interview = $interview;
    }

    public function getLogMessage($message)
    {
        // TODO: Implement getLogMessage() method.
    }
}