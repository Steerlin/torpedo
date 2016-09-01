<?php


namespace Torpedo\EventSourcing;


interface RecordsEvents
{

    public function recordThat(DomainEvent $domainEvent);

    public function getRecordedEvents(): EventStream;

}
