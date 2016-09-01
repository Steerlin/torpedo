<?php

namespace Torpedo\CQRS\Command;

use Exception;

final class CommandHandlerException extends Exception
{

    public static function notFound($handlerKey, $handlerClassName)
    {
        $message = <<<MESSAGE
The CommandHandler $handlerKey was not found in the DI container. Please add this to the service.xml:

<service id="$handlerKey" class="$handlerClassName">
    <!-- <argument type="service" id="some.collaborator.key"/>
</service>
MESSAGE;
        return new static($message);
    }

} 