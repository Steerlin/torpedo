<?php


namespace Torpedo\EventSourcingBundle\RocketTestUseCase;


use Torpedo\EventSourcing\DomainEvent;

final class RocketWasLaunched implements DomainEvent
{
    private $from;
    private $to;

    public function __construct(string $from, string $to)
    {
        $this->from = $from;
        $this->to = $to;
    }

    /**
     * @return string
     */
    public function getFrom(): string
    {
        return $this->from;
    }

    /**
     * @return string
     */
    public function getTo(): string
    {
        return $this->to;
    }

}
