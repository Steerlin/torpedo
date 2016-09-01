<?php

namespace Torpedo\EventSourcingBundle\EventPublisher;

use Torpedo\EventSourcing\DomainEvent;
use Torpedo\EventSourcing\EventStream;
use Torpedo\EventSourcingBundle\EventStream\InjectedEventStream;

trait EventRecorderTrait
{

    private $recordedEvents = [];

    public function recordThat(DomainEvent $domainEvent)
    {
        $this->recordedEvents[] = $domainEvent;
    }

    public function getRecordedEvents(): EventStream
    {
        return new InjectedEventStream($this->recordedEvents);
    }
}