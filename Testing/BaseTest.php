<?php

namespace Torpedo\Testing;

use Doctrine\ORM\EntityManager;
use PHPUnit_Framework_MockObject_MockObject;
use Symfony\Bundle\FrameworkBundle\Client;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\Exception\ServiceNotFoundException;

abstract class BaseTest extends WebTestCase
{
    /**
     * @var Client
     */
    protected $client;

    protected function setUp()
    {
        $this->client = parent::createClient();
    }

    /**
     * @return ContainerInterface
     */
    protected function getContainer()
    {
        return $this->client->getContainer();
    }

    /**
     * @return EntityManager
     */
    protected function getEntityManager()
    {
        return $this->getContainer()->get('doctrine.orm.entity_manager');
    }

    public function mockGuard($class) : PHPUnit_Framework_MockObject_MockObject
    {
        $guard = $this->getMock($class, [], [], '', false);
        $guard->method('ensure')->willReturn(true);
        $guard->method('isEnsured')->willReturn(true);
        return $guard;
    }

    /**
     * @param $key
     * @param $expectedType
     * @param string $message
     */
    protected function assertContainerKeyHasType($key, $expectedType, $message = null)
    {
        $message = $message ? $message . PHP_EOL : '';

        $container = $this->getContainer();

        try {
            $instantiatedService = $container->get($key);
            $this->assertInstanceOf(
                $expectedType,
                $instantiatedService,
                $message . "The service [$key] does not have the expected type [$expectedType]"
            );
        } catch (ServiceNotFoundException $e) {
            $suggested = sprintf(
                "<service id=\"%s\" class=\"%s\">\n\t<!-- arguments -->\n</service>",
                $key,
                $expectedType
            );
            $this->fail(
                $message . "\nThe service [$key] is not defined in the container.\nMaybe add the following to the container definition: \n\n$suggested\n" . PHP_EOL . $e->getMessage()
            );
        }
    }

}