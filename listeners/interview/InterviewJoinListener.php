<?php


namespace app\listeners\interview;


use app\events\interview\InterviewJoinEvent;
use app\services\interfaces\NotifierInterface;

class InterviewJoinListener
{
    private NotifierInterface $notifier;

    public function __construct(NotifierInterface $notifier)
    {
        $this->notifier = $notifier;
    }

    public function handle(InterviewJoinEvent $event)
    {
        $this->notifier->notify(
            $event->interview->email,
            'interview/join',
            ['model' => $event->interview],
            'You are joiner to interview'
        );
    }
}