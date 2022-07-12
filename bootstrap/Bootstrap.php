<?php


use app\services\interfaces\LoggerInterface;
use app\services\interfaces\NotifierInterface;
use app\services\Notifier;
use app\services\Logger;
use yii\base\BootstrapInterface;

class Bootstrap implements BootstrapInterface
{
    public function bootstrap($app)
    {
        $container = Yii::$container;

        $container->setSingleton(NotifierInterface::class, function () use ($app) {
            return new Notifier($app->params['adminEmail']);
        });

        $container->setSingleton(LoggerInterface::class, Logger::class);

        $container->setSingleton(\app\dispatchers\interfaces\EventDispatcherInterface::class, function (\yii\di\Container $container) {
           return new LoggerEventDispatcher(
               new SimpleEventDispatcher([
                   'app\events\interview\InterviewJoinEvent' => ['app\listeners\interview\InterviewJoinListener'],
                   'app\events\interview\InterviewMoveEvent' => ['app\listeners\interview\InterviewMoveListener'],
                   'app\events\interview\InterviewRejectEvent' => ['app\listeners\interview\InterviewRejectListener'],
           ]),
            $container->get(LoggerInterface::class)
           );
        });
    }
}