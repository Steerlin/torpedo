<?php

namespace Torpedo\Uuid;

use InvalidArgumentException;
use JsonSerializable;

abstract class Identifier implements Prefixed, JsonSerializable
{
    /**
     * @var string
     */
    protected $identifier;

    public function __construct($identifier)
    {
        $this->validate($identifier);
        $this->identifier = $identifier;
    }

    /**
     * @param $identifier
     * @return bool
     */
    public function isValid($identifier)
    {
        try {
            $this->validate($identifier);
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * @return mixed
     */
    public static function random()
    {
        $prefix = '';
        if (!empty(static::getPrefix())) {
            $prefix = static::getPrefix() . '-';
        }
        return new static($prefix . UuidFactory::random());
    }

    /**
     * @param $string
     * @return Identifier
     */
    public static function fromString($string)
    {
        return new static($string);
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return (string)$this->identifier;
    }

    /**
     * @return string
     */
    public function jsonSerialize()
    {
        return $this->__toString();
    }

    /**
     * @param Identifier $other
     * @return bool
     */
    public function equals(Identifier $other = null)
    {
        if ($other == null) {
            return false;
        }
        return $this->identifier == $other->identifier;
    }

    protected function validate($identifier)
    {
        if (empty($identifier)) {
            throw new InvalidArgumentException('Non-empty string expected for Identifier, got: ' . $identifier);
        }
        if ($this->getPrefix() != "" && strpos($identifier, $this->getPrefix()) !== 0) {
            throw new InvalidArgumentException('Identifier does not start with prefix "' . $this->getPrefix() . '", got: ' . $identifier);
        }
    }

    /**
     * @param $identifierStrings
     * @return Identifier[]
     */
    public static function map($identifierStrings)
    {
        $identifiers = [];
        foreach ($identifierStrings as $identifierString) {
            $identifiers[] = new static($identifierString);
        }
        return $identifiers;
    }
}