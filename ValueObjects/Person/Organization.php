<?php

namespace Torpedo\ValueObjects\Person;


use Torpedo\ValueObjects\String\StringLiteral;

class Organization extends StringLiteral
{

    const TOERISME_LIMBURG = 'Toerisme Limburg';

    public static function ToerismeLimburg()
    {
        return new self(self::TOERISME_LIMBURG);
    }

    public function isToerismeLimburg()
    {
        return $this->equals(Organization::ToerismeLimburg());
    }
}