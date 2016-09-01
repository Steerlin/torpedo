<?php


namespace Torpedo\EventSourcingBundle\ProcessManager;


use Torpedo\EventSourcing\DomainEvent;
use Torpedo\EventSourcing\EventListener;
use Torpedo\EventSourcing\EventStream;

abstract class ConventionBasedProcessManager implements EventListener
{

    public function notifyThat(EventStream $eventStream)
    {
        $this->reactTo($eventStream);
    }

    public function reactTo(EventStream $eventStream)
    {
        /** @var $domainEvent DomainEvent */
        foreach ($eventStream as $domainEvent) {

            $shortClassName = $this->getShortClassName($domainEvent);
            $methodName = "reactTo" . $shortClassName;
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
