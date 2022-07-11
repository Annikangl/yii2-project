<?php

namespace app\services\interfaces;

interface NotifierInterface
{
    public function notify($email, $view, $data, $subject);
}