<?php


namespace Torpedo\EventSourcingBundle\Projector;


use Torpedo\EventSourcing\DomainEvent;
use Torpedo\EventSourcing\EventListener;
use Torpedo\EventSourcing\EventStream;
use Torpedo\EventSourcing\Projector;

abstract class ConventionBasedProjector implements Projector, EventListener
{

    public function notifyThat(EventStream $eventStream)
    {
        $this->project($eventStream);
    }

    public function project(EventStream $eventStream)
    {
        /** @var $domainEvent DomainEvent */
        foreach ($eventStream as $domainEvent) {

            $shortClassName = $this->getShortClassName($domainEvent);
            $methodName = "project" . $shortClassName;
            if (!method_exists($this, $methodName)) {
                continue;
            }
            $this->$methodName($domainEvent);
        }
    }

    private function getShortClassName(DomainEvent $domainEvent)
    {
        $exploded = explode('\\', get_class($domainEvent));
        $end = end($exploded);
        return $end;
    }
}
