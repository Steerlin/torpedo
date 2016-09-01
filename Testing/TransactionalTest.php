<?php

namespace Torpedo\Testing;

abstract class TransactionalTest extends BaseTest
{
    protected function setUp()
    {
        parent::setUp();
        $this->getEntityManager()->getConnection()->beginTransaction();
    }

    public function tearDown()
    {
        $this->getEntityManager()->getConnection()->rollBack();
        $this->getEntityManager()->clear();
    }
}