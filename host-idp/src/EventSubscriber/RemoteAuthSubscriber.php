<?php

namespace App\EventSubscriber;

use JPM\SessionSharingBundle\Service\JpmSessionClient;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class RemoteAuthSubscriber implements EventSubscriberInterface
{

    public function __construct(
        private JpmSessionClient $remoteAppHelper
    ){}
    public function onKernelResponse(ResponseEvent $event): void
    {
        $this->remoteAppHelper->watchRemoteSessionRequest($event);
    }

    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::RESPONSE => 'onKernelResponse',
        ];
    }
}
