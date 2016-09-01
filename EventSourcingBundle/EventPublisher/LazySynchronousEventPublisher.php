<?php


namespace Torpedo\EventSourcingBundle\EventPublisher;


use Symfony\Component\DependencyInjection\Container;
use Torpedo\EventSourcing\EventListener;
use Torpedo\EventSourcing\EventPublisher;
use Torpedo\EventSourcing\EventStream;

final class LazySynchronousEventPublisher implements EventPublisher
{
    /**
     * @var EventListener[]
     */
    private $listeners = [];

    /**
     * @var Container
     */
    private $container;

    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    /**
     * @param EventStream $eventStream
     */
    public function publish(EventStream $eventStream)
    {
        foreach ($this->listeners as $key => $listener) {

            if (!$listener) {
                $listener = $this->container->get($key);
                $this->listeners[$key] = $listener;
            }

            $listener->notifyThat($eventStream);
        }
    }

    public function registerKey($key)
    {
        if (!array_key_exists($key, $this->listeners)) {
            $this->listeners[$key] = null;
        }
    }
}