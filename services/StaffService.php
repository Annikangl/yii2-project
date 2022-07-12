<?php

namespace app\services;

use app\dispatchers\interfaces\EventDispatcherInterface;
use app\events\interview\InterviewEditEvent;
use app\events\interview\InterviewJoinEvent;
use app\events\interview\InterviewMoveEvent;
use app\models\Interview;
use app\repository\InterviewRepository;


class StaffService
{
    private InterviewRepository $interviewRepository;
    private EventDispatcherInterface $eventDispatcher;

    public function __construct(InterviewRepository $interviewRepository, EventDispatcherInterface $eventDispatcher)
    {
        $this->interviewRepository = $interviewRepository;
        $this->eventDispatcher = $eventDispatcher;
    }


}