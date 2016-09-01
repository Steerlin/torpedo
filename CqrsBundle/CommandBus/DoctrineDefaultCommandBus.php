<?php


namespace Torpedo\CqrsBundle\CommandBus;


use Torpedo\CQRS\Command\Command;
use Torpedo\CQRS\Command\CommandBus;
use Torpedo\CQRS\Command\CommandDispatcher;
use Torpedo\Exception\EntityNotFound;

class DoctrineDefaultCommandBus implements CommandBus
{

    /**
     * @var SerialisedCommandRepository
     */
    private $serialisedCommandRepository;

    /**
     * @var CommandDispatcher
     */
    private $commandDispatcher;

    public function __construct(
        SerialisedCommandRepository $serialisedCommandRepository,
        CommandDispatcher $commandDispatcher
    ) {
        $this->serialisedCommandRepository = $serialisedCommandRepository;
        $this->commandDispatcher = $commandDispatcher;
    }

    public function queue(Command $command)
    {
        $serialisedCommand = new SerialisedCommand(
            $command,
            $this->getQueueName()
        );
        $this->serialisedCommandRepository->add($serialisedCommand);
    }

    /**
     * Dispatches the next command on the queue, or waits until a new command is available
     * @return void
     */
    public function dispatchNext()
    {
        try {
            $serialisedCommand = $this->serialisedCommandRepository->findFirstToDo($this->getQueueName());
            try {
                $this->commandDispatcher->dispatch($serialisedCommand->getCommand());
                $this->serialisedCommandRepository->remove($serialisedCommand);
            } catch (\Exception $e) {
                $serialisedCommand->markFailed($e->getMessage());
            }

        } catch (EntityNotFound $e) {
            // there is no next command to be dispatched - do nothing
        }

    }

    protected function getQueueName(): string
    {
        return 'DEFAULT_QUEUE';
    }
}
