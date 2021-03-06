<?php


namespace app\listeners\interview;


use app\events\interview\InterviewJoinEvent;
use app\services\interfaces\NotifierInterface;

class InterviewRejectListener
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
            'interview/reject',
            ['model' => $event->interview],
            'You are failed an interview'
        );
    }
}