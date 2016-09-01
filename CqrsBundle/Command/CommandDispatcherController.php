<?php

namespace Torpedo\CqrsBundle\Command;

use Doctrine\ORM\EntityManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Torpedo\CQRS\Command\Command;
use Torpedo\CQRS\Command\CommandDeserializer;
use Torpedo\CQRS\Command\CommandDispatcher;
use Torpedo\CQRS\Command\PublicCommand;

/**
 * @Route(service="torpedo_cqrs.command.command_dispatcher_controller")
 */
class CommandDispatcherController extends Controller
{
    /**
     * @var CommandDispatcher
     */
    private $commandDispatcher;

    /**
     * @var CommandDeserializer
     */
    private $commandDeserializer;

    /**
     * @var EntityManager
     */
    private $entityManager;

    public function __construct(
        CommandDispatcher $commandDispatcher,
        CommandDeserializer $commandDeserializer,
        EntityManager $entityManager
    ) {
        $this->commandDispatcher = $commandDispatcher;
        $this->commandDeserializer = $commandDeserializer;
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/api/command/dispatch")
     * @Method("POST")
     */
    public function dispatchCommand(Request $request)
    {
        $command = $this->commandDeserializer->deserialize($request->getContent());
        return $this->dispatch($command);
    }

    /**
     * @Route("/public/command/dispatch")
     * @Method("POST")
     */
    public function dispatchPublicCommand(Request $request)
    {
        $command = $this->commandDeserializer->deserialize($request->getContent());
        if (!$command instanceof PublicCommand) {
            throw new AccessDeniedHttpException();
        }
        return $this->dispatch($command);
    }

    /**
     * @param $command
     * @return JsonResponse
     */
    private function dispatch(Command $command)
    {
        $this->commandDispatcher->dispatch($command);
        $this->entityManager->flush();
        return new JsonResponse("OK");
    }

}