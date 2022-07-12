<?php


namespace app\listeners\interview;


use app\events\interview\InterviewJoinEvent;
use app\services\interfaces\NotifierInterface;

class InterviewMoveListener
{
    private NotifierInterface  $notifier;

    public function __construct(NotifierInterface $notifier)
    {
        $this->notifier = $notifier;
    }

    public function handle(InterviewJoinEvent $event)
    {
        $this->notifier->notify(
            $event->interview->email,
            'interview/move',
            ['model' => $event->interview],
            'You are joiner to interview'
        );
    }
}