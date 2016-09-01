<?php

namespace Torpedo\Uuid;

use Ramsey\Uuid\Uuid as RamseyUuid;

final class UuidFactory
{
    /**
     * @return string
     */
    public static function random()
    {
        return RamseyUuid::uuid4()->toString();
    }

}