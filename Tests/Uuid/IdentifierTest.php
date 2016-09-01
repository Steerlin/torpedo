<?php

namespace Torpedo\Tests\Uuid;

use PHPUnit_Framework_TestCase;
use Torpedo\Uuid\Identifier;

class IdentifierTest extends PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function should_throw_on_empty_value()
    {
        $this->setExpectedException('InvalidArgumentException');
        new FooIdentifier('');
    }

    /**
     * @test
     */
    public function should_to_string()
    {
        $this->assertEquals('Foo-123456789', (string)new FooIdentifier('Foo-123456789'));
    }

    /**
     * @test
     */
    public function should_have_equality()
    {
        $a = new FooIdentifier('Foo-123456789');
        $b = new FooIdentifier('Foo-123456789');
        $c = new FooIdentifier('Foo-987654321');
        $this->assertTrue($a->equals($a));
        $this->assertTrue($b->equals($a));
        $this->assertTrue($a->equals($b));
        $this->assertFalse($a->equals($c));
        $this->assertFalse($c->equals($a));
    }

    /**
     * @test
     */
    public function it_should_create_random_instance()
    {
        $fooIdentifier = FooIdentifier::random();
        $this->assertNotEmpty(str_replace($fooIdentifier->getPrefix(), '', $fooIdentifier));
    }
}

class FooIdentifier extends Identifier
{
    public static function getPrefix()
    {
        return "Foo-";
    }
}