<?php

namespace app\services;

use app\models\Interview;

class StaffService
{
    private \InterviewRepository $interviewRepository;
    private \NotifierInterface $notifier;
    private \LoggerInterface $logger;

    public function __construct(\InterviewRepository $interviewRepository, \NotifierInterface $notifier, \LoggerInterface  $logger)
    {
        $this->interviewRepository = $interviewRepository;
        $this->notifier = $notifier;
        $this->logger = $logger;
    }

    public function joinToInterview(string $firstName, string $lastName, string $email, string $date): Interview
    {
        $interview = Interview::join($firstName, $lastName, $email, $date);
        $this->interviewRepository->add($interview);

        $this->notifier->notify($interview->email, 'interview/join', ['model' => $interview], 'You are joined to interview');
        $this->logger->log($interview->last_name . ' ' . $interview->first_name . ' is joined to interview');

        return $interview;
    }

    public function editInterview($id, $firstName, $lastName, $email)
    {
        $interview = $this->interviewRepository->find($id);
        $interview->editData($firstName, $lastName, $email);
        $interview->save(false);

        $this->logger->log('Interview ' . $interview->id . ' is updated');
    }

    public function move($id, $date)
    {
        $interview = $this->interviewRepository->find($id);
        $interview->move($date);
        $this->interviewRepository->save($interview);

        $this->notifier->notify($interview->email, 'interview/mode', ['model' => $interview], 'Your interview is moved');
        $this->logger->log('Interview ' . $interview->id . ' is move ' . $interview->date);
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