<?php


use app\dispatchers\interfaces\EventDispatcherInterface;
use app\events\Event;
use app\services\interfaces\LoggerInterface;

class LoggerEventDispatcher implements EventDispatcherInterface
{
    private $next;
    private $loggger;

    public function __construct(EventDispatcherInterface $next, LoggerInterface $logger)
    {
        $this->next = $next;
        $this->loggger = $logger;
    }

    public function dispatch(Event $event)
    {
        $this->next->dispatch($event);
        if ($event instanceof \app\events\LoggerEvent) {
            $this->loggger->getLogMessage($event->getLogMessage());
        }
    }
}