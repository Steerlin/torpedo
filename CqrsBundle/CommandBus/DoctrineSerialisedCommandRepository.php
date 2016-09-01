<?php


namespace Torpedo\CqrsBundle\CommandBus;


use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\DBAL\LockMode;
use Torpedo\Exception\EntityNotFound;
use Torpedo\ORM\EntityRepository;

final class DoctrineSerialisedCommandRepository extends EntityRepository implements SerialisedCommandRepository
{

    public function __construct(ObjectManager $objectManager)
    {
        parent::__construct($objectManager, SerialisedCommand::class);
    }

    public function add(SerialisedCommand $serialisedCommand)
    {
        $this->getEntityManager()->persist($serialisedCommand);
    }

    public function findFirstToDo(string $queueName): SerialisedCommand
    {
        /** @var SerialisedCommand $serialisedCommand */
        $serialisedCommand = $this->findOneBy(
            ['status' => SerialisedCommand::TO_DO, 'queueName' => $queueName],
            ['sequence' => 'ASC']);

        if ($serialisedCommand) {

            try {
                /** @var SerialisedCommand $lockedSerialisedCommand */
                $lockedSerialisedCommand = $this->find($serialisedCommand->getId(), LockMode::PESSIMISTIC_WRITE);
                $lockedSerialisedCommand->markInProgress();
                $this->getEntityManager()->flush($lockedSerialisedCommand);
                return $lockedSerialisedCommand;
            } catch (\Exception $e) {
                throw $e;
            }

        }

        throw EntityNotFound::forType(SerialisedCommand::class);
    }

    public function remove(SerialisedCommand $serialisedCommand)
    {
        $this->getEntityManager()->remove($serialisedCommand);
    }
}
