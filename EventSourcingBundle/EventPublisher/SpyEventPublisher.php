<?php


namespace Torpedo\EventSourcingBundle\EventPublisher;


use Torpedo\EventSourcing\EventPublisher;
use Torpedo\EventSourcing\EventStream;

final class SpyEventPublisher implements EventPublisher
{

    public function publish(EventStream $eventStream)
    {
        // TODO: Implement publish() method.
    }

}
