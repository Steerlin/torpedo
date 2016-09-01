<?php

namespace Torpedo\CqrsBundle\Command;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\Exception\ServiceNotFoundException;
use Torpedo\CQRS\Command\Command;
use Torpedo\CQRS\Command\CommandDispatcher;
use Torpedo\CQRS\Command\CommandHandler;
use Torpedo\CQRS\Command\CommandHandlerException;
use Torpedo\Exception\InvalidArgumentException;
use Verraes\ClassFunctions\ClassFunctions;

/**
 * Finds the matching HandlesCommands
 */
final class LazyContainerCommandDispatcher implements CommandDispatcher
{
    /**
     * @var ContainerInterface
     */
    private $container;

    public function __construct($container)
    {
        $this->container = $container;
    }

    public function dispatch(Command $domainCommand)
    {
        $this->guardThatThereIsAContainer();
        $fqcn = get_class($domainCommand);
        $this->guardThatFqcnDoesntEndInCommand($fqcn);

        $commandHandler = $this->getCommandHandler($domainCommand);
        $commandHandler->handle($domainCommand);
    }

    /**
     * @param $fqcn
     * @throws InvalidArgumentException
     */
    private function guardThatFqcnDoesntEndInCommand($fqcn)
    {
        if ('command' == strtolower(substr($fqcn, -7))) {
            throw new InvalidArgumentException("Command class names should not end in 'Command', [$fqcn] given");
        }
    }

    private function guardThatThereIsAContainer()
    {
        if (is_null($this->container)) {
            throw new \Exception("Container isn't set");
        }
    }

    /**
     * @param $commandHandler
     * @throws InvalidArgumentException
     */
    private function guardInstanceOfCommandHandler($commandHandler)
    {
        if (!$commandHandler instanceof CommandHandler) {
            throw InvalidArgumentException::doesNotImplement(get_class($commandHandler), CommandHandler::class);
        }
    }

    /**
     * @param Command $command
     * @throws CommandHandlerException
     * @return CommandHandler
     */
    private function getCommandHandler(Command $command)
    {
        $className = ClassFunctions::fqcn($command) . 'CommandHandler';
        $serviceKey = ClassFunctions::underscore($command) . '_command_handler';
        try {
            /** @var $commandHandler CommandHandler */
            $commandHandler = $this->container->get($serviceKey);
        } catch (ServiceNotFoundException $exception) {
            throw CommandHandlerException::notFound($serviceKey, $className);
        }
        $this->guardInstanceOfCommandHandler($commandHandler);
        return $commandHandler;
    }
}