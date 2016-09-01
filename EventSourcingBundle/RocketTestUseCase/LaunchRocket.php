<?php


namespace Torpedo\EventSourcingBundle\RocketTestUseCase;


use Torpedo\CQRS\Command\Command;

final class LaunchRocket implements Command
{

    private $from;
    private $to;

    public function __construct(string $from, string $to)
    {
        $this->from = $from;
        $this->to = $to;
    }

    public function getFrom(): string
    {
        return $this->from;
    }

    public function getTo(): string
    {
        return $this->to;
    }

}
