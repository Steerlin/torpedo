<?php


namespace Torpedo\EventSourcingBundle\RocketTestUseCase;


final class LaunchLogReadModelRepository
{

    private $logEntrees = [];

    public function add(LogEntree $logEntree) {
        $this->logEntrees[] = $logEntree;
    }

    public function erase()
    {
        $this->logEntrees = [];
    }

    public function all(): array
    {
        return $this->logEntrees;
    }

}
