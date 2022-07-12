<?php


use app\dispatchers\interfaces\EventDispatcherInterface;
use app\events\Event;

class SimpleEventDispatcher implements EventDispatcherInterface
{
    private array $listeners = [];

    public function __construct(array $listeners)
    {
        $this->listeners = $listeners;
    }

    public function dispatch(Event $event)
    {
        $eventName = get_class($event);
        if (isset($this->listeners[$eventName])) {
            foreach ($this->listeners[$eventName] as $listener) {
                call_user_func([Yii::createObject($listener), 'handle'], $event);
            }
        }
    }
}