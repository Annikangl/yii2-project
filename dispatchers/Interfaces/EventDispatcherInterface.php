<?php

namespace app\dispatchers\interfaces;

use app\events\Event;

interface EventDispatcherInterface
{
    public function dispatch(Event $event);
}