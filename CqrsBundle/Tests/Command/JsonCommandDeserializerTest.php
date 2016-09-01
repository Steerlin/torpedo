<?php

namespace Torpedo\CqrsBundle\Tests\Command;

use PHPUnit_Framework_TestCase;
use Torpedo\CQRS\Command\CanNotDeserialize;
use Torpedo\CQRS\Command\Command;
use Torpedo\CqrsBundle\Command\JsonCommandDeserializer;

final class JsonCommandDeserializerTest extends PHPUnit_Framework_TestCase
{
    const MY_FAKE_COMMAND = <<<JSON
{
    "commandName": "Torpedo.CqrsBundle.Tests.Command.MyFakeCommand",
    "payload": {
        "thingDate": "2013-08-27 09:35:00",
        "thingId": "MyId123",
        "listOfThings": [
            "Nice thing",
            "Cool thing"
        ]
    }
}
JSON;

    const MISSING_PARAMETER = <<<JSON
{
    "commandName": "Torpedo.CqrsBundle.Tests.Command.MyFakeCommand",
    "payload": {
        "thingDate": "2013-08-27 09:35:00",
        "listOfThings": [
            "Nice thing",
            "Cool thing"
        ]
    }
}
JSON;

    const NONEXISTANT_COMMAND_NAME = <<<JSON
{
    "commandName": "There.Is.No.Such.Class",
    "payload": {
        "thingDate": "2013-08-27 09:35:00",
        "thingId": "MyId123",
        "listOfThings": [
            "Nice thing",
            "Cool thing"
        ]
    }
}
JSON;

    const PAYLOAD_IS_NOT_OBJECT = <<<JSON
{
    "commandName": "Torpedo.CqrsBundle.Tests.Command.MyFakeCommand",
    "payload": "not an object"
}
JSON;

    const COMMAND_NAME_IS_NOT_STRING = <<<JSON
{
    "commandName": {"a": "b"},
    "payload": {
        "thingDate": "2013-08-27 09:35:00",
        "thingId": "MyId123",
        "listOfThings": [
            "Nice thing",
            "Cool thing"
        ]
    }
}
JSON;

    const MISSING_COMMAND_NAME = <<<JSON
{
    "payload": {
        "thingDate": "2013-08-27 09:35:00",
        "thingId": "MyId123",
        "listOfThings": [
            "Nice thing",
            "Cool thing"
        ]
    }
}
JSON;

    const MISSING_PAYLOAD = <<<JSON
{
    "commandName": "Torpedo.CqrsBundle.Tests.Command.MyFakeCommand"
}
JSON;

    const MY_FAKE_COMMAND_WITH_OPTIONAL_PARAMETER = <<<JSON
{
    "commandName": "Torpedo.CqrsBundle.Tests.Command.MyFakeCommandWithOptionalParameter",
    "payload": {
        "thingId": "MyId123"
    }
}
JSON;
    const PAYLOAD_HAS_ALIEN_PARAMETER = <<<JSON
{
    "commandName": "Torpedo.CqrsBundle.Tests.Command.MyFakeCommand",
    "payload": {
        "thingDate": "2013-08-27 09:35:00",
        "thingId": "MyId123",
        "listOfThings": [
            "Nice thing",
            "Cool thing"
        ],
        "alienThing": "This parameter should make the deserialization fail."
    }
}
JSON;

    /**
     * @var JsonCommandDeserializer
     */
    private $commandDeserializer;

    protected function setUp()
    {
        $this->commandDeserializer = new JsonCommandDeserializer();
    }

    public static function provideJsonCommands()
    {
        return array(
            'MyFakeCommand' => array(
                'json' => self::MY_FAKE_COMMAND,
                'expected' => new MyFakeCommand('MyId123', '2013-08-27 09:35:00', ['Nice thing', 'Cool thing']),
            ),
            'MyFakeCommandWithOptionalParameter' => array(
                'json' => self::MY_FAKE_COMMAND_WITH_OPTIONAL_PARAMETER,
                'expected' => new MyFakeCommandWithOptionalParameter('MyId123'),
            ),
        );
    }

    /**
     * @test
     * @dataProvider provideJsonCommands
     * @param $json
     * @param $expected
     */
    public function it_should_deserialize_json_into_a_command($json, Command $expected)
    {
        $deserialized = $this->commandDeserializer->deserialize($json);
        $this->assertEquals($expected, $deserialized);
    }

    /**
     * @test
     */
    public function it_should_throw_for_missing_commandName()
    {
        $this->setExpectedException(CanNotDeserialize::class);
        $this->commandDeserializer->deserialize(self::MISSING_COMMAND_NAME);
    }

    /**
     * @test
     */
    public function it_should_throw_for_alien_parameter()
    {
        $this->setExpectedException(CanNotDeserialize::class);
        $this->commandDeserializer->deserialize(self::PAYLOAD_HAS_ALIEN_PARAMETER);
    }

    /**
     * @test
     */
    public function it_should_throw_when_commandName_is_not_string()
    {
        $this->setExpectedException(CanNotDeserialize::class);
        $this->commandDeserializer->deserialize(self::COMMAND_NAME_IS_NOT_STRING);
    }

    /**
     * @test
     */
    public function it_should_throw_when_payload_is_not_object()
    {
        $this->setExpectedException(CanNotDeserialize::class);
        $this->commandDeserializer->deserialize(self::PAYLOAD_IS_NOT_OBJECT);
    }

    /**
     * @test
     */
    public function it_should_throw_for_missing_payload()
    {
        $this->setExpectedException(CanNotDeserialize::class);
        $this->commandDeserializer->deserialize(self::MISSING_PAYLOAD);
    }

    /**
     * @test
     */
    public function it_should_throw_for_non_existent_commandName()
    {
        $this->setExpectedException(CanNotDeserialize::class);
        $this->commandDeserializer->deserialize(self::NONEXISTANT_COMMAND_NAME);
    }

    /**
     * @test
     */
    public function it_should_throw_when_a_parameter_is_missing()
    {
        $this->setExpectedException(
            CanNotDeserialize::class,
            'The parameter [thingId] is missing from the Command payload. Add it to the payload or make it optional in the Command constructor.'
        );
        $this->commandDeserializer->deserialize(self::MISSING_PARAMETER);
    }
}