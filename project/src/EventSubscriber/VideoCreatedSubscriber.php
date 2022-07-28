<?php

namespace App\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\KernelEvent;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\KernelEvents;

class VideoCreatedSubscriber implements EventSubscriberInterface
{
    public function onVideoCreatedEvent($event)
    {
        dump('subscriber video handler');
    }

    public function onKernelResponse($event)
    {
        dump('subscriber response handler 1');
    }

    public function onKernelResponse2($event)
    {
        dump('subscriber response handler 2');
    }



    public static function getSubscribedEvents()
    {
        return [
           'video.created.event' => 'onVideoCreatedEvent',
           KernelEvents::RESPONSE => [
            ['onKernelResponse', 2],
            ['onKernelResponse2', 10],
        ]
    ];
    }
}
