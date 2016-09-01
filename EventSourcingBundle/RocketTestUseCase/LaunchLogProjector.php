<?php


namespace Torpedo\EventSourcingBundle\RocketTestUseCase;


use Torpedo\EventSourcingBundle\Projector\ConventionBasedProjector;

final class LaunchLogProjector extends ConventionBasedProjector
{
    private $launchLogReadModelRepository;

    public function __construct(LaunchLogReadModelRepository $launchLogReadModelRepository)
    {
        $this->launchLogReadModelRepository = $launchLogReadModelRepository;
    }

    public function projectRocketWasLaunched(RocketWasLaunched $event)
    {
        $logEntree = new LogEntree(
            $event->getFrom(),
            $event->getTo()
        );
        $this->launchLogReadModelRepository->add($logEntree);
    }

    public function erase()
    {
        $this->launchLogReadModelRepository->erase();
    }

}
