<?php

namespace Torpedo\CqrsBundle\Command;

use InvalidArgumentException;
use ReflectionClass;
use ReflectionParameter;
use Torpedo\CQRS\Command\CanNotDeserialize;
use Torpedo\CQRS\Command\Command;
use Torpedo\CQRS\Command\CommandDeserializer;

final class JsonCommandDeserializer implements CommandDeserializer
{
    /**
     * @param mixed $serialized
     * @return Command
     */
    public function deserialize($serialized)
    {
        $decoded = $this->decode($serialized);

        $fqcn = $this->normalize($decoded->commandName);
        $this->guardThatCommandClassExists($fqcn);

        $reflectionClass = new ReflectionClass($fqcn);
        $this->guardThatCommandHasConstructor($reflectionClass);

        $parameters = $reflectionClass->getConstructor()->getParameters();
        $arguments = $this->buildArgumentList($decoded->payload, $parameters);

        $command = $reflectionClass->newInstanceArgs($arguments);

        return $command;
    }

    /**
     * @param $fqcn
     * @return string
     */
    private function normalize($fqcn)
    {
        $fqcn = str_replace('.', '\\', trim($fqcn));
        return (substr($fqcn, 0, 1) !== '\\') ? '\\' . $fqcn : $fqcn;
    }

    /**
     * @param $json
     * @throws InvalidArgumentException
     * @return mixed
     */
    private function decode($json)
    {
        $decoded = json_decode($json);
        $this->assertValidJson($decoded);
        $this->assertCommandName($decoded);
        $this->assertPayload($decoded);
        return $decoded;
    }

    /**
     * @param $decoded
     * @throws CanNotDeserialize
     */
    private function assertPayload($decoded)
    {
        if (!property_exists($decoded, 'payload')) {
            throw new CanNotDeserialize("Missing field payload in json");
        }

        if (!is_object($decoded->payload)) {
            throw new CanNotDeserialize("Payload should be an object");
        }
    }

    /**
     * @param $decoded
     * @throws CanNotDeserialize
     */
    private function assertValidJson($decoded)
    {
        if (is_null($decoded)) {
            throw new CanNotDeserialize("Couldn't decode json");
        }
    }

    /**
     * @param $decoded
     * @throws CanNotDeserialize
     */
    private function assertCommandName($decoded)
    {
        if (!property_exists($decoded, 'commandName')) {
            throw new CanNotDeserialize("Missing field commandName in json");
        }

        if (!is_string($decoded->commandName)) {
            throw new CanNotDeserialize("commandName should be a string");
        }
    }

    /**
     * @param \ReflectionClass $reflectionClass
     * @throws CanNotDeserialize
     */
    private function guardThatCommandHasConstructor(ReflectionClass $reflectionClass)
    {
        if (!$reflectionClass->getConstructor()) {
            throw new CanNotDeserialize("The Command does not have a constructor");
        }
    }

    /**
     * @param $payload
     * @param ReflectionParameter $parameter
     * @throws CanNotDeserialize
     */
    private function guardThatPayloadHasParameterIfRequired($payload, ReflectionParameter $parameter)
    {
        $payloadHasParameter = property_exists($payload, $parameter->getName());

        if (!$payloadHasParameter && !$parameter->isOptional()) {
            throw new CanNotDeserialize(sprintf('The parameter [%s] is missing from the Command payload. Add it to the payload or make it optional in the Command constructor.',
                $parameter->name));
        }
    }

    /**
     * @param $payload
     * @param ReflectionParameter[] $parameters
     * @return array
     */
    private function buildArgumentList($payload, array $parameters)
    {
        $arguments = [];
        $remainingProperties = get_object_vars($payload);

        foreach ($parameters as $parameter) {
            $this->guardThatPayloadHasParameterIfRequired($payload, $parameter);
            unset($remainingProperties[$parameter->name]);
            $payloadHasParameter = property_exists($payload, $parameter->name);
            $arguments[] = $payloadHasParameter ? $payload->{$parameter->name} : $parameter->getDefaultValue();
        }

        $this->guardThatThereAreNoAlienProperties($remainingProperties);

        return $arguments;
    }

    /**
     * @param $remainingProperties
     * @throws CanNotDeserialize
     */
    private function guardThatThereAreNoAlienProperties($remainingProperties)
    {
        if (!empty($remainingProperties)) {
            throw new CanNotDeserialize(sprintf('The parameters [%s] are never used in the Command payload. Remove them from the payload or make sure the Command\'s constructor has parameters with the same name.',
                implode(', ', array_keys($remainingProperties))));
        }
    }

    /**
     * @param $fqcn
     * @throws CanNotDeserialize
     */
    private function guardThatCommandClassExists($fqcn)
    {
        if (!class_exists($fqcn)) {
            throw new CanNotDeserialize("Class $fqcn does not exist. Did you include the full FQCN? Did you properly escape backslashes?");
        }
    }
}