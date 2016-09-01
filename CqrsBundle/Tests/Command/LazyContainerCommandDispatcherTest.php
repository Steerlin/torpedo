<?php
namespace Torpedo\CqrsBundle\Tests\Command;


use InvalidArgumentException;
use PHPUnit_Framework_MockObject_MockObject;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Torpedo\CQRS\Command\Command;
use Torpedo\CQRS\Command\CommandHandler;
use Torpedo\CqrsBundle\Command\LazyContainerCommandDispatcher;

final class LazyContainerCommandDispatcherTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var LazyContainerCommandDispatcher
     */
    private $commandDispatcher;

    /**
     * @var CommandHandler | PHPUnit_Framework_MockObject_MockObject
     */
    private $commandHandler;

    /**
     * @var ContainerInterface | PHPUnit_Framework_MockObject_MockObject
     */
    private $container;

    protected function setUp()
    {
        $this->container = $this->getMock(
            'Symfony\Component\DependencyInjection\ContainerInterface',
            get_class_methods('Symfony\Component\DependencyInjection\ContainerInterface'),
            [],
            '',
            false
        );
        $this->commandHandler = $this->getMock(CommandHandler::class, ['handle'], [], '', false);
        $this->commandDispatcher = new LazyContainerCommandDispatcher($this->container);
    }

    /**
     * @test
     */
    public function it_should_throw_when_command_classname_ends_in_command()
    {
        $this->setExpectedException(InvalidArgumentException::class);
        $this->commandDispatcher->dispatch(new TestCommandThatEndsInCommand());
    }

    /**
     * @test
     */
    public function it_should_find_the_right_CommandHandler_in_the_container_and_tell_it_to_handle_the_Command()
    {
        $this->container
            ->expects($this->once())
            ->method('get')
            ->with('torpedo.cqrs_bundle.tests.command.test_launch_rocket_command_handler')
            ->will($this->returnValue($this->commandHandler));

        $this->commandHandler
            ->expects($this->once())
            ->method('handle')
            ->with($this->isInstanceOf(Command::class));

        $this->commandDispatcher->dispatch(new TestLaunchRocket());

    }
}

final class TestCommandThatEndsInCommand implements Command
{
}

final class TestLaunchRocket implements Command
{
}