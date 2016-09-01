<?php


namespace Torpedo\EventSourcingBundle\EventStream;


use Torpedo\EventSourcing\DomainEvent;
use Torpedo\EventSourcing\EventStream;

class InjectedEventStream implements EventStream
{
    /**
     * @var DomainEvent[]
     */
    private $domainEvents = [];

    public function __construct(array $domainEvents)
    {
        foreach ($domainEvents as $domainEvent) {
            $this->addDomainEvent($domainEvent);
        }
    }

    public function add(array $events)
    {
        $merged = array_merge(array_values($this->domainEvents), array_values($events));
        return new InjectedEventStream($merged);
    }

    private function addDomainEvent(DomainEvent $domainEvent)
    {
        $this->domainEvents[] = $domainEvent;
    }

    /**
     * @return DomainEvent[]
     */
    public function getDomainEvents()
    {
        return array_values($this->domainEvents);
    }

    /**
     * @return DomainEvent
     */
    public function current()
    {
        return current($this->domainEvents);
    }

    /**
     * @return string
     */
    public function key()
    {
        return key($this->domainEvents);
    }

    /**
     * @return void
     */
    public function next()
    {
        next($this->domainEvents);
    }

    /**
     * @return bool
     */
    public function valid()
    {
        $key = key($this->domainEvents);
        return ($key !== null && $key !== false);
    }

    /**
     * @return void
     */
    public function rewind()
    {
        reset($this->domainEvents);
    }

    /**
     * (PHP 5 &gt;= 5.1.0)<br/>
     * Count elements of an object
     * @link http://php.net/manual/en/countable.count.php
     * @return int The custom count as an integer.
     * </p>
     * <p>
     * The return value is cast to an integer.
     */
    public function count()
    {
        return count($this->domainEvents);
    }
}
