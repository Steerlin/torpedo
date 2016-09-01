<?php


namespace Torpedo\EventSourcingBundle\EventPublisher;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;

final class EventPublisherCompilerPass implements CompilerPassInterface
{
    const CONTAINER_KEY = 'torpedo.event_sourcing.event_publisher';
    const TAG_KEY = 'torpedo.listens_synchronously_to_events';

    public function process(ContainerBuilder $container)
    {
        $eventPublisher = $container->getDefinition(self::CONTAINER_KEY);
        $taggedServices = $container->findTaggedServiceIds(self::TAG_KEY);
        foreach ($taggedServices as $taggedServiceKey => $attributes) {
            $eventPublisher->addMethodCall('registerKey', [$taggedServiceKey]);
        }
    }
}