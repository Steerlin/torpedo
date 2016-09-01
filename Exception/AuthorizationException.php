<?php

namespace Torpedo\Exception;

use Exception;
use ToerismeWerkt\WriteModel\User\BaseRole;

class AuthorizationException extends Exception
{
    /**
     * @return AuthorizationException
     */
    public static function noLoggedInUser()
    {
        return new self("No logged in user found");
    }

    /**
     * @param BaseRole $givenRole
     * @param string $expectedRoleClass
     * @return AuthorizationException
     */
    public static function roleNotInstanceOf(BaseRole $givenRole, $expectedRoleClass)
    {
        return new self("Role should be instance of $expectedRoleClass. $givenRole given.");
    }

    /**
     * @param BaseRole $givenRole
     * @param BaseRole[] $roles
     * @return AuthorizationException
     */
    public static function roleNotOneOf(BaseRole $givenRole, array $roles)
    {
        $message = "Role should be one of [";
        foreach ($roles as $role) {
            $message .= (string)$role . ',';
        }
        $message .= "]. $givenRole given.";
        return new self($message);
    }
}