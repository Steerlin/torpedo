<?php


namespace Torpedo\EventSourcingBundle\RocketTestUseCase;


use Torpedo\CQRS\Command\CommandHandler;
use Torpedo\EventSourcing\EventPublisher;
use Torpedo\EventSourcingBundle\EventStream\InjectedEventStream;
use Torpedo\Time\Clock;

final class LaunchRocketCommandHandler implements CommandHandler
{
    private $eventPublisher;

    public function __construct(EventPublisher $eventPublisher)
    {
        $this->eventPublisher = $eventPublisher;
    }

    public function handle(LaunchRocket $command)
    {
        $event = new RocketWasLaunched(
            $command->getFrom(),
            $command->getTo()
        );
        $this->eventPublisher->publish(new InjectedEventStream([
            $event
        ]));

    }

}
