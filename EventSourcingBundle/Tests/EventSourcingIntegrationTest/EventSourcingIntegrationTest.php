<?php


namespace Torpedo\EventSourcingBundle\Tests\EventSourcingIntegrationTest;


use Torpedo\CQRS\Command\CommandDispatcher;
use Torpedo\EventSourcingBundle\RocketTestUseCase\LaunchLogReadModelRepository;
use Torpedo\EventSourcingBundle\RocketTestUseCase\LaunchRocket;
use Torpedo\Testing\TransactionalTest;
use Torpedo\Time\PausedClock;

final class EventSourcingIntegrationTest extends TransactionalTest
{
    /**
     * @var CommandDispatcher
     */
    private $commandDispatcher;

    /**
     * @var LaunchLogReadModelRepository
     */
    private $launchLog;

    protected function setUp()
    {
        parent::setUp();
        $this->commandDispatcher = $this->getContainer()->get('cqrs.command.command_dispatcher');
        $this->launchLog = $this->getContainer()
                                ->get('torpedo_event_sourcing.rocket_test_use_case.launch_log_read_model_repository');
    }

    /**
     * @test
     */
    public function should_integrate()
    {
        $command = new LaunchRocket('Earth', 'Moon');
        $this->commandDispatcher->dispatch($command);

        $log = $this->launchLog->all();
        $expected = <<<JSON
[
    {
        "to": "Moon",
        "from": "Earth"
    }
]
JSON;

        $this->assertEquals($expected, json_encode($log, JSON_PRETTY_PRINT));
    }


}
