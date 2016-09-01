<?php

namespace Torpedo\ORM;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository as DoctrineORMEntityRepository;
use Doctrine\ORM\Persisters\PersisterException;

abstract class EntityRepository extends DoctrineORMEntityRepository
{
    /**
     * @param ObjectManager $objectManager
     * @param string $entityClassName
     * @throws PersisterException
     */
    public function __construct(ObjectManager $objectManager, $entityClassName)
    {
        if (!class_exists($entityClassName)) {
            throw new \InvalidArgumentException("Expected a valid Entity FQCN, got [$entityClassName]");
        }

        $entityClassName = preg_replace("@^\\\@", '', $entityClassName); // remove heading backslash for doctrine
        if ($objectManager instanceof EntityManager) {
            parent::__construct($objectManager, $objectManager->getClassMetadata($entityClassName));
        } else {
            throw new PersisterException("Trying to instantiate an EntityRepository without EntityManager");
        }

    }
}