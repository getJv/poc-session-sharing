<?php

namespace App\EventSubscriber;

use JPM\SessionSharingBundle\Service\JpmSessionClient;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ControllerEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class SessionManagerSubscriber implements EventSubscriberInterface
{
    public function __construct(
        private JpmSessionClient $remoteAppHelper,
    ){}

    public function onKernelController(ControllerEvent $event): void
    {
        $this->remoteAppHelper->watchSessionRefresh($event);
    }

    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::CONTROLLER => 'onKernelController',
        ];
    }
}
