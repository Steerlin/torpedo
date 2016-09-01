<?php

namespace Torpedo\EventSourcingBundle;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;
use Torpedo\EventSourcingBundle\EventPublisher\EventPublisherCompilerPass;

class EventSourcingBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        parent::build($container);
        $container->addCompilerPass(new EventPublisherCompilerPass);
    }
}