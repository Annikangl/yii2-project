<?php


namespace app\services;


use app\dispatchers\interfaces\EventDispatcherInterface;
use app\events\interview\InterviewEditEvent;
use app\events\interview\InterviewJoinEvent;
use app\events\interview\InterviewMoveEvent;
use app\models\Interview;
use app\repository\InterviewRepository;

class InterviewService
{
    private InterviewRepository $interviewRepository;
    private EventDispatcherInterface $eventDispatcher;

    public function __construct($interviewRepository, $eventDispatcher)
    {
        $this->interviewRepository = $interviewRepository;
        $this->eventDispatcher = $eventDispatcher;
    }

    public function joinToInterview(string $firstName, string $lastName, string $email, string $date): Interview
    {
        $interview = Interview::join($firstName, $lastName, $email, $date);
        $this->interviewRepository->add($interview);

        $this->eventDispatcher->dispatch(new InterviewJoinEvent($interview));

        return $interview;
    }

    public function editInterview($id, $firstName, $lastName, $email)
    {
        $interview = $this->interviewRepository->find($id);
        $interview->editData($firstName, $lastName, $email);
        $interview->save(false);

        $this->eventDispatcher->dispatch(new InterviewEditEvent($interview));
    }

    public function move($id, $date)
    {
        $interview = $this->interviewRepository->find($id);
        $interview->move($date);
        $this->interviewRepository->save($interview);

        $this->eventDispatcher->dispatch(new InterviewMoveEvent($interview));
    }

    public function reject($id, $reason)
    {
        $interview = $this->interviewRepository->find($id);
        $interview->reject($reason);
        $this->interviewRepository->save($interview);
    }

    public function delete($id)
    {
        $interview = $this->interviewRepository->find($id);
        $interview->remove();
        $this->interviewRepository->delete($interview);
    }
}